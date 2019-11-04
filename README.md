# employee_time_tracker

# Hardware
Potrzebne są 3 urządzenia: <br />
    1. **Arduino UNO** <br />
    2. **Czytnik MFRC522 RFID**\
    3. **Karta lub tag RFID wysokiej częstotliwości**

# Specyfikacja
* Napięcie wejściowe modułu RFID: 3.3V
* Częstotliwość pracy moduły RFID: 13.56MHz

# Potrzebne biblioteki
* **SPI.h**
* **MFRC522.h**

# Podłączenie pinów

| RFID  | Arduino Uno  |
| ------------- | ------------- |
| SDA  | 10  |
| SCK  | 13 |
| MOSI  | 11 |
|  MISQ | l2 |
|  IRQ | - |
|  GND | GND |
|  RST | 9 |
| 3.3  | 3.3 |


# Przykładowe podłączenie układu

![alt text](https://circuits4you.com/wp-content/uploads/2018/10/RFID-Reader-RC522-interface-with-Arduino.jpg)


# Memory organisation
MIFARE1K posiada pamięć złożoną z 1024 bitów, przykładowy zrzut pamięci można znaleźć w pliku `example_output.log`. Pamieć podzielona jest na 16 sektorów (0-15), z których każdy zaiwera 4 bloki (0-3). Blok `0` w sektorze `0` jest kodem producenta, pierwsze 4 bajty to UID. Ostatni blok w każdym sektorze to blok bezpieczeństwa.