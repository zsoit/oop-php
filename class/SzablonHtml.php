<?php
class SzablonHtml
{

    public static function Card($wiersz) {
        $id = $wiersz['id'];
        echo <<<HTML
        <div class='card'>
            <ul>
            <p>
                <a href="?co=usun&id=$id" name='delete'>Usuń</a>
                <a href="?co=edytuj&id=$id" name='edit'>Edytuj</a>
            </p>
            <li> imię: {$wiersz['imie']}</li>
            <li> nazwisko: {$wiersz['nazwisko']}</li>
            <li> wzrost: {$wiersz['wzrost']}</li>
            <li> data urodzenia: {$wiersz['data_urodzenia']}</li>
            <li> wiodąca noga: {$wiersz['wiodaca_noga']}</li>
            <li> wartość rynkowa: {$wiersz['wartosc_rynkowa']}</li>
            <li> ilość strzelonych goli: {$wiersz['ilosc_strzelonych_goli']}</li>
            <li> kraj: {$wiersz['pilkarzkraj']}</li>
            <li> numer na koszulce: {$wiersz['numer']}</li>
            <li> pozycja: {$wiersz['pozycja']}</li>
            </ul>
            </div>
        </div>
        HTML;
    }

    public static function Alert($napis)
    {
        echo <<<HTML
            <div class="alert" >$napis</div>
        HTML;
    }

    public static function Formularz($wiersz) {
        $id = $wiersz['id'];
        echo <<<HTML
            <form action="index.php?co=zapisz&id=$id" method="POST">
            <table>
            <tr>
                <td><label>ID</label></td>
                <td><input type="text" value="$id" name="id"></td>
            </tr>
            <tr>
                <td><label>Imie</label></td>
                <td><input type="text" value="{$wiersz['imie']}" name="imie"></td>
            </tr>
            <tr>
                <td><label>Nazwisko</label></td>
                <td><input type="text" value="{$wiersz['nazwisko']}" name="nazwisko"></td>
            </tr>
            <tr>
                <td><label>Wzrost</label></td>
                <td><input type="text" value="{$wiersz['wzrost']}" name="wzrost"></td>
            </tr>
            <tr>
                <td><label>Data urodzenia</label></td>
                <td><input type="text" value="{$wiersz['data_urodzenia']}" name="data_urodzenia"></td>
            </tr>
            <tr>
                <td><label>Wiodąca noga</label></td>
                <td><input type="text" value="{$wiersz['wiodaca_noga']}" name="wiodaca_noga"></td>
            </tr>
            <tr>
                <td><label>Wartość rynkowa</label></td>
                <td><input type="text" value="{$wiersz['wartosc_rynkowa']}" name="wartosc_rynkowa"></td>
            </tr>
            <tr>
                <td><label>Ilość strzelonych goli</label></td>
                <td><input type="text" value="{$wiersz['ilosc_strzelonych_goli']}" name="ilosc_strzelonych_goli"></td>
            </tr>
            <tr>
                <td><label>Kraj pilkarza</label></td>
                <td><input type="text" value="{$wiersz['pilkarzkraj']}" name="fk_kraj"></td>
            </tr>
            <tr>
                <td><label>Numer na koszulce</label></td>
                <td><input type="text" value="{$wiersz['numer']}" name="fk_numernakoszulce"></td>
            </tr>
            <tr>
                <td><label>Pozycja</label></td>
                <td><input type="text" value="{$wiersz['pozycja']}" name="fk_pozycja"></td>
            </tr>
            <tr>
                <td> <br> <input type="submit" value="Zapisz"></td>
            </tr>
            </table>
            </form>
            HTML;
    }
}