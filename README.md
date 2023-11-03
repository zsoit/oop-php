# Piłka Nożna - Katalog - Aplikacja OOP PHP 


Jakub Achtelik, Oliwier Budnik\
III Semestr, Zastosowanie Programowania Obiektowego

- Demo: https://projekt.hu1.pl/
- Baza danych: https://pma.small.pl/



## ZAŁOŻENIA
**Temat aplikacji**: Piłka Nożna – Katalog (Aplikacja PHP)

**Rodzaj aplikacja**: Aplikacja internetowa (architektura klient-serwer)

Aplikacja uruchamina lokalnie na komputerach oraz zdalnie na serwerze VPS.
Aplikacja jest dososowana również do urządzeń moblinych.

**Środkowisko lokalne**: Windows 10, Ubuntu 22.04 LTS\
**Środowisko produkcyjne (serwer)**: VPS Linux (Ubuntu 20.04 LTS): 

**Środowisko uruchomieniowe**: 

Dla Windows: 
- XAMPP 8.2.4 (serwer HTTP Apache, Serwer bazy danych MariaDB, interpreter PHP)
	
Dla Ubuntu:
- PHP 8.1.2-1ubuntu2.14 Development Server (serwer HTTP + interpreter PHP)
- mysql-server  ver 8.0.34-0ubuntu0.22.04.1 (serwer bazy danych MySQL)

Dla VPS:
- Serwer HTTP Apache2
- Serwer MySQL – MariaDB
- Interpreter PHP 8+



## CECHY
1. Zastosowanie statycznego typowania (zmiennych, funkcji, metod, pól klasy), podobnie jak w językach C/C++, Java, C#. Jest to bardziej przewidywalene i pozwala narzucić określony typ np. zwracanej zmiennej, aby uniknąć wielu błędów. Domyślnie PHP nie wymaga statycznego typowania.

2. Podział projektu na wiele plików według struktury :
MVC Model-View-Controller (pol. Model-Widok-Kontroler)
- Model jest pewną reprezentacją problemu bądź logiki aplikacji.
- Widok opisuje, jak wyświetlić pewną część modelu w ramach interfejsu użytkownika. 
- Kontroler przyjmuje dane wejściowe od użytkownika i reaguje na jego poczynania

3. Logika aplikacji będzie zawarta w sposób obiektowy w klasach, każda klasa to osobny  plik.

4. Obrazki są pobierane z API Wikipedia


 **Ograniczenia**:

- PHP jest podatny na pewne rodzaje ataków, takich jak na przykład wstrzykiwanie SQL, dlatego bezpieczństwo aplikacji nie jest na najwyższym możliwym poziomie i szczegłówa konfiguracja zabezpieczeń nie jest łatwa do wdrożenia w krótkim czasie
- PHP jest językiem interpretowanym dlatego wydajność w stosunku do języków komplilowanych jest niższa
- PHP nie posiada wszystkich elementów obiektowowych znanych z innych języków
- Ograniczony czas, przez co nie można zawrzeć wszystkich celów w wzorcowy sposób zgodny w 100% z dokumentacją
- Ograniczenie aktualnej wiedzy, przez co niektóre elementy projektu mogą stanowić wyzwanie

**Narzędzia programistyczne**:

Język: PHP 8+ OOP\
Dodatkowe biblioteki: mysqli (łączenie się z bazą danych)\
Dodatkowe technologie: HTML,CSS, JavaScript, MySQL, FontAwesone(ikonki)\

IDE: Visual Studio Code + PHP Code Extenions\
GIT – System Kontroli Wersji\
Figma – Prototypowanie wyglądu aplikacji \
Trello – zarządzanie zadaniami w zespole\
Przeglądarka internetowa – Posiadająca narzędzia Chrome DevTools \
Pakiet make – automatyzacja poleceń w terminalu\
FileZilla – klient FTP

**Wykaz funkcjonalności aplikacji**


Interfejs webowy, zarządzanie bazą danych z poziomu przeglądarki internetowej:

- edycje, usuwanie, dodawanie nowego piłkarza,
- sortowanie oraz wyświetalnie zdjęć,
- wyszukiwanie po nazwisku, imieniu itp.
- filtrowanie szczegłówe po np. kraju, pozycji itp.
- logowanie oraz autoryzacja użytkownika przeglądającego aplikacje
- dodawanie/edycje, zdjęcia piłkarza


Użytkwonik może za pomocą przegląrki internetowej połączyć się z serwerem na którym hostowana jest aplikacja, zalogować się do panelu poprzez formularz logowania, uzyskać autoryzacje. Panel umożliwia przeglądanie katalogu  piłkarzy w przystępnej formie oraz inne operacje (edycja, usuwaniem, filtrowanie itp.). 

Użytkownik końcowy (klient) nie musi posiadać znajomości obsługi relacyjnej bazy danych aby w intuakcyjny sposób zarządzać aplikacją.


## KONIFGURACJA SERWERA MYSQL
```sql
-- użytkownik dla nowej bazy danych
CREATE USER 'projekt'@'localhost' IDENTIFIED BY 'Pracownia107!'; 

-- uprawnienia
GRANT ALL PRIVILEGES ON pilkanozna.* TO 'projekt'@'localhost';
```