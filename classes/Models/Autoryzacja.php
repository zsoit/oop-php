<?php
class Autoryzacja
{
    private string $login = "test";
    private string $haslo= "test";
    private string $error_wiadomosc = "Tylko dla zalogowanych uzytkownikow";

    public function __construct() {
        session_start();
    }

    public function getError(): string
    {
        return $this->error_wiadomosc;
    }

    public function SprawdzCzyZalogowano(): void
    {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: /login');
            exit();
        }
    }

    public function SprobojZalogowac(): void
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {

            $uzytkownik= $this->login;
            $haslo= $this->haslo; 

            if (
                isset($_POST['uzytkownik']) 
                && isset($_POST['haslo']) 
                && $_POST['uzytkownik'] === $uzytkownik 
                && $_POST['haslo'] === $haslo
            ) {
                $_SESSION['logged_in'] = true;
                header('Location: /index.php');
                exit();
            } 
            else 
            {
                $this->error_wiadomosc = 'Login Failed.';
            }
        }
    }

    public function Wyloguj(): void
    {
        unset($_SESSION['logged_in']);
        header('Location: /index.php?co=login');
        exit();
    }
}

?>