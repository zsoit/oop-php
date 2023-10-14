<?php
namespace Pilkanozna\Controller;

include_once './KonfiguracjaApp.php';


class Autoryzacja
{
    private string $login = UZYTKOWNIKADMIN;
    private string $haslo= HASLOADMIN;

    public function __construct() {
        session_start();
    }


    public function SprawdzCzyZalogowano(): void
    {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: /zaloguj');
            exit();
        }
    }

    public function SprobojZalogowac(): void
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {

            $uzytkownik= $this->login;
            $haslo= $this->haslo; 

            if (isset($_POST['uzytkownik']) && isset($_POST['haslo'])) 
            {
                if($_POST['uzytkownik'] === $uzytkownik && $_POST['haslo'] === $haslo)
                {
    
                    $_SESSION['logged_in'] = true;
                    header('Location: /');
                    exit();
                    
                }

                else{
                    echo "<i style='color: red;'>Niepoprawne dane logowania!</i> ";
    
                }
            }
        }
       
    }

    public function Wyloguj(): void
    {
        unset($_SESSION['logged_in']);
        header('Location: /zaloguj');
        exit();
    }
}

?>