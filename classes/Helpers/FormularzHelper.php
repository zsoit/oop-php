<?php
namespace Pilkanozna\Helper;


use Pilkanozna\Models\ZapytaniaSql;
use Pilkanozna\Views\SzablonHtml;


class FormularzHelpers
{
    private function SelectHTML(array $dane, $id, $nazwa, $fk): string
    {
        $html = "<select name='$fk'>";
        foreach ($dane as $wiersz) {
            $html .= "<option value='{$wiersz[$id]}'>{$wiersz[$nazwa]}</option>";
        }
        $html .= "</select>";

        return $html;
    }

    public function Pilkarz($dane, $adres, $napisprzycisk, $pobierzDane): void
    {
        $sqlkraj = ZapytaniaSql::select_Kraj();
        $kraje = $pobierzDane($sqlkraj, 'pk_kraj', 'nazwa');

        $sqlnumer = ZapytaniaSql::select_Numernakoszulce();
        $numery = $pobierzDane($sqlnumer, 'pk_numernakoszulce', 'numer');

        $sqlpozycja = ZapytaniaSql::select_Pozycja();
        $pozycje = $pobierzDane($sqlpozycja, 'pk_pozycja', 'nazwa');

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
}
