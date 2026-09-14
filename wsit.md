
## Zmiany wprowadzone przez KrzakAI

- `2026-09-13 17:26 CEST` — **Model:** `Iskrząca Mysz 1.3 Współpracownik (OpenCode Free, Brak ZDR)` — **Zakres:** usunięto przedrostek Treść zadania
- `2026-09-13 17:24 CEST` — **Model:** `Iskrząca Mysz 1.3 Współpracownik (OpenCode Free, Brak ZDR)` — **Zakres:** dodano rozwiązania zadań Lekcje 2-4
- `2026-09-13 17:22 CEST` — **Model:** `Iskrząca Mysz 1.3 Współpracownik (OpenCode Free, Brak ZDR)` — **Zakres:** utworzono streszczenie MySQL Lekcje 1-4

# MySQL — streszczenie (Lekcje 1–4)

## Lekcja 1 — Podstawy, CREATE, INSERT

### Instalacja i start

- Instalator: [dev.mysql.com/downloads/mysql](http://dev.mysql.com/downloads/mysql) — przy instalacji ustaw hasło `root`.
- Foldery serwera: `bin` (serwer + narzędzia), `data` (bazy, logi), `examples`, `include`, `lib`, `scripts`, `share` (błędy, charsety).
- Komendy konsoli: `\q` (wyjście), `\c` (czyszczenie), `\h` (pomoc), `\. plik.sql` / `source plik.sql` (wykonanie skryptu z pliku).

### Logowanie

```sql
mysql -u username -p
mysql -h localhost -u username -p
```

### Podgląd struktury

```sql
SHOW DATABASES;
USE nazwa_bazy;
SHOW TABLES;
DESCRIBE nazwa_tabeli;
SHOW COLUMNS FROM nazwa_tabeli;
SELECT DATABASE();
```

### Tworzenie bazy i tabeli

```sql
CREATE DATABASE bazaosob;
USE bazaosob;
CREATE TABLE osoby (
  imie VARCHAR(50) NOT NULL,
  nazwisko VARCHAR(40) NOT NULL,
  PRIMARY KEY (nazwisko)
);
DROP TABLE osoby;
```

Przykład z lekcji:

```sql
CREATE TABLE dane (
  id_osoby VARCHAR(3),
  imie VARCHAR(15) NOT NULL,
  nazwisko VARCHAR(20) NOT NULL,
  email VARCHAR(50) NULL,
  ulica VARCHAR(50) NULL,
  miasto VARCHAR(50) NULL,
  data_ur DATE NULL,
  aktywny INT DEFAULT 1,
  PRIMARY KEY (id_osoby)
);
```

### Atrybuty kolumn

- `NOT NULL` — zakaz NULL.
- `AUTO_INCREMENT` — autonumerowanie, tylko z `PRIMARY KEY`.
- `PRIMARY KEY` — unikalny identyfikator, brak powtórek.
- `FOREIGN KEY` — odwołanie do PK innej tabeli.
- `UNIQUE` — brak powtórek, ale nie musi identyfikować rekordu.
- `DEFAULT` — wartość wstawiana gdy brak w `INSERT`.
- `UNSIGNED` — tylko liczby >= 0, tylko typy całkowite.
- `ZEROFILL` — dopełnianie zerami z przodu, tylko całkowite, implikuje `UNSIGNED`.

### Silniki tabel

- `MyISAM` — szybkie odczyty, brak transakcji, rzadko zmieniane dane.
- `InnoDB` — transakcje, blokowanie wierszy, foreign keys.
- Podgląd: `SHOW ENGINES\G`
- Przykład: `CREATE TABLE t (id TINYINT AUTO_INCREMENT PRIMARY KEY) TYPE=MyISAM;`

### INSERT i ładowanie z pliku

```sql
INSERT INTO dane (imie, nazwisko, email, ulica, miasto, data_ur)
VALUES ('Mariusz','Kowalski','mk@op.pl','Polna','Warszawa','1980-02-25');

LOAD DATA LOCAL INFILE 'dane.txt' INTO TABLE dane;
```

W pliku: kolumny oddzielone tabulatorem, wiersze końcem linii. Alternatywa shell: `mysqlimport --local dane dane.txt`

## Lekcja 2 — SELECT (baza komis)

### Tabela pomocnicza

```sql
CREATE TABLE shop (
  article INT(4) UNSIGNED ZEROFILL DEFAULT '0000' NOT NULL,
  dealer CHAR(20) DEFAULT '' NOT NULL,
  price DOUBLE(16,2) DEFAULT '0.00' NOT NULL,
  PRIMARY KEY (article, dealer)
);
INSERT INTO shop VALUES
  (1,'A',3.45),(1,'B',3.99),(2,'A',10.99),(3,'B',1.45),
  (3,'C',1.69),(3,'D',1.25),(4,'D',19.95);
```

### Zadanie bazowe: komis.pojazdy

```sql
CREATE DATABASE komis;
CREATE TABLE pojazdy (
  numer INT AUTO_INCREMENT PRIMARY KEY,
  marka VARCHAR(30) NOT NULL,
  rokProdukcji INT NOT NULL,
  cenaSprzedazy DECIMAL(10,2) NULL,
  cenaZakupu DECIMAL(10,2) NOT NULL
);
```

### Wzorce zapytań do zadań 4–14

```sql
-- 4. sortowanie wg roku
SELECT * FROM pojazdy ORDER BY rokProdukcji;
-- 5. tylko Audi
SELECT * FROM pojazdy WHERE marka = 'Audi';
-- 6. droższe od 10000 (zakup)
SELECT * FROM pojazdy WHERE cenaZakupu > 10000;
-- 7. przedział 5000–10000
SELECT * FROM pojazdy WHERE cenaZakupu BETWEEN 5000 AND 10000;
-- 8. niesprzedane alfabetycznie
SELECT * FROM pojazdy WHERE cenaSprzedazy IS NULL ORDER BY marka;
-- 9/10. najmłodsze / najstarsze
SELECT * FROM pojazdy ORDER BY rokProdukcji DESC LIMIT 1;
SELECT * FROM pojazdy ORDER BY rokProdukcji ASC LIMIT 1;
-- 11. auta 10-letnie
SELECT * FROM pojazdy WHERE rokProdukcji = YEAR(CURDATE()) - 10;
-- 12. liczba aut wg marki
SELECT marka, COUNT(*) FROM pojazdy GROUP BY marka;
-- 13. wartość wszystkich
SELECT SUM(cenaZakupu) FROM pojazdy;
-- 14. średnia wg marki i roku
SELECT marka, rokProdukcji, AVG(cenaZakupu) FROM pojazdy GROUP BY marka, rokProdukcji;
```

### LIMIT

```sql
SELECT imie, nazwisko FROM pracownicy LIMIT 5;
SELECT imie, nazwisko FROM pracownicy LIMIT 10, 5;
```

`LIMIT n` — pierwsze n wierszy. `LIMIT offset, count` — pomija offset, bierze count.

### Rozwiązania — komis.pojazdy

**1.** Utwórz bazę **komis**, jeżeli istnieje to usuń starą.

```sql
DROP DATABASE IF EXISTS komis;
CREATE DATABASE komis;
USE komis;
```

**2.** Utwórz tabelę **pojazdy** (numer, marka, rokProdukcji, cenaSprzedazy, cenaZakupu), PK = numer.

```sql
CREATE TABLE pojazdy (
  numer INT AUTO_INCREMENT PRIMARY KEY,
  marka VARCHAR(30) NOT NULL,
  rokProdukcji INT NOT NULL,
  cenaSprzedazy DECIMAL(10,2) NULL,
  cenaZakupu DECIMAL(10,2) NOT NULL
);
```

**3.** Wprowadź 10 rekordów, w tym przynajmniej jedno Audi.

```sql
INSERT INTO pojazdy (marka, rokProdukcji, cenaSprzedazy, cenaZakupu) VALUES
('Audi', 2018, 45000.00, 38000.00),
('BMW', 2015, 32000.00, 27000.00),
('Toyota', 2012, NULL, 18000.00),
('Fiat', 2008, 9000.00, 7000.00),
('Opel', 2016, NULL, 22000.00),
('Ford', 2010, 14000.00, 11000.00),
('Skoda', 2019, 55000.00, 48000.00),
('Volkswagen', 2014, 28000.00, 23000.00),
('Honda', 2005, 8000.00, 6000.00),
('Audi', 2020, NULL, 75000.00);
```

**4.** Wyświetl tabelę posortowaną wg rokProdukcji.

```sql
SELECT * FROM pojazdy ORDER BY rokProdukcji;
```

**5.** Wyświetl wszystkie auta marki Audi.

```sql
SELECT * FROM pojazdy WHERE marka = 'Audi';
```

**6.** Wyświetl auta droższe od 10000 (cenaZakupu).

```sql
SELECT * FROM pojazdy WHERE cenaZakupu > 10000;
```

**7.** Wyświetl auta z przedziału 5000–10000.

```sql
SELECT * FROM pojazdy WHERE cenaZakupu BETWEEN 5000 AND 10000;
```

**8.** Wyświetl niesprzedane pojazdy (brak ceny sprzedaży) alfabetycznie.

```sql
SELECT * FROM pojazdy WHERE cenaSprzedazy IS NULL ORDER BY marka;
```

**9.** Wyświetl najmłodsze auto.

```sql
SELECT * FROM pojazdy ORDER BY rokProdukcji DESC LIMIT 1;
```

**10.** Wyświetl najstarsze auto.

```sql
SELECT * FROM pojazdy ORDER BY rokProdukcji ASC LIMIT 1;
```

**11.** Wyświetl 10-letnie auta.

```sql
SELECT * FROM pojazdy WHERE rokProdukcji = YEAR(CURDATE()) - 10;
```

**12.** Wyświetl ile aut jakiej marki posiadasz (GROUP BY + COUNT).

```sql
SELECT marka, COUNT(*) AS liczba FROM pojazdy GROUP BY marka;
```

**13.** Wyświetl wartość wszystkich pojazdów (SUM).

```sql
SELECT SUM(cenaZakupu) AS wartosc FROM pojazdy;
```

**14.** Wyświetl średnią cenę auta zależną od marki i roku (AVG + GROUP BY).

```sql
SELECT marka, rokProdukcji, AVG(cenaZakupu) AS srednia FROM pojazdy GROUP BY marka, rokProdukcji;
```

## Lekcja 3 — ALTER, UPDATE, DELETE, TRUNCATE, DROP, RENAME

### Struktura tabeli

```sql
ALTER TABLE dane ADD dochody DECIMAL(12,2) DEFAULT 0;
ALTER TABLE dane DROP COLUMN dochody;
ALTER TABLE klienci MODIFY nazwisko TEXT;
ALTER TABLE klienci ALTER COLUMN nazwisko TEXT;
SHOW COLUMNS FROM dane;
```

### Dane: INSERT / UPDATE / DELETE

```sql
INSERT INTO nazwa_tabeli (kolumny) VALUES (wartosci);
UPDATE dane SET aktywny = 1 WHERE nazwisko = 'Knaz';
UPDATE Customers SET ContactName = 'Alfred Schmidt', City = 'Hamburg';
DELETE FROM dane WHERE imie = 'ewa';
```

Bez `WHERE` w `UPDATE` / `DELETE` — zmienia usuwa wszystkie wiersze.

### TRUNCATE vs DELETE

```sql
TRUNCATE TABLE nazwa_tabeli;
```

- `TRUNCATE` — szybszy, kasuje + odtwarza tabelę, resetuje `AUTO_INCREMENT`, nie zwraca liczby wierszy, nie odpala triggerów `ON DELETE`, nie jest transaction-safe.
- `DELETE` — wolniejszy, wiersz po wierszu, liczy wiersze, odpala triggery.

### Usuwanie bazy / tabel, zmiana nazw

```sql
DROP TABLE osoby;
DROP TABLE IF EXISTS t1, t2;
DROP DATABASE bazaosob;
RENAME TABLE tabela1 TO tabela2;
RENAME TABLE customer TO klienci;
```

Brak `RENAME DATABASE` — aby zmienić nazwę bazy: utwórz nową + przekopiuj dump. W 5.1.7–5.1.23 istniało, usunięte z powodu ryzyka utraty danych.

### Wczytywanie dumpa (firma.sql)

```sql
\. sciezka_i_nazwa_pliku.sql
source sciezka_i_nazwa_pliku.sql;
```

W Workbench: wkleić zawartość jako query i wykonać. Tworzy bazę `firma` z tabelą `customer`.

### Zadania firma.customer — ściąga

1. `ALTER TABLE customer ADD email VARCHAR(50);` + UPDATE maili.
2. `ALTER TABLE customer DROP COLUMN zipcode;` + `SHOW COLUMNS FROM customer;`
3. Zmiana nazwy kolumny: `ALTER TABLE customer CHANGE lname nazwisko VARCHAR(50);`
4. `ALTER TABLE customer MODIFY email TEXT;`
5. `DELETE FROM customer WHERE title = 'Miss';`
6. `UPDATE customer SET title = 'Pani' WHERE title = 'Mrs';`
7. `UPDATE customer SET city = 'Bockengham' WHERE city = 'Bingham';`
8. `RENAME TABLE customer TO klienci;`
9. `TRUNCATE TABLE klienci;` — zapamiętaj czas.
10. Wczytaj `firma.sql` ponownie.
11. `ALTER TABLE customer DROP COLUMN zipcode, DROP COLUMN phone;` (zależnie od składni wersji — ewentualnie dwa osobne ALTER).
12. `DELETE FROM customer;` — zapamiętaj czas, porównaj z pkt 9.

### Rozwiązania — firma.customer

**1.** Dodaj kolumnę email varchar(50) i wpisz adresy klientów.

```sql
ALTER TABLE customer ADD email VARCHAR(50);
UPDATE customer SET email = CONCAT(id, '@example.com');
SELECT * FROM customer;
```

**2.** Usuń kolumnę zipcode i wyświetl kolumny.

```sql
ALTER TABLE customer DROP COLUMN zipcode;
SHOW COLUMNS FROM customer;
```

**3.** Zmień nazwę kolumny lname na nazwisko. Wyświetl kolumny.

```sql
ALTER TABLE customer CHANGE lname nazwisko VARCHAR(50);
SHOW COLUMNS FROM customer;
```

**4.** Zmień typ kolumny email na text.

```sql
ALTER TABLE customer MODIFY email TEXT;
SHOW COLUMNS FROM customer;
```

**5.** Usuń kobiety z tytułem Miss. Wyświetl tabelę.

```sql
DELETE FROM customer WHERE title = 'Miss';
SELECT * FROM customer;
```

**6.** Zmień tytuł Mrs na Pani. Wyświetl tabelę.

```sql
UPDATE customer SET title = 'Pani' WHERE title = 'Mrs';
SELECT * FROM customer;
```

**7.** Zmień miejscowość Bingham na Bockengham. Wyświetl tabelę.

```sql
UPDATE customer SET city = 'Bockengham' WHERE city = 'Bingham';
SELECT * FROM customer;
```

**8.** Zmień nazwę tabeli customer na klienci.

```sql
RENAME TABLE customer TO klienci;
SHOW TABLES;
```

**9.** Usuń wszystkie dane TRUNCATE TABLE. Zapamiętaj czas.

```sql
TRUNCATE TABLE klienci;
SELECT * FROM klienci;
```

**10.** Ponownie wczytaj firma.sql.

```sql
source sciezka_do/firma.sql;
```

**11.** Usuń 2 kolumny zipcode, phone.

```sql
ALTER TABLE customer DROP COLUMN zipcode;
ALTER TABLE customer DROP COLUMN phone;
```

**12.** Usuń wszystkie dane DELETE. Zapamiętaj czas, porównaj z zad. 9.

```sql
DELETE FROM customer;
SELECT * FROM customer;
```

Wniosek: TRUNCATE szybszy, resetuje AUTO_INCREMENT, nie odpala triggerów DELETE.

## Lekcja 4 — Użytkownicy i uprawnienia

### Poziomy uprawnień

- globalny — wszystkie bazy (`mysql.user`).
- baza danych — wszystkie tabele bazy (`mysql.db`, `mysql.host`).
- tabela — wszystkie kolumny (`mysql.tables_priv`).
- kolumna — pojedyncze kolumny (`mysql.columns_priv`).
- Tożsamość to `user@host`, nie sam `user`.

### Najczęstsze przywileje

`SELECT, INSERT, DELETE, UPDATE, REPLACE, CREATE, DROP, ALTER, INDEX, CREATE TEMPORARY TABLES, LOCK TABLES, FILE, RELOAD, SHOW DATABASES, SHUTDOWN, CREATE USER, GRANT OPTION, USAGE` (= brak przywilejów), `ALL PRIVILEGES` (= wszystko poza `GRANT OPTION`).

### Tworzenie użytkownika i GRANT

```sql
CREATE DATABASE IF NOT EXISTS baza_danych;
CREATE USER 'uzytkownik'@'localhost' IDENTIFIED BY 'haslo';
GRANT ALL PRIVILEGES ON baza_danych.* TO 'uzytkownik'@'localhost';
GRANT CREATE, INSERT, DELETE, UPDATE, SELECT ON database_name.* TO 'user_name'@'localhost';
GRANT SELECT ON *.* TO 'janek'@'localhost';
FLUSH PRIVILEGES;
SHOW GRANTS FOR 'root'@'localhost';
```

### REVOKE, RENAME, hasło, usuwanie

```sql
REVOKE DELETE, INSERT ON baza.* FROM 'robaczek'@'localhost';
RENAME USER stara_nazwa TO nowa_nazwa;
ALTER USER 'uzytkownik'@'localhost' IDENTIFIED BY 'nowe_haslo';
DROP USER 'janek'@'localhost';
DELETE FROM mysql.user WHERE User = 'janek';
FLUSH PRIVILEGES;
```

### Kodowanie i logowanie

```sql
ALTER DATABASE baza_danych DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
quit
```

```sql
mysql -u login -P port -p
```

### Zadania robaczek — ściąga

1. Utwórz `firma` z `firma.sql` + bazę `testowa` z `test(id, nazwa)` i 2 rekordami.
2. `CREATE USER 'robaczek'@'localhost' IDENTIFIED BY 'piaskownica';`
3. `GRANT SELECT, INSERT ON firma.* TO 'robaczek'@'localhost';` + `SHOW GRANTS FOR 'robaczek'@'localhost';`
4. `ALTER USER 'robaczek'@'localhost' IDENTIFIED BY 'ziemia';`
5. `GRANT DELETE ON firma.* TO 'robaczek'@'localhost';`
6. Przeniesienie DELETE na global: `REVOKE DELETE ON firma.* FROM 'robaczek'@'localhost'; GRANT DELETE ON *.* TO 'robaczek'@'localhost';`
7. `REVOKE DELETE, INSERT ON ... FROM 'robaczek'@'localhost';` — zostaje `SELECT`.
8. `REVOKE SELECT ...; GRANT SELECT ON *.* TO 'robaczek'@'localhost';`
9. `GRANT ALL PRIVILEGES ON *.* TO 'robaczek'@'localhost';`
10. `REVOKE DELETE, INSERT, CREATE ON *.* FROM 'robaczek'@'localhost';`
11. `ALTER TABLE ... CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci;` + insert `Młęcząść`.
12. Zaloguj jako `robaczek`, sprawdź `SHOW GRANTS; SHOW DATABASES;`
13. `DROP USER 'robaczek'@'localhost';`

> Pamiętaj o `FLUSH PRIVILEGES;` po ręcznych `UPDATE / DELETE` na tabelach systemowych `mysql.*`.
> 

### Rozwiązania — robaczek / uprawnienia

**1.** Utwórz bazę firma z firma.sql oraz bazę testowa z tabelą test (id, nazwa) i 2 rekordami.

```sql
CREATE DATABASE IF NOT EXISTS firma;
USE firma;
source sciezka_do/firma.sql;
CREATE DATABASE IF NOT EXISTS testowa;
USE testowa;
CREATE TABLE test (id INT AUTO_INCREMENT PRIMARY KEY, nazwa VARCHAR(50));
INSERT INTO test (nazwa) VALUES ('rekord1'), ('rekord2');
```

**2.** Utwórz lokalnie użytkownika robaczek z hasłem piaskownica.

```sql
CREATE USER 'robaczek'@'localhost' IDENTIFIED BY 'piaskownica';
FLUSH PRIVILEGES;
```

**3.** Pozwól tylko na SELECT, INSERT do bazy firma. Wyświetl przywileje.

```sql
GRANT SELECT, INSERT ON firma.* TO 'robaczek'@'localhost';
FLUSH PRIVILEGES;
SHOW GRANTS FOR 'robaczek'@'localhost';
```

**4.** Zmień hasło robaczek na ziemia. Sprawdź zmiany.

```sql
ALTER USER 'robaczek'@'localhost' IDENTIFIED BY 'ziemia';
FLUSH PRIVILEGES;
SHOW GRANTS FOR 'robaczek'@'localhost';
```

**5.** Dodaj DELETE. Wyświetl przywileje.

```sql
GRANT DELETE ON firma.* TO 'robaczek'@'localhost';
FLUSH PRIVILEGES;
SHOW GRANTS FOR 'robaczek'@'localhost';
```

**6.** Zmień DELETE z lokalnego (firma) na globalne. Wyświetl przywileje.

```sql
REVOKE DELETE ON firma.* FROM 'robaczek'@'localhost';
GRANT DELETE ON *.* TO 'robaczek'@'localhost';
FLUSH PRIVILEGES;
SHOW GRANTS FOR 'robaczek'@'localhost';
```

**7.** Usuń DELETE i INSERT, zostaw SELECT. Wyświetl przywileje.

```sql
REVOKE DELETE ON *.* FROM 'robaczek'@'localhost';
REVOKE INSERT ON firma.* FROM 'robaczek'@'localhost';
FLUSH PRIVILEGES;
SHOW GRANTS FOR 'robaczek'@'localhost';
```

**8.** Zmień SELECT z lokalnego na globalne. Wyświetl przywileje.

```sql
REVOKE SELECT ON firma.* FROM 'robaczek'@'localhost';
GRANT SELECT ON *.* TO 'robaczek'@'localhost';
FLUSH PRIVILEGES;
SHOW GRANTS FOR 'robaczek'@'localhost';
```

**9.** Nadaj pełne uprawnienia. Wyświetl przywileje.

```sql
GRANT ALL PRIVILEGES ON *.* TO 'robaczek'@'localhost';
FLUSH PRIVILEGES;
SHOW GRANTS FOR 'robaczek'@'localhost';
```

**10.** Odbierz DELETE, INSERT, CREATE. Wyświetl przywileje.

```sql
REVOKE DELETE, INSERT, CREATE ON *.* FROM 'robaczek'@'localhost';
FLUSH PRIVILEGES;
SHOW GRANTS FOR 'robaczek'@'localhost';
```

**11.** Zmień kodowanie na utf8_polish_ci. Dodaj klienta Młęcząść. Wyświetl dane.

```sql
ALTER DATABASE firma DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
ALTER TABLE customer CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci;
INSERT INTO customer (nazwisko) VALUES ('Młęcząść');
SELECT * FROM customer WHERE nazwisko = 'Młęcząść';
```

**12.** Zaloguj się na robaczek, sprawdź uprawnienia i bazy.

```sql
mysql -u robaczek -p
SHOW GRANTS;
SHOW DATABASES;
```

**13.** Usuń konto robaczek.

```sql
DROP USER 'robaczek'@'localhost';
FLUSH PRIVILEGES;
```
