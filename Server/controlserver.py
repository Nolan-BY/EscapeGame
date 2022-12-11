"""
Serveur de control des arduinos de l'escape game
"""

import socket, sys, shutil, os

class ServeurTCP():
    def __init__(self):
        self.serveur = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        try:
            self.serveur.bind(('', 9999))
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
                requete = connexion.recv(1024)
                print("\nMessage>", requete.decode("utf-8"))
            connexion.send("Connexion fermée ! Au revoir".encode("utf-8"))
            print("Connexion interrompue.")
            connexion.close()

if __name__ == "__main__":
    ServeurTCP()