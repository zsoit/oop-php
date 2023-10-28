<?php
namespace Pilkanozna\Controller;

include_once './KonfiguracjaApp.php';


interface iAutoryzacja
{
    public function SprawdzCzyZalogowano(): void;
    public function SprobojZalogowac(): void;
    public function Wyloguj(): void;

}

class Autoryzacja implements iAutoryzacja
{
    private string $login = UZYTKOWNIKADMIN;
    private string $haslo= HASLOADMIN;

    public function __construct() {
        session_start();
        $this->cssDlaNiezalogowanych();
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



    private function cssDlaNiezalogowanych(): void
    {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            echo <<<HTML
            <style>
            .btn_admin, .card .fakeBtn{
                display: none;
            }
            </style>
            <script>
                const btn_text = document.querySelector(".btn-login span");
                const btn_a = document.querySelector(".btn-login");

                btn_text.textContent = "Zaloguj";
                btn_a.href = "/zaloguj";
            
            </script>
            HTML;
        }
    }
}

?>