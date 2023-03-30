<?php

namespace Pilkanozna;

class BazaDanych
{

    private object $polaczenie;

    protected function DBPolaczenie(): void
    {

        include_once './KonfiguracjaDB.php';
        $this->polaczenie = mysqli_connect(HOST, UZYTKOWNIK, HASLO, BAZADANYCH);
        if (!$this->polaczenie) {
            echo "Błąd połącznia z bazą danych!";
            exit();
        }
    }

    protected function DBRozlaczenie(): void
    {
        mysqli_close($this->polaczenie);
    }

    protected function DBZapytanie(string $sql)
    {
        $zapytanie = mysqli_query($this->polaczenie, $sql);

        if (!$zapytanie) {
            echo "<p>Błąd w zapytaniu!" . mysqli_error($this->polaczenie) . "</p>";
            exit();
        }

        return $zapytanie;

    }

    protected array $KOLUMNYPILKARZ = [
        "id", "imie", "nazwisko", "wzrost",
        "data_urodzenia", "wiodaca_noga",
        "wartosc_rynkowa", "ilosc_strzelonych_goli",
        "fk_kraj", "fk_numernakoszulce", "fk_pozycja"
    ];



}
