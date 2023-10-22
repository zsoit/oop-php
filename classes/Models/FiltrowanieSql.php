<?php
namespace Pilkanozna\Models;

use Pilkanozna\Controller\FiltrowanieKontroler;

class FiltrowanieSql extends FiltrowanieKontroler
{
   
    public static function getWyswietl(): string
    {
        return <<<SQL
        SELECT PK_pilkarz as 'id', imie, nazwisko, wzrost, data_urodzenia, wiodaca_noga, wartosc_rynkowa,
        ilosc_strzelonych_goli,
        krajpilkarza.nazwa as 'pilkarzkraj', numernakoszulce.numer, pozycja.nazwa as 'pozycja',
        awatar.link as 'link'
        FROM pilkarz
        join krajpilkarza on FK_kraj=PK_kraj
        join numernakoszulce on FK_numernakoszulce=PK_numernakoszulce
        join pozycja on FK_pozycja=PK_pozycja
        join awatar on Fk_pilkarz=Pk_pilkarz
        SQL;
    }

    public function setSql($kolumna,$parametr)
    {
        $sql = " $kolumna='$parametr'";
        $sql = $this->sprawdzCzyUstawiono($parametr,$sql);

        if($sql == "") $sql = " $kolumna IS NOT NULL ";

        return $sql;
    }


    private function getImie(): string
    {

        return $this->setSql("imie",$this->imie);
    }

    private function getNazwisko(): string
    {
        return $this->setSql("nazwisko",$this->nazwisko);
    }



    private function getNoga(): string
    {
        return $this->setSql("pilkarz.wiodaca_noga",$this->noga);
    }

    private function getKraj(): string
    {
        return $this->setSql("pilkarz.fk_kraj",$this->kraj);
    }

    private function getNumernakoszulce(): string
    {
       return $this->setSql("pilkarz.fk_numernakoszulce",$this->numernakoszulce);
    }


    private function getPozycja(): string
    {
        return $this->setSql("pilkarz.fk_pozycja",$this->pozycja);
    }


    private function getSortowanie(): mixed
    {
        $SqlSortowanie = " ORDER BY ";
        switch($this->sortowanie)
        {
    
            case 'najnowsze':
                $SqlSortowanie .= "pk_pilkarz ASC";
                break;
            
            case 'najstarsze':
                $SqlSortowanie .= "pk_pilkarz DESC";
                break;        

            case 'a-z':
                $SqlSortowanie .= "nazwisko ASC";
                break;
            
            case 'z-a':
                $SqlSortowanie .= "nazwisko DESC";
                break;

            case "wzrost-desc":
                $SqlSortowanie .= "wzrost DESC";
                break;
            
            case "wzrost-asc":
                $SqlSortowanie .= "wzrost ASC";

                 break;

            case "dataurodzania-desc":
                $SqlSortowanie .= "data_urodzenia DESC";
                break;
                
            case "dataurodzania-asc":
                $SqlSortowanie .= "data_urodzenia ASC";
                break;


            case "wartosc-desc":
                $SqlSortowanie .= "wartosc_rynkowa DESC";
                break;
        
            case "wartosc-asc":
                $SqlSortowanie .= "wartosc_rynkowa ASC";
                break;                       
        }

        $SqlSortowanie = $this->sprawdzCzyUstawiono($this->sortowanie,$SqlSortowanie);
        
        return $SqlSortowanie;
    }


    public function sprawdzCzyUstawiono($parametr, $sql): mixed
    {
        return ($parametr != "") ? $sql : "";

    }


    public function sprawdzWhere(): bool
    {
        if(
            $this->imie OR 
            $this->nazwisko OR
            $this->noga OR
            $this->kraj OR
            $this->numernakoszulce OR
            $this->pozycja
        )
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function getWhere(): mixed
    {
        if($this->sprawdzWhere()) return " WHERE ";
        else return false;
    }

    public function ZapytanieDlaWhere(): string
    {
        $Imie = $this->getImie();
        $Nazwisko = $this->getNazwisko();
        $Noga = $this->getNoga();
        $Kraj = $this->getKraj();

        $Numer = $this->getNumernakoszulce();
        $Pozycja = $this->getPozycja();


        $Sql = $Imie . " AND " . $Nazwisko . 
        " AND " . $Noga  . " AND " . $Kraj
        . " AND " . $Numer . " AND " . $Pozycja
        ;


        return $Sql;

    }


    public function getCaleZapytanie(): string
    {
        $Poczatek = $this->getWyswietl();
        $Sortowanie = $this->getSortowanie();
        $Where = $this->getWhere();

        $ZapytaniaDlaWhere = $this->ZapytanieDlaWhere();

        $Sql = $Poczatek;

        if(!$Where) return $Sql . $Sortowanie;
        
        $Sql .= $Where . $ZapytaniaDlaWhere . $Sortowanie;
        return $Sql;

    }
}
