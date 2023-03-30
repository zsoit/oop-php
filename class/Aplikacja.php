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
        $this->DBZapytanie("SET FOREIGN_KEY_CHECKS=0");
        $this->DBZapytanie("DELETE FROM pilkarz WHERE PK_pilkarz = $this->id");
        $this->DBZapytanie("SET FOREIGN_KEY_CHECKS=1");

        SzablonHtml::Naglowek("Usunięto! Piłkarza #$this->id");
        $this->Wyswietl();
    }

    private function Edytuj(): void
    {
        SzablonHtml::Naglowek("EDYCJA");

        $wynik = $this->DBZapytanie(
            ZapytaniaSql::select_Edytuj($this->id)
        );

        while ($wiersz = (array) $wynik->fetch_assoc())
            SzablonHtml::Formularz($wiersz, "?co=zapisz&id=$this->id");
    }

    private function Zapisz(): void
    {
        SzablonHtml::Naglowek("Zapisano! {$this->Dane->getPOST("imie")}");

        $update = ZapytaniaSql::update_Zapisz(
            $this->id, $this->Dane->setPOST($this->KOLUMNYPILKARZ)
        );

        $this->DBZapytanie($update);

        // KontrolerDanych::Testowanie($update);
        $this->Wyswietl();
    }

    private function Dodaj(): void
    {
        $pusty_formularz = (array)
        $pusty_formularz = $this->Dane->setPOST($this->KOLUMNYPILKARZ);

        SzablonHtml::Naglowek("Dodawanie");
        SzablonHtml::Formularz($pusty_formularz, "?co=dodaj");
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
