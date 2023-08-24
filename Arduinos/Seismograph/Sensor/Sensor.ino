#include <SoftwareSerial.h>
#include "Arduino_SensorKit.h"
#include <SerialESP8266wifi.h>

// Serial config
#define sw_serial_rx_pin 2  // Pin to TX
#define sw_serial_tx_pin 3  // Pin to RX
#define esp8266_reset_pin 4 // Pin to CH_PD, not reset
SoftwareSerial swSerial(sw_serial_rx_pin, sw_serial_tx_pin);

SerialESP8266wifi wifi(swSerial, swSerial, esp8266_reset_pin, Serial);

// WiFi config
#define ssid "SSID" // WiFi SSID
#define password "Password" // WiFi Password

String inputString;

bool alerte = false;

float x1 = 0.0;
float y1 = 0.0;
float z1 = 0.0;

float x = 0.0;
float y = 0.0;
float z = 0.0;

void setup() {
  Serial.begin(9600);
  swSerial.begin(9600);
  inputString.reserve(20);

  Accelerometer.begin();
  
  while(!Serial);
  Serial.println("Starting wifi");
  wifi.setTransportToTCP();
  wifi.endSendWithNewline(false);
  wifi.begin();
  wifi.connectToAP(ssid, password);
  wifi.connectToServer("Server_IP", "9999"); // IP address and port of the main server hosting the Python program
}

void loop() {
  if (!wifi.isStarted()) {
    wifi.begin();
  }
  
  x1 = Accelerometer.readX();
  y1 = Accelerometer.readY();
  z1 = Accelerometer.readZ();

  delay(100);

  x = Accelerometer.readX()-x1;
  y = Accelerometer.readY()-y1;
  z = Accelerometer.readZ()-z1;
  int alerte_confirm = 0;
  
  while ((x > 0.1 || x < -0.1) || (y > 0.1 || y < -0.1) || (z > 0.1 || z < -0.1)){
    if (alerte == false){
      alerte_confirm++;
      if (alerte_confirm == 5) {
        Serial.println("TREMBLEMENT DE TERRE !");
        alerte = true;
        wifi.send(SERVER, "SyR"); // Sending seismograph enigma completed to server
      }
      Serial.println(alerte_confirm);
    }
    if (alerte == true) {
      Serial.println("ALERTE ENVOYEE !");
    }
    
    delay(500);

    x1 = Accelerometer.readX();
    y1 = Accelerometer.readY();
    z1 = Accelerometer.readZ();

    delay(100);

    x = Accelerometer.readX()-x1;
    y = Accelerometer.readY()-y1;
    z = Accelerometer.readZ()-z1;

    delay(500);
    
  }

  if (alerte == true) {
    alerte = false;
    wifi.send(SERVER, "SyE"); // Sending seismograph enigma not completed to server
  }
  Serial.println("RAS");
  delay(500);
}