"""
Serveur de control des arduinos de l'escape game
"""

import socket, sys, shutil, os

class ServeurTCP():
    def __init__(self):
        self.serveur = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.arduino = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        try:
            self.serveur.bind(('', 9999))
            self.arduino.connect(("192.168.59.85",9990))
        except socket.error:
            print("La connexion du socket a échoué !")
            sys.exit()
        self.connexion()

    def connexion(self):
        while True:
            print("Serveur prêt ! En attente de requêtes...")
            self.serveur.listen(5)
            connexion, adresse = self.serveur.accept()
            print("Client connecté. Adresse : " + adresse[0])
            while True:
                message = connexion.recv(1024).decode("utf-8")
                print("\nMessage>", message)
                self.arduino.send(message.encode())
            print("Connexion interrompue.")
            connexion.close()

if __name__ == "__main__":
    ServeurTCP()