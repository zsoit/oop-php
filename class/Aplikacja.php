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
        SzablonHtml::Naglowek("ZAWODNICY ({$this->LiczbaPilkarzy()})");

        $wynik = $this->DBZapytanie(
            ZapytaniaSql::select_Wyswietl()
        );

        if ($wynik->num_rows > 0)
            while ($wiersz = $wynik->fetch_assoc()) SzablonHtml::Zawodnik($wiersz);
        else
            SzablonHtml::Naglowek("Brak piłkarzy");
    }

    private function Usun(): void
    {
        $imie = "";
        $nazwisko = "";

        $wynik = $this->DBZapytanie(
            ZapytaniaSql::select_ZawodnikById($this->id)
        );
        while ($wiersz = $wynik->fetch_assoc())
        {
            $imie = $wiersz['imie'];
            $nazwisko = $wiersz['nazwisko'];
        }

        $potwierdzenie =  (isset($_GET['potwierdzenie'])) ? $_GET['potwierdzenie'] : null;
        if($potwierdzenie == "tak")
        {
            $this->DBZapytanie("SET FOREIGN_KEY_CHECKS=0");
            $this->DBZapytanie("DELETE FROM pilkarz WHERE PK_pilkarz = $this->id");
            $this->DBZapytanie("SET FOREIGN_KEY_CHECKS=1");

            SzablonHtml::Naglowek("Usunięto piłkarza <b>$imie $nazwisko</b>!");
            $this->Wyswietl();
        }
        else{
            SzablonHtml::PotwierdzUsuniecie($this->id,$imie,$nazwisko);
        }
    }

    private function Edytuj(): void
    {
        SzablonHtml::Naglowek("EDYCJA");

        $wynik = $this->DBZapytanie(
            ZapytaniaSql::select_Edytuj($this->id)
        );

        while ($wiersz = (array) $wynik->fetch_assoc())
            $this->Formularz($wiersz, "?co=zapisz&id=$this->id", "Zapisz");
    }

    private function Zapisz(): void
    {
        $imie = $this->Dane->getPOST("imie");
        $nazwisko = $this->Dane->getPOST("nazwisko");

        SzablonHtml::Naglowek("Zapisano <b>$imie $nazwisko</b>!");

        $update = ZapytaniaSql::update_Zapisz(
            $this->id,
            $this->Dane->setPOST($this->KOLUMNYPILKARZ)
        );

        $this->DBZapytanie($update);

        $this->Wyswietl();
    }


    private function Formularz_Dodaj(): void
    {
        $pusty_formularz = (array)
        $pusty_formularz = $this->Dane->setPOST($this->KOLUMNYPILKARZ);

        SzablonHtml::Naglowek("Dodawanie");
        $this->Formularz($pusty_formularz, "?co=dodaj", "Dodaj");
    }

    private function Dodaj(): void
    {
        $imie = $this->Dane->getPOST("imie");
        $nazwisko = $this->Dane->getPOST("nazwisko");

        SzablonHtml::Naglowek("Dodano <b>$imie $nazwisko</b>!");

        $update = ZapytaniaSql::insert_Dodaj(
            $this->Dane->setPOST($this->KOLUMNYPILKARZ)
        );

        $this->DBZapytanie($update);

        $this->Wyswietl();

    }

    private function Szukaj(): void
    {

        $szukaj = $this->Dane->getPOST('slowo');

        SzablonHtml::Naglowek("Wyniki wyszukiwania:  <b>$szukaj</b>");

        $sql = ZapytaniaSql::select_Szukaj($szukaj);
        $wynik = $this->DBZapytanie(
            $sql
        );

        if ($wynik->num_rows > 0)
            while ($wiersz = $wynik->fetch_assoc()) SzablonHtml::Zawodnik($wiersz);
        else
            SzablonHtml::Naglowek("BRAK");
    }


    private function LiczbaPilkarzy(): int
    {
        $wynik = $this->DBZapytanie(
            ZapytaniaSql::liczbaZawodnikow()
        );
        $wiersz = $wynik->fetch_assoc();
        return  $wiersz['liczba_pilkarzy'];
    }

    // FORMULARZ

    public function SelectHTML($zapytanie, $id, $nazwa, $fk): string
    {
        $wynik = $this->DBZapytanie($zapytanie);

        $html = "<select name='$fk'>";
        while ($wiersz = (array) $wynik->fetch_assoc()) {
            $html .=  "<option value='{$wiersz[$id]}'>{$wiersz[$nazwa]}</option>";
        }
        $html .=  "</select>";

        return $html;
    }

    private function Formularz($dane, $adres, $napisprzycisk): void
    {

        $sqlkraj = ZapytaniaSql::select_Kraj();
        $select_kraje_html = $this->SelectHTML($sqlkraj, 'pk_kraj', 'nazwa', 'fk_kraj');

        $sqlnumer = ZapytaniaSql::select_Numernakoszulce();
        $select_numernakoszulce_html = $this->SelectHTML($sqlnumer, 'pk_numernakoszulce', 'numer', 'fk_numernakoszulce');

        $sqlpozycja = ZapytaniaSql::select_Pozycja();
        $select_pozycja_html = $this->SelectHTML($sqlpozycja, 'pk_pozycja', 'nazwa', 'fk_pozycja');

        SzablonHtml::Formularz(
            $dane,
            $adres,
            $select_kraje_html,
            $select_numernakoszulce_html,
            $select_pozycja_html,
            $napisprzycisk
        );
    }

    // ! FORMULARZ


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
                break;;

            case 'dodaj':
                $this->Dodaj();
                break;;

            case 'formularz_dodaj':
                $this->Formularz_Dodaj();
                break;

            case 'szukaj':
                $this->Szukaj();
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
