<?php
namespace Pilkanozna\Helper;


use Pilkanozna\Models\ZapytaniaSql;
use Pilkanozna\Views\SzablonHtml;


class FormularzHelper
{
    private $kraje;
    private $numery;
    private $pozycje;


    public function __construct() {
        $this->kraje = ZapytaniaSql::select_Kraj();
        $this->numery = ZapytaniaSql::select_Numernakoszulce();
        $this->pozycje = ZapytaniaSql::select_Pozycja(); 
    }


    private function SelectHTML(array $dane, $id, $nazwa, $fk): string
    {
        $html = "<select name='$fk' id='$fk' >";
        foreach ($dane as $wiersz) {
            $html .= "<option value='{$wiersz[$id]}'>{$wiersz[$nazwa]}</option>";
        }
        $html .= "</select>";

        return $html;
    }

    public function Pilkarz($dane, $adres, $napisprzycisk, $pobierzDane): void
    {
        $kraje = $pobierzDane($this->kraje, 'pk_kraj', 'nazwa');
        $numery = $pobierzDane($this->numery, 'pk_numernakoszulce', 'numer');
        $pozycje = $pobierzDane($this->pozycje, 'pk_pozycja', 'nazwa');

        $select_kraje_html = $this->SelectHTML($kraje, 'pk_kraj', 'nazwa', 'fk_kraj');
        $select_numernakoszulce_html = $this->SelectHTML($numery, 'pk_numernakoszulce', 'numer', 'fk_numernakoszulce');
        $select_pozycja_html = $this->SelectHTML($pozycje, 'pk_pozycja', 'nazwa', 'fk_pozycja');

        SzablonHtml::Formularz(
            $dane,
            $adres,
            $select_kraje_html,
            $select_numernakoszulce_html,
            $select_pozycja_html,
            $napisprzycisk
        );
    }


    public function Filtrowanie($pobierzDane): void
    {
        $kraje = $pobierzDane($this->kraje, 'pk_kraj', 'nazwa');
        $numery = $pobierzDane($this->numery, 'pk_numernakoszulce', 'numer');
        $pozycje = $pobierzDane($this->pozycje, 'pk_pozycja', 'nazwa');

        $select_kraje_html = $this->SelectHTML($kraje, 'pk_kraj', 'nazwa', 'fk_kraj');
        $select_numernakoszulce_html = $this->SelectHTML($numery, 'pk_numernakoszulce', 'numer', 'fk_numernakoszulce');
        $select_pozycja_html = $this->SelectHTML($pozycje, 'pk_pozycja', 'nazwa', 'fk_pozycja');

        SzablonHtml::FormularzFiltrowania(
            $select_kraje_html,
            $select_numernakoszulce_html,
            $select_pozycja_html,
        );

        SzablonHtml::FormularzFilrowaniaJs();

    }


    public function FormularzZapisu($wiersz, $id, $pobierzDane)
    {
        $this->Pilkarz($wiersz, "/zapisz?id=$id", "Zapisz",$pobierzDane);
    }

    public function FormularzDodawania($wiersz,$pobierzDane)
    {
        $this->Pilkarz($wiersz, "/dodaj", "Dodaj",$pobierzDane);

    }
}
