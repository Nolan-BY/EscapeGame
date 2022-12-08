int y = 0;
String reponse = "";

void setup() {
  Serial.begin(9600);
  pinMode(2, OUTPUT);
  pinMode(3, OUTPUT);
  pinMode(4, OUTPUT);
  pinMode(5, OUTPUT);
  pinMode(6, INPUT_PULLUP);
  pinMode(7, INPUT_PULLUP);
  pinMode(8, INPUT_PULLUP);
  pinMode(9, INPUT_PULLUP);
  pinMode(10, OUTPUT);
  pinMode(13, INPUT_PULLUP);
}


void play_note(int notes, int notespeed) {
  digitalWrite(10, LOW);
  tone(10, notes, notespeed);
  delay(notespeed * 2);
  digitalWrite(10, HIGH);
}


void bouton(){
  if (digitalRead(6) == LOW) {
    reponse += 2;
    digitalWrite(2, HIGH);
    delay(100);
    digitalWrite(2, LOW);
    Serial.println(reponse);
    delay(1000);
  }

  else if (digitalRead(7) == LOW) {
    reponse += 3;
    digitalWrite(3, HIGH);
    delay(100);
    digitalWrite(3, LOW);
    Serial.println(reponse);
    delay(1000);
  }
    
  else if (digitalRead(8) == LOW) {
    reponse += 4;
    digitalWrite(4, HIGH);
    delay(100);
    digitalWrite(4, LOW);
    Serial.println(reponse);
    delay(1000);
  }
    
  else if (digitalRead(9) == LOW) {
    reponse += 5;
    digitalWrite(5, HIGH);
    delay(100);
    digitalWrite(5, LOW);
    Serial.println(reponse);
    delay(1000);
  }
}


void animation(){
  digitalWrite(2, HIGH); 
  delay(50);
  digitalWrite(2, LOW);
  play_note(100, 10); 
  digitalWrite(3, HIGH); 
  delay(50);
  digitalWrite(3, LOW);
  play_note(200, 10);
  digitalWrite(4, HIGH);
  delay(50);
  digitalWrite(4, LOW);
  play_note(400, 10);
  digitalWrite(5, HIGH); 
  delay(50);
  digitalWrite(5, LOW);
  play_note(800, 10);
  delay(100);

  digitalWrite(2, HIGH);
  digitalWrite(3, HIGH);
  digitalWrite(4, HIGH);
  digitalWrite(5, HIGH);
  play_note(1000, 10);
  delay(1000);

  digitalWrite(2, LOW);
  digitalWrite(3, LOW);
  digitalWrite(4, LOW);
  digitalWrite(5, LOW);
}


void loop() {
  if (digitalRead(13) == LOW) {
    Serial.println("OKAY !");
    jeu();
  }
}



void jeu() {
  // Initialisation du jeu
  while (1==1) {
    if (y == 0) {
      for (int i=0; i<8; i++) {
        digitalWrite(2, HIGH); 
        delay(75);
        digitalWrite(2, LOW);
        play_note(100, 10); 
        digitalWrite(3, HIGH); 
        delay(75);
        digitalWrite(3, LOW);
        play_note(200, 10);
        digitalWrite(4, HIGH);
        delay(75);
        digitalWrite(4, LOW);
        play_note(400, 10);
        digitalWrite(5, HIGH); 
        delay(75);
        digitalWrite(5, LOW);
        play_note(800, 10);
      }
      y = 1;

      String code = "342";
      delay(1000);
      digitalWrite(3, HIGH);
      play_note(200, 10);
      delay(500);
      digitalWrite(3, LOW);
      digitalWrite(4, HIGH);
      play_note(400, 10);
      delay(500);
      digitalWrite(4, LOW);
      digitalWrite(2, HIGH);
      play_note(100, 10);
      delay(500);
      digitalWrite(2, LOW);

      while(reponse.length() != code.length()){
        bouton();
      }

      if(reponse == code){
        animation();
      }

      else{
        digitalWrite(5, HIGH);
        delay(100);
        digitalWrite(5, LOW);
        play_note(800, 10);
        break;
      }
    }
  }
}
