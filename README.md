# Piłka Nożna - Katalog - Aplikacja OOP PHP 


Jakub Achtelik, Oliwier Budnik\
III Semestr, Zastosowanie Programowania Obiektowego

- Demo: https://projekt.hu1.pl/
- Baza danych: https://pma.small.pl/



## ZAŁOŻENIA
Język: PHP
Katalog z piłkarzmi , umożlia:

- edycje, usuwanie, dodawanie nowego piłkarza, sortowanie oraz wyświetalnie zdjęć, wyszukiwanie
- interfejs webowy, zarządzanie bazą danych z poziomu aplikacji internetowej w PHP
- logowanie oraz autoryzację użytkownika
- dodawanie/edycje, zdjęcia piłkarza


## CECHY
1. Aplikacja napisana jest w sposób obiektowy OOP, tak aby była jak najbardziej skalowalna, czytelna, łatwa w debugowaniu

2. Stosowanane jest Typowanie właściwości (zmiennych, funkcji, metod, pól klasy),
podobnie jak w językach C/C++, Java, C#. Jest to bardziej przewidywalene i pozwala narzucić określony typ np. zwracanej zmiennej, aby uniknąć wielu błędów.

3. Podział projektu na wiele plików według struktury:

MVC Model-View-Controller (pol. Model-Widok-Kontroler) :

- Model jest pewną reprezentacją problemu bądź logiki aplikacji.
- Widok opisuje, jak wyświetlić pewną część modelu w ramach interfejsu użytkownika. Może składać się z podwidoków odpowiedzialnych za mniejsze części interfejsu.
- Kontroler przyjmuje dane wejściowe od użytkownika i reaguje na jego poczynania, zarządzając aktualizacje modelu oraz odświeżenie widoków.


4. Ikonki z https://fontawesome.com/search



## UŻYTE OPROGRAMOWANIE

### środowisko lokalne: 
- Windows/Ubuntu: XAMPP, Visual Studio Code
- pakiet make - automatyzacja poleń w terminalu

### serwer:
- Linux: serwer HTTP Apache + serwer MariaDB

## KONIFGURACJA SERWERA MYSQL
```sql
-- użytkownik dla nowej bazy danych
CREATE USER 'projekt'@'localhost' IDENTIFIED BY 'Pracownia107!'; 

-- uprawnienia
GRANT ALL PRIVILEGES ON pilkanozna.* TO 'projekt'@'localhost';
```