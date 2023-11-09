<?php
namespace Pilkanozna\Models;

use mysqli;


class BazaDanych
{
    private ?mysqli $polaczenie = null;

    public function Polaczenie(): void
    {
        include_once './KonfiguracjaDB.php';
        $this->polaczenie = new mysqli(HOST, UZYTKOWNIK, HASLO, BAZADANYCH, PORT);

        if ($this->polaczenie->connect_error) {
            echo "<h1 style='color: red;'>Błąd połącznia z bazą danych: " . $this->polaczenie->connect_error . "</h1>";
            exit();
        }
    }

    protected function Rozlaczenie(): void
    {
        if ($this->polaczenie) {
            $this->polaczenie->close();
        }
    }

    protected function Zapytanie(string $sql)
    {
        if ($this->polaczenie === null) {
            $this->Polaczenie();
        }

        $zapytanie = $this->polaczenie->query($sql);

        if (!$zapytanie) {
            echo "<p>Błąd w zapytaniu: " . $this->polaczenie->error . "</p>";
            exit();
        }

        return $zapytanie;
    }
}
