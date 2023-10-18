<?php

namespace Pilkanozna\Models;


use Pilkanozna\Helper\BazaDanychHelper;
use Pilkanozna\Models\ZapytaniaSql;
use Pilkanozna\Controller\KontrolerDanych;
use Pilkanozna\Views\SzablonHtml;
use Pilkanozna\Helper\FormularzHelper;


// klasa Pilkarz

class Aplikacja extends BazaDanychHelper
{
    protected int $id;

    protected object $Dane;
    private string $imie;
    private string $nazwisko;
    private string $szukaj;

    private object $Wikipedia;
    private mixed $link;

    private object $Formularz;


    public function __construct()
    {

        $this->Dane = new KontrolerDanych();

        $this->id = $this->Dane->getID();
        $this->imie = $this->Dane->getPOST("imie");
        $this->nazwisko = $this->Dane->getPOST("nazwisko");
        $this->szukaj = $this->Dane->getPOST('slowo');

        $this->Wikipedia = new PobieraczObrazowWikipedia($this->imie, $this->nazwisko);
        $this->Formularz = new FormularzHelper();

        $this->link = $this->Wikipedia->updateObrazka();


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

            SzablonHtml::Naglowek("Usunięto piłkarza <b>$imie $nazwisko</b>!");

            $this->Zapytanie(ZapytaniaSql::delete_pilkarz($this->id));
            $this->Zapytanie(ZapytaniaSql::delete_Awatar($this->id));

            $this->Wyswietl();
        }
        else{
            SzablonHtml::PotwierdzUsuniecie($this->id,$imie,$nazwisko);
        }
    }

    protected function Edytuj(): void
    {
        SzablonHtml::Naglowek("EDYCJA");

        $wynik = $this->Zapytanie(
            ZapytaniaSql::select_Edytuj($this->id)
        );
        
        while ($wiersz = (array) $wynik->fetch_assoc())
            $this->Formularz->Pilkarz($wiersz, "/zapisz?id=$this->id", "Zapisz",[$this, 'fetchData']);
    }

    protected function Zapisz(): void
    {

        SzablonHtml::Naglowek("Zapisano <b>$this->imie $this->nazwisko</b>!");
        
        // update info o pilkarzu
        $this->Zapytanie(
            ZapytaniaSql::update_Zapisz(
                $this->id,
                $this->Dane->setPOST(ZapytaniaSql::getWszytkieKolumnyPilkarz())
        )
        );
    
        // update obrazka
        $this->Zapytanie(
            ZapytaniaSql::update_Awatar($this->link,$this->id)
        );
        
        $this->Wyswietl();
    }


    protected function Formularz_Dodaj(): void
    {
        SzablonHtml::Naglowek("Dodawanie");

        $pusty_formularz = (array)
        $pusty_formularz = $this->Dane->setPOST(ZapytaniaSql::getWszytkieKolumnyPilkarz());

        $this->Formularz->Pilkarz($pusty_formularz, "/dodaj", "Dodaj",[$this, 'fetchData']);
    }

    protected function Dodaj(): void
    {
        SzablonHtml::Naglowek("Dodano <b>$this->imie $this->nazwisko</b>!");
        
        // ustaw obrazek
        $this->Zapytanie
        (
            ZapytaniaSql::insert_Dodaj(
                $this->Dane->setPOST(ZapytaniaSql::getWszytkieKolumnyPilkarz())
            )
        );

        $liczba = $this->OstatniPilkarz();

        $this->Zapytanie(
            ZapytaniaSql::insert_Awatar($this->link, $liczba)
        );

        $this->Wyswietl();
      

    }

    protected function Szukaj(): void
    {

        SzablonHtml::Naglowek("Wyniki wyszukiwania:  <b>$this->szukaj</b>");

        $sql = ZapytaniaSql::select_Szukaj($this->szukaj);
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

    protected function Filtry(): void
    {
        SzablonHtml::Naglowek("Filtry");
        SzablonHtml::Filtry();
    }





}

