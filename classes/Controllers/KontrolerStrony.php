<?php

namespace Pilkanozna;

use Autoryzacja;

include_once './classes/Models/Aplikacja.php';
include_once './classes/Controllers/Autoryzacja.php';


class KontrolerStrony extends Aplikacja
{


    // kontroluje metody GET oraz POST, obsługuje routing strony, "unikalne adresy" , np. /login
    public function Routing(): void
    {

        $autoryzacja = new Autoryzacja;

        $strona= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        switch ($strona) {

            case '/edytuj':
                $autoryzacja->SprawdzCzyZalogowano();
                $this->Edytuj();
                break;

            case '/usun':
                $autoryzacja->SprawdzCzyZalogowano();
                $this->Usun();
                break;

            case '/zapisz':
                $autoryzacja->SprawdzCzyZalogowano();
                $this->Zapisz();
                break;

            case '/dodaj':
                $autoryzacja->SprawdzCzyZalogowano();
                $this->Dodaj();
                break;

            case '/formularz_dodaj':
                $autoryzacja->SprawdzCzyZalogowano();
                $this->Formularz_Dodaj();
                break;

            case '/szukaj':
                $autoryzacja->SprawdzCzyZalogowano();
                $this->Szukaj();
                break;

            case '/zaloguj':
                $autoryzacja->SprobojZalogowac();
                $this->Zaloguj();
                break;
             
            case '/wyloguj':
                $autoryzacja->Wyloguj();
                break;

            case '/':
                $autoryzacja->SprawdzCzyZalogowano();
                $this->Wyswietl();
                break;

            default:
                $this->Error404();
                break;
        }
    }


}
