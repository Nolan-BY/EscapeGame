#include <SoftwareSerial.h>
#include "Arduino_SensorKit.h"
#include <SerialESP8266wifi.h>

// // serial config
#define sw_serial_rx_pin 2 //  Connect this pin to TX on the esp8266
#define sw_serial_tx_pin 3 //  Connect this pin to RX on the esp8266
#define esp8266_reset_pin 4 // Connect this pin to CH_PD on the esp8266, not reset. (let reset be unconnected)
SoftwareSerial swSerial(sw_serial_rx_pin, sw_serial_tx_pin);

SerialESP8266wifi wifi(swSerial, swSerial, esp8266_reset_pin, Serial);//adding Serial enabled local echo and wifi debug

// TODO: change user config
#define ssid "ArduinoEarth" //Wifi SSID
#define password "chevre007" //Wifi Password

String inputString;
boolean stringComplete = false;
unsigned long nextPing = 0;

bool alerte = false;

float x1 = 0.0;
float yaxis1 = 0.0;
float z1 = 0.0;

float x = 0.0;
float y = 0.0;
float z = 0.0;

void setup() {
  inputString.reserve(20);
  swSerial.begin(9600);
  Serial.begin(9600);
  Accelerometer.begin();
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
  
  x1 = Accelerometer.readX();
  yaxis1 = Accelerometer.readY();
  z1 = Accelerometer.readZ();

  delay(100);

  x = Accelerometer.readX()-x1;
  y = Accelerometer.readY()-yaxis1;
  z = Accelerometer.readZ()-z1;
  int alerte_confirm = 0;
  
  while ((x > 0.1 || x < -0.1) || (y > 0.1 || y < -0.1) || (z > 0.1 || z < -0.1)){
    if (alerte == false){
      alerte_confirm++;
      if (alerte_confirm == 5) {
        Serial.println("TREMBLEMENT DE TERRE !");
        alerte = true;
        wifi.send(SERVER, "true");
      }
      Serial.println(alerte_confirm);
    }
    if (alerte == true) {
      Serial.println("ALERTE ENVOYEE !");
    }
    
    delay(500);

    x1 = Accelerometer.readX();
    yaxis1 = Accelerometer.readY();
    z1 = Accelerometer.readZ();

    delay(100);

    x = Accelerometer.readX()-x1;
    y = Accelerometer.readY()-yaxis1;
    z = Accelerometer.readZ()-z1;

    delay(500);
    
  }

  if (alerte == true) {
    alerte = false;
    wifi.send(SERVER, "false");
  }
  Serial.println("RAS");
  delay(500);
}