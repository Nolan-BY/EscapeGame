#include <IRremote.h>
#include <SoftwareSerial.h>
#include <SerialESP8266wifi.h>

// Serial config
#define sw_serial_rx_pin A0  // Pin to TX
#define sw_serial_tx_pin A1  // Pin to RX
#define esp8266_reset_pin A2 // Pin to CH_PD, not reset
SoftwareSerial swSerial(sw_serial_rx_pin, sw_serial_tx_pin);

SerialESP8266wifi wifi(swSerial, swSerial, esp8266_reset_pin, Serial);

// User config
#define ssid "ArduinoEarth" // Wifi SSID
#define password "totoearth" // Wifi Password

String inputString;

const int broche_reception = 7; // Broche 10 utilisée pour la réception
IRrecv reception_ir(broche_reception); // Crée une instance de réception
decode_results decode_ir; // Décodage et stockage des données reçues

// Initialisation du bon code à avoir
// String code = "167180551671805516718055";
String code = "1671805516718055167430451672417516738455";
String test_code = "";
String msg = "";

int keys = 0;

const int BLUE = 2;
const int RED = 3;
const int GREEN = 4;
const int BUZZER = 5;
const int LOCK = 6;

void setup() {
  Serial.begin(9600);
  swSerial.begin(9600);
  inputString.reserve(20);
  
  reception_ir.enableIRIn(); // Démarre la réception
  pinMode(BLUE, OUTPUT); // Led bleue pour retour utilisateur lorsqu'une touche est pressée
  pinMode(RED, OUTPUT); // Led rouge pour erreur dans le code
  pinMode(GREEN, OUTPUT); // Led verte pour code bon
  pinMode(BUZZER, OUTPUT);
  pinMode(LOCK, OUTPUT);
  digitalWrite(LOCK, HIGH);

  while(!Serial);
  Serial.println("Starting wifi");
  wifi.setTransportToTCP();
  wifi.endSendWithNewline(true);
  wifi.begin();
  wifi.connectToAP(ssid, password);
  wifi.connectToServer("10.11.5.10", "9999");
}

void loop() {
  // if (!wifi.isStarted()) {
  //   wifi.begin();
  // }

  if (test_code.length() != code.length()) {
    if (reception_ir.decode(&decode_ir)) {
      uint32_t msg = decode_ir.value;
      String msgstr;
      msgstr = String(int(msg));
      Serial.println(msgstr);
      
      if (keys != 5) {
        test_code.concat(msgstr);
        Serial.println(test_code);
        digitalWrite(BLUE, HIGH);
        tone(BUZZER, 300, 50);
        delay(100);
        noTone(BUZZER);
        delay(100);
        keys += 1;
      }
      reception_ir.resume(); // Reçoit le prochain code
    }
  }
  else {
    if (test_code == code) {
      digitalWrite(GREEN, HIGH);
      analogWrite(LOCK, LOW);
      tone(BUZZER, 400, 100);
      delay(500);
      noTone(BUZZER);
      test_code = "";
      // wifi.send(SERVER, "LoR");
      delay(10000);
      keys = 0;
    }
    else {
      digitalWrite(RED, HIGH);
      tone(BUZZER, 200, 50);
      delay(100);
      noTone(BUZZER);
      test_code = "";
      // wifi.send(SERVER, "LoE");
      delay(1000); 
      keys = 0;
    }
  }

  delay(100);
  digitalWrite(LOCK, HIGH);
  digitalWrite(BLUE, LOW);
  delay(100);
  digitalWrite(RED, LOW);
  digitalWrite(GREEN, LOW);
}