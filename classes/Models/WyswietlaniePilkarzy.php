<?php
namespace Pilkanozna\Models;

use Pilkanozna\Controllers\ZarzadzaniePilkarzami;

interface iWyswietlaniePilkarzy
{
    public function WyswietlPilkarzy(mixed $Naglowek, mixed $SzablonZawodnik): void;
    public function WyswietlFiltrowanychPilkarzy(mixed $Naglowek, $SzablonZawodnik): void;
    public function WyswietlFormularzDodawania(): void;
    public function WyswietlFomularzEdycji(): void;
}

class WyswietlaniePilkarzy extends ZarzadzaniePilkarzami implements iWyswietlaniePilkarzy
{
    public function WyswietlPilkarzy(mixed $Naglowek, mixed $SzablonZawodnik): void
    {
        $Naglowek("ZAWODNICY ({$this->LiczbaPilkarzy()})");
 
        $wynik = $this->Zapytanie(
            ZapytaniaSql::select_Wyswietl()
        );

        if ($wynik->num_rows > 0)
            while ($wiersz = $wynik->fetch_assoc()) $SzablonZawodnik($wiersz);
        else $Naglowek("Brak piłkarzy");
    }

    public function WyswietlFiltrowanychPilkarzy(mixed $Naglowek, $SzablonZawodnik): void
    {
        $sql = ZapytaniaSql::Select_Filtruj();

        $wynik = $this->Zapytanie($sql);

        if ($wynik->num_rows > 0)
            while ($wiersz = $wynik->fetch_assoc()) $SzablonZawodnik($wiersz);
        else
            $Naglowek("BRAK");

    }

    public function WyswietlFormularzDodawania(): void
    {
        $pusty_formularz = (array)
        $pusty_formularz = $this->tablicaPost;

        $this->Formularz->FormularzDodawania($pusty_formularz, [$this, 'pobierzDane']);
    }

    public function WyswietlFomularzEdycji(): void
    {
        $wynik = $this->Zapytanie(
            ZapytaniaSql::select_Edytuj($this->id)
        );
        
        while ($wiersz = (array) $wynik->fetch_assoc()) 
            $this->Formularz->FormularzZapisu($wiersz, $this->id, [$this, 'pobierzDane']);
    }

}

