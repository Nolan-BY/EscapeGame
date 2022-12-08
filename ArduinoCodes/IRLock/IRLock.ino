/*
   Reception infrarouge pour verrou magnétique
*/

#include <IRremote.h>

int broche_reception = 11; // Broche 11 utilisée pour la réception
IRrecv reception_ir(broche_reception); // Crée une instance de réception
decode_results decode_ir; // Décodage et stockage des données reçues

// Initialisation du bon code à avoir 
String code = "1671805516718055167430451672417516738455";
String test_code = "";
String msg = "";

void setup() {
  Serial.begin(9600);
  reception_ir.enableIRIn(); // Démarre la réception
  pinMode(3, OUTPUT); // Led bleue pour retour utilisateur lorsqu'une touche est pressée
  pinMode(4, OUTPUT); // Led rouge pour erreur dans le code
  pinMode(5, OUTPUT); // Led verte pour code bon
}

void loop() {
    if (test_code.length() != code.length()) {
      if (reception_ir.decode(&decode_ir)) {
        msg = decode_ir.value;
        Serial.println(msg);
        
        if (msg.substring(0,3) == "167") {
          test_code.concat(msg);
          Serial.println(test_code);
          digitalWrite(3, HIGH);
          delay(100); 
        }
        reception_ir.resume(); // Reçoit le prochain code
      }
    }
    else {
      if (test_code == code) {
        digitalWrite(5, HIGH);
        test_code = "";
        delay(1000);
      }
      else {
        digitalWrite(4, HIGH);
        test_code = "";
        delay(1000); 
      }
    }
  delay(100);
  digitalWrite(3, LOW);
  delay(100);
  digitalWrite(4, LOW);
  digitalWrite(5, LOW);
}