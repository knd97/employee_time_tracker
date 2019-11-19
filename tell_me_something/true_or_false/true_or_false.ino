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
      delay(1000);
      if (client.available()) {
        char true_or_false[6] = "truee";
        true_or_false[6]= client.read();
        Serial.print(true_or_false);
          /*if(true_or_false == 'true')
            {
              Serial.print("Accept");
               }
           else
            {
              Serial.print("Deny");
            }*/
        if (client.connected())
        {
        client.stop();
        }
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

      /* char true_or_false = client.read();
       Serial.print(true_or_false);
       if(true_or_false == 'true')
       {
        Serial.println("Accept");
       }
       else
       {
        Serial.println("Deny");
       }
   }
   else
   {
      Serial.println("Something went wrong, couldn't establish connection with server");
   }
   
   if (client.connected())
   {
      client.stop();
   }*/
   //-------------------
  }
  //----------------
}
