#include <SPI.h>
#include <Ethernet.h>
#include <MFRC522.h>
#include <stdlib.h>

constexpr uint8_t SS_PIN = 5;
constexpr uint8_t RST_PIN = 9;

byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
char server[] = "192.168.1.13";
IPAddress ip {192, 168, 1, 33};
IPAddress myDNS {192, 168, 1, 0};

//create instance of MFRC522
MFRC522 rfid(SS_PIN, RST_PIN);
MFRC522::MIFARE_Key key;

EthernetClient client;

void setup() {
  Serial.begin(9600);
  while (!Serial);

  pinMode(10,OUTPUT);
  digitalWrite(10, HIGH);
  SPI.begin();
  Ethernet.begin(mac, ip, myDNS);
  delay(1000);
  Serial.print("IP address: ");
  Serial.println(Ethernet.localIP());
  
  rfid.PCD_Init();
    
  Serial.println(F("Please insert your tag..."));
}

void loop() {
  if (rfid.PICC_IsNewCardPresent() && rfid.PICC_ReadCardSerial())
  {
      char **token[4];
      for(int i = 0; i < 4; i++)
      {
          token[i] = malloc(3 * sizeof(char));
      }

      for (byte i = 0; i < rfid.uid.size; i++) 
      {
          Serial.print(rfid.uid.uidByte[i] < 0x10 ? " 0" : " ");
          Serial.print(rfid.uid.uidByte[i], HEX);
          itoa(rfid.uid.uidByte[i], *token[i], 16);
      }
      
      String token_str = "";
      for(int i = 0; i < 4; i++)
      {
        token_str += *token[i];
      }

      Serial.println();
      //Serial.println(token_str);
      send_uid(token_str ,server);
      delay(2000);
  }
  Serial.print("|--------------------------------|");
  Serial.println("I AM HERE");
    int len = client.available();
    Serial.println("Dlugosc :");
    Serial.print(len);
    Serial.println("|--------------------------------|");
      if (len > 0) {
       byte buffer[10];
        if (len > 10) len = 10;
        
        //char thisChar = client.read();
        client.read(buffer, len);
     Serial.println("|--------------www---------------|");  
     Serial.write(buffer, len);
     String tekst;
     tekst.toCharArray(char(buffer), len);
     Serial.print("|--------------ppp---------------|");  
     Serial.println(tekst);
    // Serial.print("|--------------ccc---------------|");  
     //Serial.println(thisChar);
  }

   if (client.connected())
   {
      client.stop();
   }
}

void send_uid(String token, char server[])
{
  Serial.println(token);
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

}
