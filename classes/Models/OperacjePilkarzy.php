<?php

namespace Pilkanozna\Models;

use Pilkanozna\Controllers\ZarzadzaniePilkarzami;

interface iOperacjePilkarzy 
{
    public function ZapiszPilkarza(mixed $Naglowek): void;
    public function DodajPilkarza(mixed $Naglowek): void;
    public function UsunPilkarza(mixed $Naglowek, mixed $SzablonPotwierdzenia): void;
    public function FiltrujPilkarzy(): void;
}

class OperacjePilkarzy extends ZarzadzaniePilkarzami implements iOperacjePilkarzy
{
    public function ZapiszPilkarza(mixed $Naglowek): void
    {
        $Naglowek("Zapisano <b>{$this->imie} {$this->nazwisko}</b>!");

        $this->Zapytanie(
            ZapytaniaSql::update_Zapisz($this->id,$this->tablicaPost)
        );

        $this->Zapytanie(
        ZapytaniaSql::update_Awatar($this->awatar,$this->id)
        );
    }

    public function DodajPilkarza(mixed $Naglowek): void
    {
        $Naglowek("Dodano <b>{$this->imie} {$this->nazwisko}</b>!");
        
        $this->Zapytanie
        (
            ZapytaniaSql::insert_Dodaj(
                $this->Pilkarz->getTablicaPOST(ZapytaniaSql::getWszytkieKolumnyPilkarz())
            )
        );

        $liczba = $this->OstatniPilkarz();

        $this->Zapytanie(
            ZapytaniaSql::insert_Awatar($this->awatar, $liczba)
        );
    }

    public function UsunPilkarza(mixed $Naglowek, mixed $SzablonPotwierdzenia): void
    {
        $imie = "";
        $nazwisko = "";

        $wynik = $this->Zapytanie(
            ZapytaniaSql::select_ZawodnikById($this->id)
        );

        while ($wiersz = $wynik->fetch_assoc()){
            $imie = $wiersz['imie'];
            $nazwisko = $wiersz['nazwisko'];
        }

        $potwierdzenie =  (isset($_GET['potwierdzenie'])) ? $_GET['potwierdzenie'] : null;

        if($potwierdzenie == "tak"){

            $Naglowek("Usunięto piłkarza <b>$imie $nazwisko</b>!");

            $this->Zapytanie(ZapytaniaSql::delete_pilkarz($this->id));
            $this->Zapytanie(ZapytaniaSql::delete_Awatar($this->id));

            header( "refresh:1;url=/" );


        }
        else{
            $SzablonPotwierdzenia($this->id,$imie,$nazwisko);
        }
    }

    public function FiltrujPilkarzy(): void
    {
        $this->Formularz->Filtrowanie([$this, 'pobierzDane']);
    } 
}