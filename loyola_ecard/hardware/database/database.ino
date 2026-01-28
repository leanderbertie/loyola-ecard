#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266WebServer.h>

// Define LCD address and size
LiquidCrystal_I2C lcd(0x27, 16, 2); // Address 0x27, 16 columns, 2 rows

#define SS_PIN 2 // SDA / SS is connected to D4
#define RST_PIN 5 // RST is connected to D3
#define ON_Board_LED 2
#define Buzzer 16 // Connect buzzer to D0 (GPIO16)

MFRC522 mfrc522(SS_PIN, RST_PIN);
int readsuccess;
byte readcard[4];
char str[32] = "";
String StrUID;

const char* ssid = "Kevin's";
const char* password = "kevin2004";
const String apikey = "leander";
const String servername = "http://192.168.153.90/loyola_ecard/backend/process_payment.php";
const String serverApi = servername + "?apikey=" + String(apikey);

ESP8266WebServer server(80);

void setup() {
  Serial.begin(115200);
  SPI.begin();
  mfrc522.PCD_Init();

  pinMode(ON_Board_LED, OUTPUT);
  pinMode(Buzzer, OUTPUT);
  digitalWrite(ON_Board_LED, HIGH);
  digitalWrite(Buzzer, LOW);

  // Initialize LCD
  lcd.init();
  lcd.backlight();
  lcd.setCursor(0, 0);
  lcd.print("Initializing...");
  delay(2000);

  // Connect to WiFi
  WiFi.begin(ssid, password);

  lcd.clear();
  lcd.print("Connecting to WiFi");

  // Wait for connection
  int retries = 0;
  while (WiFi.status() != WL_CONNECTED && retries < 20) {
    delay(500);
    Serial.print(".");
    retries++;
  }

  if (WiFi.status() == WL_CONNECTED) {
    lcd.clear();
    lcd.print("Connected to WiFi");
    Serial.println("Connected to WiFi");
    lcd.setCursor(0, 1);
    lcd.print(WiFi.localIP());
  } else {
    lcd.clear();
    lcd.print("Failed to Connect");
    Serial.println("Failed to Connect to WiFi");
  }

  Serial.println("HTTP server started");
  lcd.clear();
  lcd.print("Ready to Scan");
}

void loop() {
  if (getid()) {
    String UIDresultSend, request;

    // Trigger buzzer for card scan event
    digitalWrite(Buzzer, HIGH);
    delay(200);
    digitalWrite(Buzzer, LOW);

    digitalWrite(ON_Board_LED, LOW);
    lcd.clear();
    lcd.print("Card Scanned!");
    lcd.setCursor(0, 1);
    lcd.print("UID: ");
    lcd.print(StrUID);
    delay(1000);

    UIDresultSend = StrUID;
    Serial.println(UIDresultSend);

    request = serverApi + "&card_number=" + UIDresultSend;
    Serial.print("Request: ");
    Serial.println(request);

    WiFiClient client;
    HTTPClient http;

    if (WiFi.status() != WL_CONNECTED) {
      Serial.println("WiFi not connected!");
      lcd.clear();
      lcd.print("WiFi Not Connected");
      return;
    }

    Serial.println("Starting HTTP request...");

    http.begin(client, request.c_str());
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    int httpResponseCode = http.GET();

    digitalWrite(ON_Board_LED, HIGH);

    Serial.print("HTTP Response code: ");
    Serial.println(httpResponseCode);
    if (httpResponseCode > 0) {
      Serial.println("HTTP request successful.");
      String payload = http.getString();
      Serial.println("Payload:");
      Serial.println(payload);

      lcd.clear();
      if (payload.startsWith("Insufficient fund")) {
        lcd.print("Insufficient Fund");
        lcd.setCursor(0, 1);
        lcd.print(payload.substring(payload.indexOf('=') + 1)); // Display the balance amount

        // Trigger buzzer for insufficient funds
        for (int i = 0; i < 3; i++) {
          digitalWrite(Buzzer, HIGH);
          delay(100);
          digitalWrite(Buzzer, LOW);
          delay(100);
        }
      } else {
        lcd.print("Payment Success");
        lcd.setCursor(0, 1);
        lcd.print("Response OK");

        // Trigger buzzer for success
        digitalWrite(Buzzer, HIGH);
        delay(500);
        digitalWrite(Buzzer, LOW);
      }
    } else {
      Serial.println("HTTP request failed.");
      lcd.clear();
      lcd.print("Payment Failed");
      lcd.setCursor(0, 1);
      lcd.print("Try Again");

      // Trigger buzzer for failure
      digitalWrite(Buzzer, HIGH);
      delay(1000);
      digitalWrite(Buzzer, LOW);
    }

    http.end();
    delay(2000);
    lcd.clear();
    lcd.print("Ready to Scan");
  }
}

int getid() {
  if (!mfrc522.PICC_IsNewCardPresent()) {
    return 0;
  }
  if (!mfrc522.PICC_ReadCardSerial()) {
    return 0;
  }

  Serial.print("UID: ");
  for (int i = 0; i < 4; i++) {
    readcard[i] = mfrc522.uid.uidByte[i];
    array_to_string(readcard, 4, str);
    StrUID = str;
  }
  mfrc522.PICC_HaltA();
  return 1;
}

void array_to_string(byte array[], unsigned int len, char buffer[]) {
  for (unsigned int i = 0; i < len; i++) {
    byte nib1 = (array[i] >> 4) & 0x0F;
    byte nib2 = (array[i] >> 0) & 0x0F;
    buffer[i * 2 + 0] = nib1 < 0xA ? '0' + nib1 : 'A' + nib1 - 0xA;
    buffer[i * 2 + 1] = nib2 < 0xA ? '0' + nib2 : 'A' + nib2 - 0xA;
  }
  buffer[len * 2] = '\0';
}
