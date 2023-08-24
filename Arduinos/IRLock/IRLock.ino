#include <IRremote.h>
#include <SoftwareSerial.h>
#include <SerialESP8266wifi.h>

// Serial config
#define sw_serial_rx_pin A0  // Pin to TX
#define sw_serial_tx_pin A1  // Pin to RX
#define esp8266_reset_pin A2 // Pin to CH_PD, not reset
SoftwareSerial swSerial(sw_serial_rx_pin, sw_serial_tx_pin);

SerialESP8266wifi wifi(swSerial, swSerial, esp8266_reset_pin, Serial);

// WiFi config
#define ssid "SSID" // WiFi SSID
#define password "Password" // WiFi Password

String inputString;

int broche_reception = 11;
IRrecv Receiver(broche_reception);
decode_results decodedir;

// Init of valid code (based on infrared recieved codes for each keys)
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
  swSerial.begin(9600);
  inputString.reserve(20);
  
  Receiver.enableIRIn();
  pinMode(BLUE, OUTPUT); // Blue led when key is pressed
  pinMode(RED, OUTPUT); // Red led when error in code
  pinMode(GREEN, OUTPUT); // Green led when code is valid
  pinMode(BUZZER, OUTPUT);
  pinMode(LOCK, OUTPUT);
  digitalWrite(LOCK, HIGH);

  while(!Serial);
  Serial.println("Starting wifi");
  wifi.setTransportToTCP();
  wifi.endSendWithNewline(true);
  wifi.begin();
  wifi.connectToAP(ssid, password);
  wifi.connectToServer("Server_IP", "9999"); // IP address and port of the main server hosting the Python program
}

void loop() {
  if (!wifi.isStarted()) {
    wifi.begin();
  }

  if (test_code.length() != code.length()) {
    if (Receiver.decode(&decodedir)) {
      msg = decode_ir.value;
      Serial.println(msg);
      
      if (msg.substring(0, 3) == "167") {
        test_code.concat(msg);
        Serial.println(test_code);
        digitalWrite(BLUE, HIGH);
        tone(BUZZER, 300, 50);
        delay(100);
        noTone(BUZZER);
        delay(100);
      }
      Receiver.resume(); // Receiving next code
    }
  }
  else {
    if (test_code == code) {
      digitalWrite(GREEN, HIGH);
      analogWrite(LOCK, LOW);
      tone(BUZZER, 400, 250);
      delay(500);
      noTone(BUZZER);
      test_code = "";
      wifi.send(SERVER, "LoR"); // Sending lock enigma completed to server
      delay(10000);
    }
    else {
      digitalWrite(RED, HIGH);
      tone(BUZZER, 200, 50);
      delay(100);
      noTone(BUZZER);
      test_code = "";
      wifi.send(SERVER, "LoE"); // Sending lock enigma error to server
      delay(1000);
    }
  }

  delay(100);
  digitalWrite(LOCK, HIGH);
  digitalWrite(BLUE, LOW);
  delay(100);
  digitalWrite(RED, LOW);
  digitalWrite(GREEN, LOW);
}