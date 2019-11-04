# employee_time_tracketer

# Hardware
Three hardware devices involved: <br />
    1. **Arduino UNO** <br />
    2. **MFRC522 RFID Reader**\
    3. **High frequency targ/card**

# Specifications
### Important:
* Input volatge: 3.3V
* frequency: 13.56MHz

# Pin wiring

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


# Circut

![alt text](https://circuits4you.com/wp-content/uploads/2018/10/RFID-Reader-RC522-interface-with-Arduino.jpg)

# Dependency
* **SPI.h**
* **MFRC522.h**
