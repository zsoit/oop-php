<?php

class Pilkarz

{
    private string $imie;
    private string $nazwisko;
    private int $id;

    protected object $Dane;

    public function __construct() {
        $this->id = $this->Dane->getID();
        $this->imie = $this->Dane->getPOST("imie");
        $this->nazwisko = $this->Dane->getPOST("nazwisko");
    }


}

$p1 = new Pilkarz();

echo $pi->imie;