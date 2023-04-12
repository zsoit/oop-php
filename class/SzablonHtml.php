<?php

namespace Pilkanozna;


class SzablonHtml
{



    public static function Zawodnik(array $wiersz): void
    {
        $id = $wiersz['id'];
        echo <<<HTML
        <div class='card'>
            <ul>
                <h2>{$wiersz['nazwisko']}</h2>
                <h3>{$wiersz['imie']} </h3>
            <div class='fakeBtn_wrapper'>
                <a class="fakeBtn" href="?co=usun&id=$id" name='delete'>
                    <i class="fa-solid fa-trash"></i>
                    <span>Usuń</span>
                </a>
                <a class="fakeBtn" href="?co=edytuj&id=$id" name='edit'>
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edytuj</span>
                </a>
            </div>
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

    public static function Naglowek(string $napis): void
    {
        echo <<<HTML
            <div class="alert alert__header" >$napis</div>
        HTML;
    }

    public static function Formularz(
        array $wiersz, string $adres, $kraje, $numernakoszulce, $pozycja, $napisprzycisk
    ): void
    {


        $id = $wiersz['id'];
        echo <<<HTML
            <form action="index.php$adres" method="POST">
            <table>
            <tr style="display: none;">
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
                <td><label for="kraj">Wybierz kraj:</label></td>
                <td>$kraje</td>
            </tr>
            <tr>
                <td><label for="numrnakoszulce">Numer na koszulce</label></td>
                <td>$numernakoszulce</td>
            </tr>
            <tr>
                <td><label for="pozycja">Pozycja</label></td>
                <td>$pozycja</td>
            </tr>
            <tr>
                <td><br>
                <button class="fakeBtn">
                    <i class="fa-regular fa-floppy-disk"></i>
                    <span>$napisprzycisk</span>
                </button>
                </td>
            </tr>
            </table>
            </form>
            HTML;
    }
}
