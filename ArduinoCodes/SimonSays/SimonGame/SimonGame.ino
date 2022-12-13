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

#define lenarr(array) ((sizeof(array)) / (sizeof(array[0])))

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


void bouton() {
  if (digitalRead(GREEN_BTN) == LOW) {
    reponse += 3;
    digitalWrite(GREEN, HIGH);
    delay(100);
    digitalWrite(GREEN, LOW);
    Serial.println(reponse);
    delay(1000);
  }

  else if (digitalRead(BLUE_BTN) == LOW) {
    reponse += 4;
    digitalWrite(BLUE, HIGH);
    delay(100);
    digitalWrite(BLUE, LOW);
    Serial.println(reponse);
    delay(1000);
  }
    
  else if (digitalRead(YELLOW_BTN) == LOW) {
    reponse += 5;
    digitalWrite(YELLOW, HIGH);
    delay(100);
    digitalWrite(YELLOW, LOW);
    Serial.println(reponse);
    delay(1000);
  }
    
  else if (digitalRead(RED_BTN) == LOW) {
    reponse += 6;
    digitalWrite(RED, HIGH);
    delay(100);
    digitalWrite(RED, LOW);
    Serial.println(reponse);
    delay(1000);
  }
}


void animationSuccess() {
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
  play_note(300, 10);
  digitalWrite(RED, HIGH); 
  delay(50);
  digitalWrite(RED, LOW);
  play_note(400, 10);
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


void code(String code) {
  const char* leds[] = {"GREEN", "BLUE", "YELLOW", "RED"};
  int buzz[] = {100, 200, 300, 400};

  int code_len = code.length() + 1; 
  char char_array[code_len];
  code.toCharArray(char_array, code_len);

  for(int c = 0; c < code.length(); c++) {
    digitalWrite(leds[c-2], HIGH);
    play_note(buzz[c-2], 20);
    delay(500);
    digitalWrite(leds[c-2], LOW);
  }

  while(reponse.length() != code.length()) {
    bouton();
  }

  if(reponse == code) {
    animationSuccess();
    reponse = "";
  }

  else {
    digitalWrite(RED, HIGH);
    delay(100);
    digitalWrite(RED, LOW);
    play_note(800, 10);
    y = 0;
    reponse = "";
    return;
  }
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

      const char* codes[] = {"453", "44445", "5435", "3"};
      for(int cds = 0; cds < lenarr(codes); cds++) {
        delay(1000);
        code(codes[cds]);
      }
    }
  }
}
