#include <SoftwareSerial.h>
#include "Arduino_SensorKit.h"
#include <SerialESP8266wifi.h>

// Serial config
#define sw_serial_rx_pin 2  // Pin to TX
#define sw_serial_tx_pin 3  // Pin to RX
#define esp8266_reset_pin 4 // Pin to CH_PD, not reset
SoftwareSerial swSerial(sw_serial_rx_pin, sw_serial_tx_pin);
SoftwareSerial AT(sw_serial_rx_pin, sw_serial_tx_pin);

SerialESP8266wifi wifi(swSerial, swSerial, esp8266_reset_pin, Serial);

// User config
#define ssid "ArduinoEarth" // Wifi SSID
#define password "chevre007" // Wifi Password

String inputString;

#define LED 6
#define BUZZER 5

bool alarm_state = false;

void setup() {
  Serial.begin(9600);
  swSerial.begin(9600);
  AT.begin(9600);
  pinMode(LED, OUTPUT);
  pinMode(BUZZER, OUTPUT);
  Oled.begin();
  Oled.setFlipMode(false);

  while (!Serial);
  Serial.println("Starting wifi");
  wifi.setTransportToTCP();
  wifi.endSendWithNewline(true);
  wifi.begin();
  wifi.connectToAP(ssid, password);
  wifi.startLocalServer("9990");
}

void loop() {
  while (AT.available() > 0) {
    String message = AT.readString();
    if (message.indexOf("SyR") >= 1) {
      alarm_state = true;
    }
    if (message.indexOf("SyE") >= 1) {
      alarm_state = false;
    }
    Serial.println("State: " + String(alarm_state));
  }
  Alarm();
}

void Alarm(){
  if (alarm_state == true) {
    digitalWrite(LED, HIGH);
    tone(BUZZER, 90);
    Oled.setFont(u8x8_font_chroma48medium8_r);
    Oled.setCursor(0, 43);
    Oled.print("              ");
    Oled.setCursor(35, 33);
    Oled.print("ALERTE");
    Oled.setCursor(50, 53);
    Oled.print("DETECTEE !");
    Oled.refreshDisplay();
    delay(1000);
    digitalWrite(LED, LOW);
    noTone(BUZZER);
    Oled.setCursor(35, 33);
    Oled.print("ALERTE");
    Oled.setCursor(50, 53);
    Oled.print("        ");
    Oled.refreshDisplay();
    delay(1000);
  }
  else {
    noTone(BUZZER);
    digitalWrite(LED, LOW);
    Oled.setFont(u8x8_font_chroma48medium8_r);
    Oled.setCursor(35, 33);
    Oled.print("        ");
    Oled.setCursor(50, 53);
    Oled.print("           "); 
    Oled.setCursor(0, 43);
    Oled.print("Aucune alerte!");
    Oled.refreshDisplay();
  }
}