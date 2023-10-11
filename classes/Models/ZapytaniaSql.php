<?php
namespace Pilkanozna;
class ZapytaniaSql
{

    public static function select_Wyswietl(): string
    {
        return <<<SQL
        SELECT PK_pilkarz as 'id', imie, nazwisko, wzrost, data_urodzenia, wiodaca_noga, wartosc_rynkowa,
        ilosc_strzelonych_goli,
        krajpilkarza.nazwa as 'pilkarzkraj', numernakoszulce.numer, pozycja.nazwa as 'pozycja'
        FROM pilkarz
        join krajpilkarza on FK_kraj=PK_kraj
        join numernakoszulce on FK_numernakoszulce=PK_numernakoszulce
        join pozycja on FK_pozycja=PK_pozycja
        order by pk_pilkarz DESC
        SQL;
    }

    public static function select_Szukaj($SZUKAJ): string
    {
        return <<<SQL
        SELECT PK_pilkarz as 'id', imie, nazwisko, wzrost, data_urodzenia, wiodaca_noga, wartosc_rynkowa,
        ilosc_strzelonych_goli,
        krajpilkarza.nazwa as 'pilkarzkraj', numernakoszulce.numer, pozycja.nazwa as 'pozycja'
        FROM pilkarz
        join krajpilkarza on FK_kraj=PK_kraj
        join numernakoszulce on FK_numernakoszulce=PK_numernakoszulce
        join pozycja on FK_pozycja=PK_pozycja
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
}