/*
   Reception infrarouge pour verrou magnétique
*/

#include <IRremote.h>

int broche_reception = 10; // Broche 10 utilisée pour la réception
IRrecv reception_ir(broche_reception); // Crée une instance de réception
decode_results decode_ir; // Décodage et stockage des données reçues

// Initialisation du bon code à avoir 
String code = "1671805516718055167430451672417516738455";
String test_code = "";
String msg = "";

const int BLUE = 2;
const int RED = 3;
const int GREEN = 4;
const int BUZZER = 5;
const int LOCK = 6;

void setup() {
  Serial.begin(9600);
  reception_ir.enableIRIn(); // Démarre la réception
  pinMode(BLUE, OUTPUT); // Led bleue pour retour utilisateur lorsqu'une touche est pressée
  pinMode(RED, OUTPUT); // Led rouge pour erreur dans le code
  pinMode(GREEN, OUTPUT); // Led verte pour code bon
  pinMode(BUZZER, OUTPUT);
  pinMode(LOCK, OUTPUT);
  digitalWrite(LOCK, HIGH);
}

void loop() {
    if (test_code.length() != code.length()) {
      if (reception_ir.decode(&decode_ir)) {
        msg = decode_ir.value;
        Serial.println(msg);
        
        if (msg.substring(0,3) == "167") {
          test_code.concat(msg);
          Serial.println(test_code);
          digitalWrite(2, HIGH);
          tone(BUZZER, 300, 50);
          delay(100);
          noTone(BUZZER);
          delay(100);
        }
        reception_ir.resume(); // Reçoit le prochain code
      }
    }
    else {
      if (test_code == code) {
        digitalWrite(4, HIGH);
        digitalWrite(LOCK, LOW);
        tone(BUZZER, 400, 250);
        delay(500);
        noTone(BUZZER);
        test_code = "";
        delay(10000);
      }
      else {
        digitalWrite(3, HIGH);
        tone(BUZZER, 200, 50);
        delay(100);
        noTone(BUZZER);
        test_code = "";
        delay(1000); 
      }
    }
  delay(100);
  digitalWrite(LOCK, HIGH);
  digitalWrite(2, LOW);
  delay(100);
  digitalWrite(3, LOW);
  digitalWrite(4, LOW);
}