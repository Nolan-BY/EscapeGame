#include <SoftwareSerial.h>
#include "Arduino_SensorKit.h"

// // serial config
#define     RX    2
#define     TX    3
SoftwareSerial AT(RX,TX); 

// TODO: change user config
String ssid     = "ArduinoEarth"; //Wifi SSID
String password = "chevre007"; //Wifi Password
const unsigned int writeInterval = 25000; // write interval (in ms)

int AT_cmd_time; 
boolean AT_cmd_result = false;

bool alerte = false;

float x1 = 0.0;
float yaxis1 = 0.0;
float z1 = 0.0;

float x = 0.0;
float y = 0.0;
float z = 0.0;

void setup() {
  Serial.begin(9600);
  while(!Serial);
  Accelerometer.begin();
  // open serial 
  Serial.println("*****************************************************");
  Serial.println("Program Start : Connect Arduino WiFi to AskSensors");
  AT.begin(9600);
  Serial.println("Initiate AT commands with ESP8266 ");
  sendATcmd("AT",5,"OK");
  sendATcmd("AT+CWMODE=1",5,"OK");
  Serial.print("Connecting to WiFi: ");
  Serial.println(ssid);
  sendATcmd("AT+CWJAP=\""+ ssid +"\",\""+ password +"\"",20,"OK");
  Serial.print("Connected !");
  Serial.println(AT.write("AT+CIFSR"));
  sendATcmd("AT+CIPCLOSE=0",2,"OK"); 
}

void loop() {
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
        Serial.println("*****************************************************");
        Serial.println("Open TCP connection ");
        sendATcmd("AT+CIPMUX=1", 2, "OK");
        sendATcmd("AT+CIPSTART=0,\"TCP\",\"192.168.1.85\",4444", 2, "OK");          
        sendATcmd("AT+CIPSEND=0,4", 1, ">");
        delay(20);
        AT.write("true\r");
        Serial.print("********** sending data: ");
        sendATcmd("AT+CIPCLOSE=0",2,"OK");
        delay(2000);
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
    Serial.println("*****************************************************");
    Serial.println("Open TCP connection ");
    sendATcmd("AT+CIPMUX=1", 2, "OK");
    sendATcmd("AT+CIPSTART=0,\"TCP\",\"192.168.82.85\",4444", 2, "OK");          
    sendATcmd("AT+CIPSEND=0,5", 1, ">");
    delay(20);
    AT.write("false\r");
    Serial.print("********** sending data: ");
    sendATcmd("AT+CIPCLOSE=0",2,"OK");
    delay(2000);
  }
  Serial.println("RAS");
  delay(500);
}



// sendATcmd
void sendATcmd(String AT_cmd, int AT_cmd_maxTime, char readReplay[]) {
  Serial.print("AT command:");
  Serial.println(AT_cmd);

  while(AT_cmd_time < (AT_cmd_maxTime)) {
    AT.println(AT_cmd);
    if(AT.find(readReplay)) {
      AT_cmd_result = true;
      break;
    }
  
    AT_cmd_time++;
  }
  Serial.println("...Result:");
  if(AT_cmd_result == true) {
    Serial.println("DONE");
    AT_cmd_time = 0;
  }
  
  if(AT_cmd_result == false) {
    Serial.println("FAILED");
    AT_cmd_time = 0;
  }
  
  AT_cmd_result = false;
 }