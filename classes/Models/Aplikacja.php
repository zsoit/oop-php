<?php

namespace Pilkanozna\Models;

use Pilkanozna\Models\BazaDanych;
use Pilkanozna\Models\ZapytaniaSql;
use Pilkanozna\Controller\KontrolerDanych;
use Pilkanozna\Views\SzablonHtml;


class Aplikacja extends BazaDanych
{
    protected int $id;
    protected $Dane;

    private $imie;
    private $nazwisko;

    private $PobieraczObrazow;

    public function __construct()
    {
        $this->DBPolaczenie();

        $this->Dane = new KontrolerDanych();
        $this->id = $this->Dane->getID();
        
        $this->imie = $this->Dane->getPOST("imie");
        $this->nazwisko = $this->Dane->getPOST("nazwisko");
        $this->PobieraczObrazow = new PobieraczObrazowWikipedia($this->imie, $this->nazwisko);

    }

    public function __destruct()
    {
        $this->DBRozlaczenie();
    }


    protected function Wyswietl(): void
    {
        SzablonHtml::Naglowek("ZAWODNICY ({$this->LiczbaPilkarzy()})");
 
        $wynik = $this->DBZapytanie(
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

            SzablonHtml::Naglowek("Usunięto piłkarza <b>$imie $nazwisko</b>!");

            $this->DBZapytanie("DELETE FROM pilkarz WHERE PK_pilkarz = $this->id");
            $this->DBZapytanie(ZapytaniaSql::delete_Awatar($this->id));

            $this->Wyswietl();
        }
        else{
            SzablonHtml::PotwierdzUsuniecie($this->id,$imie,$nazwisko);
        }
    }

    protected function Edytuj(): void
    {
        SzablonHtml::Naglowek("EDYCJA");

        $wynik = $this->DBZapytanie(
            ZapytaniaSql::select_Edytuj($this->id)
        );
        
        while ($wiersz = (array) $wynik->fetch_assoc())
            $this->Formularz($wiersz, "/zapisz?id=$this->id", "Zapisz");
    }

    protected function Zapisz(): void
    {

        SzablonHtml::Naglowek("Zapisano <b>$this->imie $this->nazwisko</b>!");
        

        // update info o pilkarzu
        $this->DBZapytanie(
            ZapytaniaSql::update_Zapisz(
                $this->id,
                $this->Dane->setPOST(ZapytaniaSql::getWszytkieKolumnyPilkarz())
        )
        );
    
        // update obrazka
        $this->PobieraczObrazow->pobierzDaneObrazu();
        $link = $this->PobieraczObrazow->pobierzZrodloPierwszejStrony();

        $this->DBZapytanie(
            ZapytaniaSql::update_Awatar($link,$this->id)
        );
        
        $this->Wyswietl();
    }


    protected function Formularz_Dodaj(): void
    {
        SzablonHtml::Naglowek("Dodawanie");

        $pusty_formularz = (array)
        $pusty_formularz = $this->Dane->setPOST(ZapytaniaSql::getWszytkieKolumnyPilkarz());

        $this->Formularz($pusty_formularz, "/dodaj", "Dodaj");
    }

    protected function Dodaj(): void
    {
        SzablonHtml::Naglowek("Dodano <b>$this->imie $this->nazwisko</b>!");
        
        // ustaw obrazek
        $this->PobieraczObrazow->pobierzDaneObrazu();
        $link = $this->PobieraczObrazow->pobierzZrodloPierwszejStrony();
        

        $this->DBZapytanie
        (
            ZapytaniaSql::insert_Dodaj(
                $this->Dane->setPOST(ZapytaniaSql::getWszytkieKolumnyPilkarz())
            )
        );

        $liczba = $this->OstatniPilkarz();

        $this->DBZapytanie(
            ZapytaniaSql::insert_Awatar($link, $liczba)
        );

        $this->Wyswietl();
      

    }

    protected function Szukaj(): void
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

    protected function Formularz($dane, $adres, $napisprzycisk): void
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


    // Zwracanie wynikow z bazy podstaowoych

    protected function LiczbaPilkarzy(): int
    {
        $wynik = $this->DBZapytanie(ZapytaniaSql::liczbaZawodnikow());
        $wiersz = $wynik->fetch_assoc();
        return  $wiersz['liczba_pilkarzy'];
    }

    protected function OstatniPilkarz(): int
    {
        $wynik = $this->DBZapytanie(ZapytaniaSql::select_ostaniZawodnik());
        $wiersz = $wynik->fetch_array();
        return  $wiersz[0];
    }

}

