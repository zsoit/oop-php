<?php
namespace Pilkanozna;
class BazaDanych
{
    protected $polaczenie;
    protected function DBPolaczenie(){

        include_once 'KonfiguracjaDB.php';
        $this->polaczenie = mysqli_connect(HOST,UZYTKOWNIK,HASLO,BAZADANYCH);
        if(!$this->polaczenie)
        {
            echo "Błąd połącznia z bazą danych!";
            exit();
        }
    }

    protected function DBRozlaczenie()
    {
        mysqli_close($this->polaczenie);
    }

}