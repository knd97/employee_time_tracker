#include <SPI.h>
#include <Ethernet.h>
#include <MFRC522.h>
#include <ArduinoHttpClient.h>
#include <stdlib.h>

constexpr uint8_t SS_PIN = 5;
constexpr uint8_t RST_PIN = 9;

byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
//ip of docker
char server[] = "192.168.1.14";
IPAddress ip {192, 168, 1, 33};
IPAddress myDNS {192, 168, 1, 0};

//create instance of MFRC522
MFRC522 rfid(SS_PIN, RST_PIN);
MFRC522::MIFARE_Key key;

EthernetClient client;
HttpClient httpclient(client, server, 8040);

void setup() {
  Serial.begin(9600);
  while (!Serial);

  pinMode(10,OUTPUT);
  digitalWrite(10, HIGH);
  pinMode(7, OUTPUT);
  digitalWrite(7, LOW);
  
  SPI.begin();
  Ethernet.begin(mac, ip, myDNS);
  delay(1000);
  Serial.print(F("IP address: "));
  Serial.println(Ethernet.localIP());
  rfid.PCD_Init();
   
  Serial.println(F("Please insert your tag..."));
}

void loop() {

  String rfidUID = "";
  if (rfid.PICC_IsNewCardPresent() && rfid.PICC_ReadCardSerial())
  {
      for (byte i = 0; i < rfid.uid.size; i++) 
      {
          rfidUID += String(rfid.uid.uidByte[i] < 0x10 ? " 0" : " ");
          rfidUID += String(rfid.uid.uidByte[i], HEX);
      }
      rfidUID.replace(" ", "");
      send_uid(rfidUID, server);
      delay(2000);
  }
  if (client.connected())
  {
     client.stop();
  }
}

void send_uid(String token, char server[])
{
  Serial.println(token);
  String url_base = "/add_log.php?token=";
  String url = url_base + token;
  httpclient.beginRequest();
  httpclient.get(url);
  httpclient.endRequest();

  int statusCode = httpclient.responseStatusCode();
  String response = httpclient.responseBody();

  Serial.print("Status code: ");
  Serial.println(statusCode);
  Serial.print("Response: ");
  Serial.println(response);
  if(response == 'true')
  {
    digitalWrite(7, HIGH);
  }
  delay(4000);
  digitalWrite(7, LOW);
}
