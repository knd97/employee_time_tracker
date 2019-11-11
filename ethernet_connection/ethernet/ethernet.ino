#include <SPI.h>
#include <Ethernet.h>
#include <MFRC522.h>

constexpr uint8_t SS_PIN = 10;
constexpr uint8_t RST_PIN = 9;

byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
char server[] = "192.168.1.13";
IPAddress ip {192, 168, 1, 52};
IPAddress myDNS {192, 168, 1, 1};

//create instance of MFRC522
MFRC522 rfid(SS_PIN, RST_PIN);
MFRC522::MIFARE_Key key;

EthernetClient client;

void setup() {
  Serial.begin(9600);
  while (!Serial);
  
  Ethernet.begin(mac, ip, myDNS);
  delay(2000);
  Serial.print("IP address: ");
  Serial.println(Ethernet.localIP());
  
  SPI.begin();
  rfid.PCD_Init();
    
  Serial.println(F("Please insert your tag..."));
}

void loop() {
  if (rfid.PICC_IsNewCardPresent() && rfid.PICC_ReadCardSerial())
  {
      String token = "";
      //rfid.PICC_DumpToSerial(&(rfid.uid));
      for (byte i = 0; i < rfid.uid.size; i++) 
      {
          Serial.print(rfid.uid.uidByte[i] < 0x10 ? " 0" : " ");
          Serial.print(rfid.uid.uidByte[i], HEX);
          token += rfid.uid.uidByte[i];
      } 
      Serial.println();
      send_uid(token ,server);
      delay(1000);
  }
}

void send_uid(String token, char server[])
{
  //8040 - due to docker-compose
  if (client.connect(server,8040))
  {
       String url_base = "GET /add_log.php?token=";
       String url_protocol = " HTTP/1.1";
       client.println(url_base + token + url_protocol);
       String server_ip = server;
       client.println("Host: " + server_ip);
       client.println("Content-Type: application/x-www-form-urlencoded");
       client.print("Content-Length: ");
       client.println();
       client.println();
   }
   else
   {
      Serial.println("Something went wrong, couldn't establish connection with server");
   }
   
   if (client.connected())
   {
      client.stop();
   }
}
