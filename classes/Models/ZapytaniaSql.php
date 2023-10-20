<?php
namespace Pilkanozna\Models;

use Pilkanozna\Controller\KontrolerDanych;

class FiltrowanieSql
{
    private object $Dane;
    private $szukane;
    private $sortowanie;
    
    private $noga;
    private $kraj;
    private $numernakoszulce;
    private $pozycja;


    public function __construct() {
        $this->Dane = new KontrolerDanych();
        $this->szukane = $this->Dane->getMetoda('szukane');
        $this->sortowanie = $this->Dane->getMetoda('sortowanie');
        $this->noga = $this->Dane->getMetoda('wiodaca_noga');
        $this->kraj = $this->Dane->getMetoda('wartosc_rynkowa');
        $this->numernakoszulce = $this->Dane->getMetoda('numernakoszulce');
        $this->pozycja = $this->Dane->getMetoda('pozycja');

    }
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


    private function getSzukane(): string
    {

        $sql = "";

        $sql = $this->szukane;

        return $sql;

    }

    private function getSortowanie(): string
    {
        $SqlSortowanie = "ORDER BY ";
        switch($this->sortowanie)
        {
    
            case 'najnowsze':
                $SqlSortowanie += "pk_pilkarz ASC";
                break;
            
            case 'najstarsze':
                $SqlSortowanie += "pk_pilkarz DESC";
                break;        

            case 'a-z':
                $SqlSortowanie += "nazwisko ASC";
                break;
            
            case 'z-a':
                $SqlSortowanie += "nazwisko DESC";
                break;

            case "wzrost-desc":
                $SqlSortowanie += "wzrost DESC";
                break;
            
            case "wzrost-asc":
                $SqlSortowanie += "wzrost ASC";
                 break;

            case "dataurodzenia-desc":
                $SqlSortowanie += "data_urodzenia DESC";
                break;
                
            case "dataurodzenia-asc":
                $SqlSortowanie += "data_urodzenia ASC";
                break;


            case "wartosc-desc":
                $SqlSortowanie += "wartosc_rynkowa DESC";
                break;
        
            case "wartosc-asc":
                $SqlSortowanie += "wartosc_rynkowa ASC";
                break;                       
        }

        return $SqlSortowanie;
    }

    private function getNoga(): string
    {
        $noga = $this->noga;
        $sql = "WHERE pilkarz.wiodoca_noga='$noga'";
        return $sql;

    }

    private function getKraj(): string
    {
        $kraj = $this->kraj;
        $sql = "WHERE krajpilkarza.pk_kraj='$kraj'";
        return $sql;

    }

    private function getNumernakoszulce(): string
    {
        $numer = $this->numernakoszulce;
        $sql = "WHERE numernakoszulce.numer='$numer'";
        return $sql;

    }


    private function getPozycja(): string
    {
        $pozcyja = $this->pozycja;
        $sql = "WHERE pozycja.pk_pozycja='$pozcyja'";
        return $sql;

    }

    public function sprawdzCzyUstawiono($parametr)
    {
        if($parametr != "")
        {
            return " AND ";
        }
        else{
            return " ";
        }
    }

    public function getCaleZaytanie(): string
    {
        $SqlWyswietl = $this->getWyswietl();
        $Sql = $SqlWyswietl . $this->getSortowanie();
        return $Sql;

    }
}

abstract class ZapytaniaSql
{

    public static function getWszytkieKolumnyPilkarz(): array
    {

        $kolumny = array();
        $kolumny = [
            "id", "imie", "nazwisko", "wzrost",
            "data_urodzenia", "wiodaca_noga",
            "wartosc_rynkowa", "ilosc_strzelonych_goli",
            "fk_kraj", "fk_numernakoszulce", "fk_pozycja",
            'pk_kraj',"pk_numernakoszulce", "pk_pozycja"
    
        ];

        return $kolumny;
    }

    public static function select_Wyswietl(): string
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
        order by pk_pilkarz DESC
        SQL;
    }

    public static function select_Szukaj($SZUKAJ): string
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
        WHERE
            imie LIKE "%$SZUKAJ%" OR
            imie LIKE "$SZUKAJ%"  OR
            imie LIKE "%$SZUKAJ"
        OR
            nazwisko LIKE "%$SZUKAJ%" OR
            nazwisko LIKE "$SZUKAJ%" OR
            nazwisko LIKE "%$SZUKAJ"
        SQL;
    }

    public static function liczbaZawodnikow(): string
    {
        return <<<SQL
        SELECT count(*) as 'liczba_pilkarzy'
        FROM pilkarz
        SQL;
    }

    public static function select_ZawodnikById($id): string
    {
        return <<<SQL
        SELECT imie, nazwisko
        FROM pilkarz
        WHERE pk_pilkarz = $id
        SQL;
    }



    public static function select_Edytuj(string $id): string
    {
        return <<<SQL
        SELECT PK_pilkarz as 'id', imie, nazwisko, wzrost, data_urodzenia, wiodaca_noga, wartosc_rynkowa, ilosc_strzelonych_goli, krajpilkarza.nazwa as 'fk_kraj', numernakoszulce.numer as 'fk_numernakoszulce', pozycja.nazwa as 'fk_pozycja',
        krajpilkarza.pk_kraj as 'pk_kraj',
        numernakoszulce.pk_numernakoszulce as 'pk_numernakoszulce',
        pozycja.pk_pozycja as 'pk_pozycja'
        FROM pilkarz
        join krajpilkarza on FK_kraj=PK_kraj
        join numernakoszulce on FK_numernakoszulce=PK_numernakoszulce
        join pozycja on FK_pozycja=PK_pozycja
        where `pk_pilkarz` = $id
        SQL;
    }

    public static function update_Zapisz(int $id,array $setPOST): string
    {
        return <<<SQL
        UPDATE pilkarz SET
        imie = "{$setPOST["imie"]}",
        nazwisko = "{$setPOST["nazwisko"]}",
        wzrost = {$setPOST["wzrost"]},
        data_urodzenia = "{$setPOST['data_urodzenia']}",
        wiodaca_noga = "{$setPOST["wiodaca_noga"]}",
        wartosc_rynkowa = {$setPOST["wartosc_rynkowa"]},
        ilosc_strzelonych_goli = {$setPOST["ilosc_strzelonych_goli"]},
        fk_kraj = {$setPOST["fk_kraj"]},
        fk_numernakoszulce = {$setPOST["fk_numernakoszulce"]},
        fk_pozycja = {$setPOST["fk_pozycja"]}
        WHERE PK_pilkarz = $id
        SQL;

    }

    public static function insert_Dodaj(array $setPOST)
    {
        return <<<SQL
        INSERT INTO pilkarz
        (
            pk_pilkarz,
            imie,nazwisko,
            wzrost,data_urodzenia,
            wiodaca_noga,
            wartosc_rynkowa,
            ilosc_strzelonych_goli,
            fk_kraj,
            fk_numernakoszulce,
            fk_pozycja
        )
        VALUES
        (
            NULL,
            "{$setPOST["imie"]}",
            "{$setPOST["nazwisko"]}",
            {$setPOST["wzrost"]},
            "{$setPOST['data_urodzenia']}",
            "{$setPOST['wiodaca_noga']}",
            {$setPOST["wartosc_rynkowa"]},
            {$setPOST["ilosc_strzelonych_goli"]},
            {$setPOST["fk_kraj"]},
            {$setPOST["fk_numernakoszulce"]},
            {$setPOST["fk_pozycja"]}
        )
        SQL;

    }

    public static function select_Kraj()
    {
        return <<<SQL
        SELECT pk_kraj, nazwa
        FROM `krajpilkarza`
        SQL;
    }

    public static function select_Numernakoszulce()
    {
        return <<<SQL
        SELECT pk_numernakoszulce, numer
        FROM numernakoszulce
        SQL;
    }

    public static function select_Pozycja()
    {
        return <<<SQL
        SELECT pk_pozycja, nazwa
        FROM pozycja
        SQL;
    }

    public static function select_ostaniZawodnik()
    {
        return <<<SQL
        SELECT pk_pilkarz FROM `pilkarz` 
        ORDER BY `pilkarz`.`pk_pilkarz` 
        DESC limit 1
        SQL;
    }


    public static function select_Awatar()
    {
        return <<<SQL
        SELECT link, fk_pilkarz
        FROM awatar
        SQL;
    }

    public static function insert_Awatar($link, $liczba)
    {
        return <<<SQL
        INSERT INTO `awatar` (`pk_awatar`, `link`, `fk_pilkarz`) 
        VALUES (NULL, '$link', '$liczba')
        ;
        SQL;
    }


    public static function update_Awatar($link, $pk_pilkarz)
    {
        return <<<SQL
        UPDATE awatar
        SET link = "$link"
        WHERE awatar.fk_pilkarz = $pk_pilkarz;
        SQL;
    }


    public static function delete_Awatar($pk_pilkarz)
    {
        return <<<SQL
        DELETE FROM `awatar` 
        WHERE `awatar`.`fk_pilkarz` = $pk_pilkarz
        ;
        SQL;
    }



    public static function delete_pilkarz($pk_pilkarz)
    {
        return <<<SQL
        DELETE FROM pilkarz WHERE 
        PK_pilkarz = $pk_pilkarz
        ;
        SQL;
    }



    
}
