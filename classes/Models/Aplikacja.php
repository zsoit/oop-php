<?php

namespace Pilkanozna\Models;


use Pilkanozna\Helper\BazaDanychHelpers;
use Pilkanozna\Models\ZapytaniaSql;
use Pilkanozna\Views\SzablonHtml;
use Pilkanozna\Helper\FormularzHelpers;
use Pilkanozna\Controller\Pilkarz;


class Aplikacja extends BazaDanychHelpers
{

    private object $Pilkarz;
    private object $Formularz;


    public function __construct()
    {

        $this->Formularz = new FormularzHelpers();
        $this->Pilkarz = new Pilkarz();

    }

    protected function Wyswietl(): void
    {
        SzablonHtml::Naglowek("ZAWODNICY ({$this->LiczbaPilkarzy()})");
 
        $wynik = $this->Zapytanie(
            ZapytaniaSql::select_Wyswietl()
        );

        if ($wynik->num_rows > 0)
            while ($wiersz = $wynik->fetch_assoc()) SzablonHtml::Zawodnik($wiersz);
        else SzablonHtml::Naglowek("Brak piłkarzy");
        
                
    }

    protected function Usun(): void
    {
        $imie = "";
        $nazwisko = "";

        $wynik = $this->Zapytanie(
            ZapytaniaSql::select_ZawodnikById($this->Pilkarz->getId())
        );

        while ($wiersz = $wynik->fetch_assoc()){
            $imie = $wiersz['imie'];
            $nazwisko = $wiersz['nazwisko'];
        }

        $potwierdzenie =  (isset($_GET['potwierdzenie'])) ? $_GET['potwierdzenie'] : null;

        if($potwierdzenie == "tak"){

            SzablonHtml::Naglowek("Usunięto piłkarza <b>$imie $nazwisko</b>!");

            $this->Zapytanie(ZapytaniaSql::delete_pilkarz($this->Pilkarz->getId()));
            $this->Zapytanie(ZapytaniaSql::delete_Awatar($this->Pilkarz->getId()));

            $this->Wyswietl();
        }
        else{
            SzablonHtml::PotwierdzUsuniecie($this->Pilkarz->getId(),$imie,$nazwisko);
        }
    }

    protected function Edytuj(): void
    {
        SzablonHtml::Naglowek("EDYCJA");

        $wynik = $this->Zapytanie(
            ZapytaniaSql::select_Edytuj($this->Pilkarz->getId())
        );
        
        while ($wiersz = (array) $wynik->fetch_assoc())
            $this->Formularz->Pilkarz($wiersz, "/zapisz?id={$this->Pilkarz->getId()}", "Zapisz",[$this, 'pobierzDane']);
    }

    protected function Zapisz(): void
    {

        SzablonHtml::Naglowek("Zapisano <b>{$this->Pilkarz->getImie()} {$this->Pilkarz->getNazwisko()}</b>!");
        
        // update info o pilkarzu
        $this->Zapytanie(ZapytaniaSql::update_Zapisz($this->Pilkarz->getId(),$this->Pilkarz->getTablicaPOST(ZapytaniaSql::getWszytkieKolumnyPilkarz()) )
        );
    
        // update obrazka
        $this->Zapytanie(
            ZapytaniaSql::update_Awatar($this->Pilkarz->getAwatar(),$this->Pilkarz->getId())
        );
        
        $this->Wyswietl();
    }


    protected function Formularz_Dodaj(): void
    {
        SzablonHtml::Naglowek("Dodawanie");

        $pusty_formularz = (array)
        $pusty_formularz = $this->Pilkarz->getTablicaPOST(ZapytaniaSql::getWszytkieKolumnyPilkarz());

        $this->Formularz->Pilkarz($pusty_formularz, "/dodaj", "Dodaj",[$this, 'pobierzDane']);
    }

    protected function Dodaj(): void
    {
        SzablonHtml::Naglowek("Dodano <b>{$this->Pilkarz->getImie()} {$this->Pilkarz->getNazwisko()}</b>!");
        
        // ustaw obrazek
        $this->Zapytanie
        (
            ZapytaniaSql::insert_Dodaj(
                $this->Pilkarz->getTablicaPOST(ZapytaniaSql::getWszytkieKolumnyPilkarz())
            )
        );

        $liczba = $this->OstatniPilkarz();

        $this->Zapytanie(
            ZapytaniaSql::insert_Awatar($this->Pilkarz->getAwatar(), $liczba)
        );

        $this->Wyswietl();
      

    }


    private function Filtry(): void
    {
        SzablonHtml::Naglowek("Filtry");

        $this->Formularz->Filtrowanie([$this, 'pobierzDane']);
    }


    protected function Szukaj(): void
    {
        
        $this->Filtry();
        SzablonHtml::Naglowek("Wyniki wyszukiwania:  <b id='szukaneslowo'>{$this->Pilkarz->getSzukaj()}</b>");
        
        $sql = ZapytaniaSql::select_Szukaj($this->Pilkarz->getSzukaj());
        $wynik = $this->Zapytanie(
            $sql
        );

        if ($wynik->num_rows > 0)
            while ($wiersz = $wynik->fetch_assoc()) SzablonHtml::Zawodnik($wiersz);
        else
            SzablonHtml::Naglowek("BRAK");
    }


    protected function Zaloguj(): void
    {

        SzablonHtml::Naglowek("Zaloguj się");
        SzablonHtml::FormularzLogowania();

    }

    protected function Error404(): void
    {
        SzablonHtml::Naglowek("404 - Strona nie istnieje! ");
    }


}

