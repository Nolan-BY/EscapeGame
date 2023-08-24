"""
Escape game arduino enigmas control server

/!\ Program without WiFi!
Codes must be typed by hand on a remote machine by connecting to the server via "ncat @IP 9999" /!\
"""

import socket, sys, os, json, threading, signal
from datetime import datetime, timedelta, timezone
import mysql.connector as sql

class ServeurTCP():
    def __init__(self):
        self.serveur = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.arduino = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.program_end = False
        try:
            self.serveur.bind(('', 9999))
        except socket.error:
            print("The socket connection failed miserably !")
            sys.exit(1)
        self.connexion()

    def connexion(self):
        while True:
            print("Server ready ! Waiting requests...")
            self.serveur.listen(5)
            connexion, adresse = self.serveur.accept()
            print("Client connected. Address : " + adresse[0])
            thread = threading.Thread(target=self.traitement_connexion, args=(connexion, adresse))
            thread.start()

    def traitement_connexion(self, connexion, adresse):
        enigmas = {"Sy": "Sismomètre",
                    "Lo": "Verrou IR",
                    "Si": "Simon",
                    "As": "Asterisk"}
        
        status = {"R": "Réussie",
                    "E": "Échouée"}
        
        message_error = 0
        
        while True:
            if self.program_end == True:
                print("Connection interrupted.")
                os.kill(os.getpid(), signal.SIGINT)
            else:
                message = connexion.recv(1024).decode("utf-8").strip()
                print("\nMessage>", message, "\n")
                if message == "PEnd":
                    self.program_end = True
                
                elif message in ["SyR", "LoR", "LoE", "SiR", "SiE", "AsR"]:
                    db = sql.connect(host="127.0.0.1", database='escape_game_DB', user="controlEG", password="controlEGPa55")
                    cursor = db.cursor()
                    cursor.execute("SELECT result FROM gamecontrol LIMIT 1")
                    data = cursor.fetchone()

                    if data[0] not in ["win", "lost"]:
                        if os.path.exists('/home/escape_game/logs/game-logs.json'):
                            with open("/home/escape_game/logs/game-logs.json", "r") as logFile:
                                logs = json.load(logFile)
                                logFile.close()
                            enigma_r_present = False
                            for i in range(len(logs['logs'])):
                                if logs['logs'][i]['enigma'] == enigmas[message[:2]] and logs['logs'][i]['status'] == 'Réussie':
                                    enigma_r_present = True
                                    break
                            if enigma_r_present == False:
                                if message[-1] == "E":
                                    cursor.execute("UPDATE gamecontrol SET penalties=penalties+10 LIMIT 1")
                                    cursor.execute("UPDATE gamecontrol SET result_enigmas=result_enigmas-10 LIMIT 1")
                                elif message[-1] == "R":
                                    cursor.execute("UPDATE gamecontrol SET result_enigmas=result_enigmas+5 LIMIT 1")

                                cursor.execute("SELECT finishdate, penalties, hints FROM gamecontrol LIMIT 1")
                                data = cursor.fetchone()

                                penalties = data[1]
                                hints = data[2]

                                finishdate = datetime.strptime(data[0], '%a, %d %b %Y %H:%M:%S %z').replace(tzinfo=timezone(timedelta(hours=1), "Europe/Paris"))
                                now = datetime.now(timezone(timedelta(hours=1), "Europe/Paris")).timestamp()
                                timeRemaining = ((finishdate.timestamp() - penalties) - now)

                                log = {
                                    "id": message[:2] + str(int(timeRemaining)),
                                    "enigma": enigmas[message[:2]],
                                    "time": datetime.fromtimestamp(now, timezone(timedelta(hours=1), "Europe/Paris")).strftime('%H:%M:%S'),
                                    "status": status[message[-1]],
                                    "time_left": int(timeRemaining),
                                    "penalties": penalties,
                                    "hints": hints
                                }
                                logs['logs'].append(log)
                                with open("/home/escape_game/logs/game-logs.json", "w") as logFile:
                                    json.dump(logs, logFile, indent=4)
                                    logFile.close()
                        else:
                            print("The log file does not exist!\nPerhaps the game hasn't started yet, or some other error has occurred.")
                    db.commit()
                    db.close()
                else:
                    print("The message " + message + " is not valid !\n")

                if message_error >= 10:
                    message_error = 0
                    print("/!\ Too much invalid messages ! \n Closing Thread !")
                    raise Exception('Thread closed ! Too much invalid messages !')

if __name__ == "__main__":
    ServeurTCP()