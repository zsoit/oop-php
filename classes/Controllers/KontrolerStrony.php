<?php

namespace Pilkanozna;

include_once './classes/Models/Aplikacja.php';

class KontrolerStrony extends Aplikacja
{

    // kontroluje metody GET oraz POST, obsługuje routing strony, "unikalne adresy"
    public function Routing(): void
    {
        $strona = isset($_GET['co']) ? $_GET['co']  : '';

        switch ($strona) {

            case 'edytuj':
                $this->Edytuj();
                break;

            case 'usun':
                $this->Usun();
                break;

            case 'zapisz':
                $this->Zapisz();
                break;

            case 'dodaj':
                $this->Dodaj();
                break;

            case 'formularz_dodaj':
                $this->Formularz_Dodaj();
                break;

            case 'szukaj':
                $this->Szukaj();
                break;

            case 'login':
                echo "login";
                break;

            default:
                $this->Wyswietl();
                break;
        }
    }


}
