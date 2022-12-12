int y = 0;
String reponse = "";

const int GREEN = 3;
const int BLUE = 4;
const int YELLOW = 5;
const int RED = 6;
const int GREEN_BTN = 7;
const int BLUE_BTN = 8;
const int YELLOW_BTN = 9;
const int RED_BTN = 10;
const int BUZZER = 2;
const int RESET = 13;

void setup() {
  Serial.begin(9600);
  pinMode(GREEN, OUTPUT);
  pinMode(BLUE, OUTPUT);
  pinMode(YELLOW, OUTPUT);
  pinMode(RED, OUTPUT);
  pinMode(GREEN_BTN, INPUT_PULLUP);
  pinMode(BLUE_BTN, INPUT_PULLUP);
  pinMode(YELLOW_BTN, INPUT_PULLUP);
  pinMode(RED_BTN, INPUT_PULLUP);
  pinMode(BUZZER, OUTPUT);
  pinMode(RESET, INPUT_PULLUP);
}


void play_note(int notes, int notespeed) {
  digitalWrite(BUZZER, LOW);
  tone(BUZZER, notes, notespeed);
  delay(notespeed * 2);
  digitalWrite(BUZZER, HIGH);
}


void bouton(){
  if (digitalRead(GREEN_BTN) == LOW) {
    reponse += 2;
    digitalWrite(GREEN, HIGH);
    delay(100);
    digitalWrite(GREEN, LOW);
    Serial.println(reponse);
    delay(1000);
  }

  else if (digitalRead(BLUE_BTN) == LOW) {
    reponse += 3;
    digitalWrite(BLUE, HIGH);
    delay(100);
    digitalWrite(BLUE, LOW);
    Serial.println(reponse);
    delay(1000);
  }
    
  else if (digitalRead(YELLOW_BTN) == LOW) {
    reponse += 4;
    digitalWrite(YELLOW, HIGH);
    delay(100);
    digitalWrite(YELLOW, LOW);
    Serial.println(reponse);
    delay(1000);
  }
    
  else if (digitalRead(RED_BTN) == LOW) {
    reponse += 5;
    digitalWrite(RED, HIGH);
    delay(100);
    digitalWrite(RED, LOW);
    Serial.println(reponse);
    delay(1000);
  }
}


void animation(){
  digitalWrite(GREEN, HIGH); 
  delay(50);
  digitalWrite(GREEN, LOW);
  play_note(100, 10); 
  digitalWrite(BLUE, HIGH); 
  delay(50);
  digitalWrite(BLUE, LOW);
  play_note(200, 10);
  digitalWrite(YELLOW, HIGH);
  delay(50);
  digitalWrite(YELLOW, LOW);
  play_note(400, 10);
  digitalWrite(RED, HIGH); 
  delay(50);
  digitalWrite(RED, LOW);
  play_note(800, 10);
  delay(100);

  digitalWrite(GREEN, HIGH);
  digitalWrite(BLUE, HIGH);
  digitalWrite(YELLOW, HIGH);
  digitalWrite(RED, HIGH);
  play_note(1000, 10);
  delay(1000);

  digitalWrite(GREEN, LOW);
  digitalWrite(BLUE, LOW);
  digitalWrite(YELLOW, LOW);
  digitalWrite(RED, LOW);
}


void loop() {
  if (digitalRead(RESET) == LOW) {
    Serial.println("OKAY !");
    jeu();
  }
}



void jeu() {
  // Initialisation du jeu
  while (1 == 1) {
    if (y == 0) {
      for (int i=0; i<8; i++) {
        digitalWrite(GREEN, HIGH); 
        delay(75);
        digitalWrite(GREEN, LOW);
        play_note(100, 10); 
        digitalWrite(BLUE, HIGH); 
        delay(75);
        digitalWrite(BLUE, LOW);
        play_note(200, 10);
        digitalWrite(YELLOW, HIGH);
        delay(75);
        digitalWrite(YELLOW, LOW);
        play_note(400, 10);
        digitalWrite(RED, HIGH); 
        delay(75);
        digitalWrite(RED, LOW);
        play_note(800, 10);
      }
      y = 1;

      String code = "342";
      delay(1000);
      digitalWrite(BLUE, HIGH);
      play_note(200, 20);
      delay(500);
      digitalWrite(BLUE, LOW);
      digitalWrite(YELLOW, HIGH);
      play_note(400, 20);
      delay(500);
      digitalWrite(YELLOW, LOW);
      digitalWrite(GREEN, HIGH);
      play_note(100, 20);
      delay(500);
      digitalWrite(GREEN, LOW);

      while(reponse.length() != code.length()) {
        bouton();
      }

      if(reponse == code) {
        animation();
        reponse = "";
      }

      else {
        digitalWrite(RED, HIGH);
        delay(100);
        digitalWrite(RED, LOW);
        play_note(800, 10);
        y = 0;
        reponse = "";
        break;
      }
    }
  }
}
