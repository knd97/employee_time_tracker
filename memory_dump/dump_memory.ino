#include <SPI.h>
#include <MFRC522.h>

#define SS_PIN 10
#define RST_PIN 9

//create instance of MFRC522
MFRC522 rfid(SS_PIN, RST_PIN);
MFRC522::MIFARE_Key key;

void setup() {
  Serial.begin(9600);
  while (!Serial);
  SPI.begin();
  rfid.PCD_Init();
  //allows to store string in flash memory
  Serial.println(F("Please insert your tag..."));
}

void loop() {
  if (rfid.PICC_IsNewCardPresent() && rfid.PICC_ReadCardSerial())
  {
      rfid.PICC_DumpToSerial(&(rfid.uid));
  }
}
