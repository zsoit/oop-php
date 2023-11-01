<?php

namespace Pilkanozna\Controllers;

use Pilkanozna\Controllers\Autoryzacja;
use Pilkanozna\Models\Aplikacja;


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
                $this->Wyswietl();
                break;


            default:
                $this->Error404();
                break;
        }
    }


}
