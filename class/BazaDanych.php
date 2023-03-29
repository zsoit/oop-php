<?php
namespace Pilkanozna;
class BazaDanych
{
    protected object $polaczenie;
    protected function DBPolaczenie(): void
    {

        include_once './KonfiguracjaDB.php';
        $this->polaczenie = mysqli_connect(HOST,UZYTKOWNIK,HASLO,BAZADANYCH);
        if(!$this->polaczenie)
        {
            echo "Błąd połącznia z bazą danych!";
            exit();
        }
    }

    protected function DBRozlaczenie(): void
    {
        mysqli_close($this->polaczenie);
    }

}