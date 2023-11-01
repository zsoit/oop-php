<?php

namespace Pilkanozna\Helpers;

use Pilkanozna\Models\BazaDanych;
use Pilkanozna\Models\ZapytaniaSql;


class BazaDanychHelper extends BazaDanych
{

    public function __construct()
    {;
        $this->Polaczenie();
    }

    public function __destruct()
    {
        $this->Rozlaczenie();
    }


    public function pobierzDane($sql, $idkolumny, $nazwakolumny): array
    {
        $wynik = $this->Zapytanie($sql);
        $dane = [];

        while ($wiersz = $wynik->fetch_assoc()) {
            $dane[] = [
                $idkolumny => $wiersz[$idkolumny],
                $nazwakolumny => $wiersz[$nazwakolumny],
            ];
        }

        return $dane;
    }

    public function LiczbaPilkarzy(): int
    {
        $wynik = $this->Zapytanie(ZapytaniaSql::liczbaZawodnikow());
        $wiersz = $wynik->fetch_assoc();
        return  $wiersz['liczba_pilkarzy'];
    }

    public function OstatniPilkarz(): int
    {
        $wynik = $this->Zapytanie(ZapytaniaSql::select_ostaniZawodnik());
        $wiersz = $wynik->fetch_array();
        return  $wiersz[0];
    }

}