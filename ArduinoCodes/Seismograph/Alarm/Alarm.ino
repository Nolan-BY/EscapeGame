#include <SoftwareSerial.h>
#include "Arduino_SensorKit.h"

// serial config
#define     RX    2
#define     TX    3
SoftwareSerial AT(RX,TX);

#define LED 6
#define BUZZER 5

// TODO: change user config
String ssid     = "ArduinoEarth"; //Wifi SSID
String password = "chevre007"; //Wifi Password
const unsigned int writeInterval = 25000; // write interval (in ms)

int AT_cmd_time; 
bool AT_cmd_result = false;

int potentiometer = A0;

bool alarm_state = false;

void setup() {
  Serial.begin(9600);
  pinMode(LED, OUTPUT);
  pinMode(BUZZER, OUTPUT);
  pinMode(potentiometer, INPUT);
  Oled.begin();
  Oled.setFlipMode(false);
  // open serial 
  Serial.println("*****************************************************");
  Serial.println("Program Start : Connect Arduino WiFi to AskSensors");
  AT.begin(9600);
  Serial.println("Initiate AT commands with ESP8266 ");
  sendATcmd("AT",5,"OK");
  sendATcmd("AT+CWMODE=1",5,"OK");
  Serial.print("Connecting to WiFi:");
  Serial.println(ssid);
  sendATcmd("AT+CWJAP=\""+ ssid +"\",\""+ password +"\"",20,"OK");
  Serial.print("Connected !");
  sendATcmd("AT+CIPSERVER=0,4444", 2, "OK");
  Serial.println("*****************************************************");
  Serial.println("Open Server ");
  sendATcmd("AT+CIPMUX=1", 2, "OK");
  sendATcmd("AT+CIPSERVER=1,4444", 2, "OK");
  Serial.println("AT+CIFSR:STAIP");
}

void loop() {
  while (AT.available() > 0) {
    String message = AT.readString();
    if (message.indexOf("true") >= 1) {
      alarm_state = true;
    }
    if (message.indexOf("false") >= 1) {
      alarm_state = false;
    }
    Serial.println("State: " + String(alarm_state));
  }
  Alarm();
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

void Alarm(){
  int volume = map(analogRead(potentiometer), 0, 1023, 0, 100);
  if (alarm_state == true) {
    digitalWrite(LED, HIGH);
    if (volume != 0) {
      tone(BUZZER, volume);
    }
    else {
      noTone(BUZZER);
    }
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