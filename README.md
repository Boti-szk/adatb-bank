# Banki Rendszer Webalkalmazás és Adatbázis

Egyszerű banki rendszer webalkalmazás authentikációval, ügyfél- és alkalmazotti szerepkörökkel, számlakezelési és utalási funkciókkal.
A projekt célja egy relációs adatbázis megtervezése, implementálása és működés közbeni tesztelése.

## Host-link

A projekt helyben, XAMPP szerveren fut.

## Fő funkciók

- Regisztráció, bejelentkezés, kijelentkezés
- Szerepkör választása: ügyfél vagy banki alkalmazott
- Bejelentkezés után szerepkörtől függő felhasználói felület

### Ügyfélként:
- Számlák kezelése:
  - Új számla létrehozása, törlés, befizetés
  - Számlaállapot módosítása
  - Számla megosztása más felhasználóval
  - Táblázatos számlalistázás: típus, egyenleg, nyitási dátum, zárolási állapot
- Utalások kezelése:
  - Saját számláról másik saját számlára utalás
  - Utalási táblázat: utalás azonosítója, küldő, forrás- és célszámla, időpont, határidő, sikeresség

### Banki alkalmazottként:
- Számlák kezelése:
  - Új számla létrehozása, saját számla törlése, befizetés, módosítás, megosztás
  - Összes felhasználó számlájának listázása
- Utalások kezelése:
  - Bárki számlája között indíthat utalást
  - Összes utalás listázása
- Számlatípusok létrehozása:
  - Új számlatípus létrehozása
  - Meglévő számlatípusok aktív/passzív állapotba helyezése
  - Összes számlatípus listázása 
- További lekérdezések:
  - Indított utalások összege
  - Beérkezett utalások összege
  - Érvénytelen számlák
  - Egyenleg nélküli számlák

## Használt technológiák

- HTML, CSS, PHP
- phpMyAdmin, MySQL
- XAMPP (Apache, MySQL szerver)

## Megjegyzés

A projekt nem rendelkezik publikus URL-lel, helyi szerveren (XAMPP) futtatható. A webes felület célja az adatbázis-funkciók bemutatása és tesztelése.

## Készült

Egyetemi beadandó projektként, relációs adatbázis-tervezési és webfejlesztési feladat keretében.
