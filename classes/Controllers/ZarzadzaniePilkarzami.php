<?php

namespace Pilkanozna\Controller;

use Pilkanozna\Models\ZapytaniaSql;
use Pilkanozna\Helper\BazaDanychHelper;
use Pilkanozna\Controller\PilkarzPost;
use Pilkanozna\Helper\FormularzHelper;


class ZarzadzaniePilkarzami extends BazaDanychHelper
{
    protected object $Pilkarz;
    protected object $Formularz;

    protected string $id;
    protected string $imie;
    protected string $nazwisko;
    protected string $awatar;
    protected array $tablicaPost;


    public function __construct() {
        $this->Pilkarz = new PilkarzPost();
        $this->Formularz = new FormularzHelper();

        $this->id = $this->Pilkarz->getId();
        $this->imie = $this->Pilkarz->getImie();
        $this->nazwisko = $this->Pilkarz->getNazwisko();
        $this->awatar = $this->Pilkarz->getAwatar();
        $this->tablicaPost = $this->Pilkarz->getTablicaPOST(ZapytaniaSql::getWszytkieKolumnyPilkarz());
    }
}



