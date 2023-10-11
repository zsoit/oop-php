<?php
namespace Pilkanozna;

class StronaHtml
{


    private string $tytul = "Piłka Nożna - Katalog";
    private string $autorzy = "Jakub Achtelik, Oliwier Budnik";
    private string $rok = "2023";
    private string $przedmiot = "III Semestr, Zastosowanie Programowania Obiektowego";
    private string $uczelnia = "Politechnika Koszalińska";

    public function  Head() :void
    {
        echo <<<HTML

        <html lang="pl">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="Adrian">
            <meta name="copyright" content="Adrian">
            <meta name="description" content="Prosta aplikacja OOP w języku PHP">
            <meta name="keywords" content="php,oop,mysql">
            <title> {$this->tytul} </title>
            <link rel="stylesheet" href="public/style.css">

            <!-- IKONKI -->
            <link rel="icon" href="public/logo.webp">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/fontawesome.min.js"></script>
            <!-- IKONI::KONIEC -->
        </head>
        <body>

        HTML;
    }

    public  function Header(): void
    {
        echo <<<HTML
        <header>
            <div class="alert alert__nazwa">
            <a href="index.php">
            <img
                src="public/logo.webp"
                alt="Przykładowe logo"
                width="40px"
            >
            </a>
            <a href="index.php">{$this->tytul} </a>
            </div>

            <div class="menu alert">

            <div class="menu__item">
                <a class="fakeBtn" href="index.php">
                    <i class="fa-solid fa-house"></i>
                    <span>Strona Główna</span>
                </a>
            </div>

            <div class="menu__item">
                <a class="fakeBtn" href="index.php?co=formularz_dodaj">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Dodaj</span>
                </a>
            </div>
            <div class="menu__item menu__item--search">
                <form action="index.php?co=szukaj" method="POST">
                    <input class="fakeBtn"  type="text" name="slowo" placeholder="Imie lub nazwisko" required>
                    <button class="fakeBtn" >
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Szukaj</span>
                    </button>
                    </form>
            </div>
            </div>
        </header>
        <main>


        HTML;
    }

    public function Footer(): void 
    {

        echo <<<HTML
            </main>
            <footer class='footer'>
                &COPY; {$this->rok} {$this->autorzy} <br>
                 {$this->przedmiot} <br>
                {$this->uczelnia}
                
            </footer>
            </body>
            </html>
        HTML;
    }

}