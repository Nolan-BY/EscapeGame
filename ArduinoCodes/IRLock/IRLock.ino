#include <IRremote.h>
#include <SoftwareSerial.h>
#include <SerialESP8266wifi.h>

// Serial config
#define sw_serial_rx_pin 11  // Pin to TX
#define sw_serial_tx_pin 12  // Pin to RX
#define esp8266_reset_pin 13 // Pin to CH_PD, not reset
SoftwareSerial swSerial(sw_serial_rx_pin, sw_serial_tx_pin);

SerialESP8266wifi wifi(swSerial, swSerial, esp8266_reset_pin, Serial);

// User config
#define ssid "ArduinoEarth" // Wifi SSID
#define password "chevre007" // Wifi Password

String inputString;

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
  inputString.reserve(20);
  swSerial.begin(9600);
  reception_ir.enableIRIn(); // Démarre la réception
  pinMode(BLUE, OUTPUT); // Led bleue pour retour utilisateur lorsqu'une touche est pressée
  pinMode(RED, OUTPUT); // Led rouge pour erreur dans le code
  pinMode(GREEN, OUTPUT); // Led verte pour code bon
  pinMode(BUZZER, OUTPUT);
  pinMode(LOCK, OUTPUT);
  digitalWrite(LOCK, HIGH);

  while (!Serial);
  Serial.println("Starting wifi");
  wifi.setTransportToTCP();
  wifi.endSendWithNewline(true);
  wifi.begin();
  wifi.connectToAP(ssid, password);
  wifi.connectToServer("192.168.59.54", "9999");
}

void loop() {
  if (!wifi.isStarted()) {
    wifi.begin();
  }

  if (test_code.length() != code.length()) {
    if (reception_ir.decode(&decode_ir)) {
      msg = decode_ir.value;
      Serial.println(msg);
      
      // if (msg.substring(0,3) == "167") {
        test_code.concat(msg);
        Serial.println(test_code);
        digitalWrite(2, HIGH);
        tone(BUZZER, 300, 50);
        delay(100);
        noTone(BUZZER);
        delay(100);
      //}
      reception_ir.resume(); // Reçoit le prochain code
    }
  }
  else {
    if (test_code == code) {
      wifi.send(SERVER, "LoR");
      digitalWrite(4, HIGH);
      analogWrite(LOCK, LOW);
      tone(BUZZER, 400, 250);
      delay(500);
      noTone(BUZZER);
      test_code = "";
      delay(10000);
    }
    else {
      wifi.send(SERVER, "LoF");
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