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
RFID | SDA | SCK | MOSI | MISO | IRQ | GND | RST | 3.3v |
--- | --- | --- | --- |--- |--- |--- |--- |--- |--- |--- |---
Arduino UNO | 10 | 13 | 11 | 12 | - | GND | 9 | 3.3 | 272 | 276 | 269

# Circut

![alt text](https://circuits4you.com/wp-content/uploads/2018/10/RFID-Reader-RC522-interface-with-Arduino.jpg)

# Dependency
* **SPI.h**
* **MFRC522.h**
