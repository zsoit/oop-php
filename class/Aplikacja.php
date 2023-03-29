<?php

namespace Pilkanozna;

include_once 'BazaDanych.php';
include_once 'ZapytaniaSql.php';
include_once 'KontrolerDanych.php';
include_once 'SzablonHtml.php';

class Aplikacja extends BazaDanych
{
    private int $id;
    private $Dane;

    public function __construct()
    {
        $this->DBPolaczenie();

        $this->Dane = new KontrolerDanych();
        $this->id = $this->Dane->getID();
    }

    private function Wyswietl(): void
    {
        SzablonHtml::Naglowek("ZAWODNICY");
        $select = ZapytaniaSql::select_Wyswietl();
        $wynik = mysqli_query($this->polaczenie, $select);

        if ($wynik->num_rows < 0) SzablonHtml::Naglowek("Brak piłkarzy");
        else {
            while ($wiersz = $wynik->fetch_assoc()) SzablonHtml::Zawodnik($wiersz);
        }
    }

    private function Usun(): void
    {
        $keydisable = "SET FOREIGN_KEY_CHECKS=0";
        mysqli_query($this->polaczenie, $keydisable);

        $sql = "DELETE FROM pilkarz WHERE PK_pilkarz = $this->id";
        $zapytanie = mysqli_query($this->polaczenie, $sql);
        if (!$zapytanie) die("Błąd w zapytaniu!");

        SzablonHtml::Naglowek("Usunięto! Piłkarza #$this->id");
        $this->Wyswietl();

        $keyenable = "SET FOREIGN_KEY_CHECKS=1";
        mysqli_query($this->polaczenie, $keyenable);
    }

    private function Edytuj(): void
    {
        $wiersz = (array)
        SzablonHtml::Naglowek("EDYCJA");
        $select = ZapytaniaSql::select_Edytuj($this->id);
        $wynik = mysqli_query($this->polaczenie, $select);
        while ($wiersz = $wynik->fetch_assoc())  SzablonHtml::Formularz($wiersz, "?co=zapisz&id=$this->id");
    }

    private function Zapisz(): void
    {
        SzablonHtml::Naglowek("Zapisano! {$this->Dane->getPOST("imie")}");

        $list = (array)
        $list = [
            "imie", "nazwisko", "wzrost",
            "data_urodzenia", "wiodaca_noga",
            "wartosc_rynkowa", "ilosc_strzelonych_goli",
            "fk_kraj", "fk_numernakoszulce", "fk_pozycja"
        ];

        $update = ZapytaniaSql::update_Zapisz($this->id, $this->Dane->setPOST($list));


        // KontrolerDanych::Testowanie($update);

        $zapytanie = mysqli_query($this->polaczenie, $update);
        if (!$zapytanie) {
            echo "<p>Błąd w zapytaniu!: </p> <br /> <br /> <p>" . mysqli_error($this->polaczenie) . "</p>";
            exit();
        }

        $this->Wyswietl();
    }

    private function Dodaj(): void
    {
        $pusty_formularz = (array)
        $list =  [
            "id", "imie", "nazwisko", "wzrost",
            "data_urodzenia", "wiodaca_noga",
            "wartosc_rynkowa", "ilosc_strzelonych_goli",
            "fk_kraj", "fk_numernakoszulce", "fk_pozycja"
        ];

        $pusty_formularz = $this->Dane->setPOST($list);



        SzablonHtml::Naglowek("Dodawanie");
        SzablonHtml::Formularz($pusty_formularz,"?co=dodaj&id=$this->id");
    }

    public function KontrolerStrony(): void
    {

        $strona = isset($_GET['co']) ? $_GET['co']  : 'domyslna';
        switch ($strona) {
            case 'domyslna':
                $this->Wyswietl();
                break;

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
            default:
                $this->Wyswietl();
                break;
        }
    }

    public function __destruct()
    {
        $this->DBRozlaczenie();
    }
}
