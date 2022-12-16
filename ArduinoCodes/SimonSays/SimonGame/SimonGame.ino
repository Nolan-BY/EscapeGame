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

const char* codes[] = {"4,5,3", "4,5,3,6,5,4,5", "4,5,3,6,5,4,5,6,3,4,6", "4,5,3,6,5,4,5,6,3,4,6,4,6,3,6,4", "4,5,3,6,5,4,5,6,3,4,6,4,6,3,6,4,5,3,6,5"};
int buzz[] = {300, 350, 400, 450};

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


void play_note(int note, int notespeed) {
  analogWrite(BUZZER, 255);
  tone(BUZZER, note, notespeed);
  delay(notespeed * 2);
  noTone(BUZZER);
  analogWrite(BUZZER, 0);
}


void boutons() {
  if (digitalRead(GREEN_BTN) == LOW) {
    reponse += 3;
    play_note(300, 50);
    digitalWrite(GREEN, HIGH);
    delay(100);
    digitalWrite(GREEN, LOW);
    Serial.println(reponse);
    delay(1000);
  }

  else if (digitalRead(BLUE_BTN) == LOW) {
    reponse += 4;
    play_note(350, 50);
    digitalWrite(BLUE, HIGH);
    delay(100);
    digitalWrite(BLUE, LOW);
    Serial.println(reponse);
    delay(1000);
  }
    
  else if (digitalRead(YELLOW_BTN) == LOW) {
    reponse += 5;
    play_note(400, 50);
    digitalWrite(YELLOW, HIGH);
    delay(100);
    digitalWrite(YELLOW, LOW);
    Serial.println(reponse);
    delay(1000);
  }
    
  else if (digitalRead(RED_BTN) == LOW) {
    reponse += 6;
    play_note(450, 50);
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
  play_note(300, 50); 
  digitalWrite(BLUE, HIGH); 
  delay(50);
  digitalWrite(BLUE, LOW);
  play_note(350, 50);
  digitalWrite(YELLOW, HIGH);
  delay(50);
  digitalWrite(YELLOW, LOW);
  play_note(400, 50);
  digitalWrite(RED, HIGH); 
  delay(50);
  digitalWrite(RED, LOW);
  play_note(450, 50);
  delay(100);

  digitalWrite(GREEN, HIGH);
  digitalWrite(BLUE, HIGH);
  digitalWrite(YELLOW, HIGH);
  digitalWrite(RED, HIGH);
  play_note(500, 50);
  delay(50);

  digitalWrite(GREEN, LOW);
  digitalWrite(BLUE, LOW);
  digitalWrite(YELLOW, LOW);
  digitalWrite(RED, LOW);
}


void doCode(char* code_source) {

  char code[sizeof(code_source)];

  strcpy(code, code_source);

  String codeTest(code);
  codeTest.replace(",","");

  char* codeArr = strtok(code, ",");

  while (codeArr != NULL) {
    digitalWrite(atoi(codeArr), HIGH);
    play_note(buzz[atoi(codeArr)-3], 50);
    delay(500);
    digitalWrite(atoi(codeArr), LOW);
    codeArr = strtok(NULL, ",");
  }

  while(reponse.length() != codeTest.length()) {
    boutons();
  }

  if(reponse == codeTest) {
    animationSuccess();
  }

  else if(reponse != codeTest){
    digitalWrite(RED, HIGH);
    play_note(200, 500);
    digitalWrite(RED, LOW);
    y = 0;
  }
}


void win() {
  digitalWrite(GREEN, HIGH);
  digitalWrite(BLUE, HIGH);
  digitalWrite(YELLOW, HIGH);
  digitalWrite(RED, HIGH);
  play_note(500, 50);
  digitalWrite(GREEN, LOW);
  digitalWrite(BLUE, LOW);
  digitalWrite(YELLOW, LOW);
  digitalWrite(RED, LOW);
  delay(500);
  digitalWrite(GREEN, HIGH);
  digitalWrite(BLUE, HIGH);
  digitalWrite(YELLOW, HIGH);
  digitalWrite(RED, HIGH);
  play_note(500, 50);
  digitalWrite(GREEN, LOW);
  digitalWrite(BLUE, LOW);
  digitalWrite(YELLOW, LOW);
  digitalWrite(RED, LOW);
}


void loop() {
  if ((digitalRead(RESET) == LOW) && (y == 0)) {
    Serial.println("OKAY !");
    jeu();
  }
}



void jeu() {
  // Initialisation du jeu
  if (y == 0) {
    for (int i=0; i<8; i++) {
      digitalWrite(GREEN, HIGH); 
      delay(75);
      digitalWrite(GREEN, LOW);
      play_note(300, 50); 
      digitalWrite(BLUE, HIGH); 
      delay(75);
      digitalWrite(BLUE, LOW);
      play_note(350, 50);
      digitalWrite(YELLOW, HIGH);
      delay(75);
      digitalWrite(YELLOW, LOW);
      play_note(400, 50);
      digitalWrite(RED, HIGH); 
      delay(75);
      digitalWrite(RED, LOW);
      play_note(450, 50);
    }
    y = 1;

    for(int cds = 0; cds < 5; cds++) {
      delay(1000);
      Serial.println(codes[cds]);
      doCode(codes[cds]);
      reponse = "";
      if(y == 0) {
        break;
      }
    }
    if(y != 0) {
      y = 0;
      win();
    }
  }
}
