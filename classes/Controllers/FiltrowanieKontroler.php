<?php
namespace Pilkanozna\Controllers;
use Pilkanozna\Controllers\KontrolerDanych;

class FiltrowanieKontroler
{
    protected object $Dane;
    protected string $imie;
    protected string $nazwisko;

    protected string $sortowanie;
    
    protected string $noga;
    protected string $kraj;
    protected string $numernakoszulce;
    protected string $pozycja;


    public function __construct() {
        $this->Dane = new KontrolerDanych();
        $this->imie = $this->Dane->getMetoda('imie');
        $this->nazwisko = $this->Dane->getMetoda('nazwisko');
        $this->sortowanie = $this->Dane->getMetoda('sortuj');
        $this->noga = $this->Dane->getMetoda('wiodaca_noga');
        $this->kraj = $this->Dane->getMetoda('fk_kraj');


        $this->numernakoszulce = $this->Dane->getMetoda('fk_numernakoszulce');
        $this->pozycja = $this->Dane->getMetoda('fk_pozycja');

    }
}