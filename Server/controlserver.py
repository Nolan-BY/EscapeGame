"""
Serveur de contrôle des arduinos de l'escape game
"""

import socket, sys

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

            enigmas = {"Sy": "Sismomètre",
                        "Lo": "Verrou IR",
                        "Si": "Simon"}

            while True:
                message = connexion.recv(1024).decode("utf-8")
                print("\nMessage>", message)
                if message == "PEnd":
                    print("Connexion interrompue.")
                    connexion.close()
                elif message in ["SyE", "SyR"]:
                    self.arduino.send(message.encode())
                
                if message != "SyE":
                    # JSON Code here
                    pass

if __name__ == "__main__":
    ServeurTCP()