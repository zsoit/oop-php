<?php
namespace Pilkanozna;
include_once 'BazaDanych.php';
include_once 'ZapytaniaSql.php';
include_once 'SzablonHtml.php';

class Aplikacja extends BazaDanych
{

    public function __construct()
    {
        $this->DBPolaczenie();
    }

    // POBIERA ID Z LINKU
    private function getID()
    {
        if (isset($_GET['id'])) return $_GET['id'];
        else null;
    }

    // POBIERA POLE Z FORMULARZA
    private function getPOST($nazwa)
    {
        if(isset($_POST[$nazwa])) return $_POST[$nazwa];
        else return null;
    }

    // POBIERA I USTAWIA POLA Z FORMULARZA DO NOWEJ TABLICY
    private function setPOST($lista)
    {
        $setPOST = array();
        foreach($lista as $element)
        {
            $setPOST[$element] = $this->getPOST($element);
        }

        return $setPOST;

    }

    private function Wyswietl()
    {
        $select = ZapytaniaSql::select_Wyswietl();
        $wynik = mysqli_query($this->polaczenie, $select);
        if ($wynik->num_rows < 0) SzablonHtml::Alert("Brak piłkarzy");
        else
        {
            while ($wiersz = $wynik->fetch_assoc()) SzablonHtml::Card($wiersz);
        }
    }

    private function Usun()
    {
        $keydisable = "SET FOREIGN_KEY_CHECKS=0";
        mysqli_query($this->polaczenie, $keydisable);

        $id = $this->getID();
        $sql = "DELETE FROM pilkarz WHERE PK_pilkarz = $id";
        $zapytanie = mysqli_query($this->polaczenie, $sql);
        if (!$zapytanie) die("Błąd w zapytaniu!");

        SzablonHtml::Alert("Usunięto! Piłkarza #$id");
        $this->Wyswietl();

        $keyenable = "SET FOREIGN_KEY_CHECKS=1";
        mysqli_query($this->polaczenie, $keyenable);
    }

    private function Edytuj()
    {

        SzablonHtml::Alert("EDYCJA");
        $id = $this->getID();

        $select = ZapytaniaSql::select_Edytuj($id);
        $wynik = mysqli_query($this->polaczenie, $select);
        while ($wiersz = $wynik->fetch_assoc())  SzablonHtml::Formularz($wiersz);

    }

    private function Zapisz()
    {
        SzablonHtml::Alert("Zapisano! {$this->getPOST("imie")}!");

        $id = $this->getID();

        $list = [
            "imie", "nazwisko", "wzrost",
            "data_urodzenia", "wiodaca_noga",
            "wartosc_rynkowa", "ilosc_strzelonych_goli",
            "fk_kraj","fk_numernakoszulce","fk_pozycja"
        ];
        $update = ZapytaniaSql::update_Zapisz($id,$this->setPOST($list));

        // DEBUGOWANIE ZAPYTANIA:
        // echo "<pre>$update</pre>";

        $zapytanie = mysqli_query($this->polaczenie,$update);
        if(!$zapytanie){
            echo "<p>Błąd w zapytaniu!: </p> <br /> <br /> <p>" . mysqli_error($this->polaczenie) . "</p>";
            exit();
        }

        $this->Wyswietl();

    }

    public function KontrolerStrony()
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
