<?php

namespace Pilkanozna\Controllers;
use Pilkanozna\Models\PobieraczObrazowWikipedia;
use Pilkanozna\Controllers\KontrolerDanych;

class PilkarzPost

{
    private int $id;
    private string $imie;
    private string $nazwisko;
    private string $awatar;

    private object $Dane;
    private object $Wikipedia;

    public function __construct() {
        $this->Dane = new KontrolerDanych();
        
        $this->id = $this->Dane->getID();
        $this->imie = $this->Dane->getPOST("imie");
        $this->nazwisko = $this->Dane->getPOST("nazwisko");
        
        $this->Wikipedia = new PobieraczObrazowWikipedia($this->imie, $this->nazwisko);
        $this->awatar = $this->Wikipedia->updateObrazka();
    }

    public function getId(): int { return $this->id;}

    public function getImie(): string{ return $this->imie; }

    public function getNazwisko(): string{ return $this->nazwisko;}

    public function getAwatar(): mixed { return $this->awatar;}


    public function getTablicaPOST($lista): mixed
    {
        $tablica = $this->Dane->setPOST($lista);
        return $tablica;
    }

}
