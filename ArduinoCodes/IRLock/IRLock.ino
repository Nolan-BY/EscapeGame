#include <IRremote.h>

int broche_reception = 11;
IRrecv reception_ir(broche_reception);
decode_results decode_ir;


void setup() {
  Serial.begin(9600);
  reception_ir.enableIRIn();
}

void loop() {
  if (reception_ir.decode(&decode_ir))
    {
      Serial.println(decode_ir.value, HEX);
      reception_ir.resume();
    }
}
