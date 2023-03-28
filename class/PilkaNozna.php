<?php
include_once 'BazaDanych.php';
include_once 'SzablonHtml.php';

class PilkaNozna extends BazaDanych
{

    public function __construct()
    {
        $this->DBPolaczenie();
    }

    private function getID()
    {
        if (isset($_GET['id'])) return $_GET['id'];
        else null;
    }

    private function getPOST($nazwa){
        if(isset($_POST[$nazwa])) return $_POST[$nazwa];
        else return null;
    }

    private function Wyswietl()
    {

        $select = <<<SQL
        SELECT PK_pilkarz as 'id', imie, nazwisko, wzrost, data_urodzenia, wiodaca_noga, wartosc_rynkowa, ilosc_strzelonych_goli, krajpilkarza.nazwa as 'pilkarzkraj', numernakoszulce.numer, pozycja.nazwa as 'pozycja'
        FROM pilkarz
        join krajpilkarza on FK_kraj=PK_kraj
        join numernakoszulce on FK_numernakoszulce=PK_numernakoszulce
        join pozycja on FK_pozycja=PK_pozycja order by pk_pilkarz
        SQL;

        $wynik = mysqli_query($this->polaczenie, $select);
        if ($wynik->num_rows < 0) SzablonHtml::Alert("Brak piłkarzy");
        else {
            while ($wiersz = $wynik->fetch_assoc()) {
                SzablonHtml::Card($wiersz);
            }
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
        $id = $this->getID();
        SzablonHtml::Alert("EDYCJA");

        $select = <<<SQL
        SELECT PK_pilkarz as 'id', imie, nazwisko, wzrost, data_urodzenia, wiodaca_noga, wartosc_rynkowa, ilosc_strzelonych_goli, krajpilkarza.nazwa as 'pilkarzkraj', numernakoszulce.numer, pozycja.nazwa as 'pozycja'
        FROM pilkarz
        join krajpilkarza on FK_kraj=PK_kraj
        join numernakoszulce on FK_numernakoszulce=PK_numernakoszulce
        join pozycja on FK_pozycja=PK_pozycja
        where `pk_pilkarz` = $id
        SQL;

        $wynik = mysqli_query($this->polaczenie, $select);
        while ($wiersz = $wynik->fetch_assoc()) {
            SzablonHtml::Formularz($wiersz);
        }
    }

    private function Zapisz()
    {
        SzablonHtml::Alert("Zapisano! {$this->getPOST("imie")}!");

        $id = $this->getID();

        $update = <<<SQL
        UPDATE pilkarz SET
        `imie` = `{$this->getPOST("imie")}`,
        `nazwisko` = `{$this->getPOST("nazwisko")}`,
        `wzrost` = `{$this->getPOST("wzrost")}`,
        `data_urodzenia` = `{$this->getPOST("data_urodzenia")}`,
        `wiodaca_noga` = `{$this->getPOST("wiodaca_noga")}`,
        `wartosc_rynkowa` = `{$this->getPOST("wartosc_rynkowa")}`,
        `ilosc_strzelonych_goli` = `{$this->getPOST("ilosc_strzelonych_goli")}`,
        `fk_kraj` = `2`,
        `fk_numernakoszulce` = `3`,
        `fk_pozycja` = `8`
        WHERE `PK_pilkarz` = $id
        SQL;

        $update2 = "UPDATE `pilkarz` SET `imie` = '{$this->getPOST("imie")}' WHERE `pilkarz`.`PK_pilkarz` = $id;";

        echo "<pre>
        $update
        </pre>";

        $zapytanie = mysqli_query($this->polaczenie,$update2) or die("BŁĄD W ZAPYTANIU! " .  mysqli_error($this->polaczenie));

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
