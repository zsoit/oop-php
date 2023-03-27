<?php
class SzablonHtml
{

    public static function Card(
        $imie,
        $nazwisko,
        $wzrost,
        $data_urodzenia,
        $wiodaca_noga,
        $wartosc_rynkowa,
        $ilosc_strzelonych_goli,
        $pilkarzkraj,
        $numer,
        $pozycja,
        $id
    ) {
        echo <<<HTML
        <div class='card'>
            <ul>
            <p>
                <a href="?co=usun&id=$id" name='delete'>Usuń</a>
                <a href="?co=edytuj&id=$id" name='edit'>Edytuj</a>
            </p>
            <li> imię: $imie</li>
            <li> nazwisko: $nazwisko</li>
            <li> wzrost: $wzrost</li>
            <li> data urodzenia: $data_urodzenia</li>
            <li> wiodąca noga: $wiodaca_noga</li>
            <li> wartość rynkowa: $wartosc_rynkowa</li>
            <li> ilość strzelonych goli: $ilosc_strzelonych_goli</li>
            <li> kraj: $pilkarzkraj</li>
            <li> numer na koszulce: $numer</li>
            <li> pozycja: $pozycja</li>
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

    public static function Formularz(
        $imie,
        $nazwisko,
        $wzrost,
        $data_urodzenia,
        $wiodaca_noga,
        $wartosc_rynkowa,
        $ilosc_strzelonych_goli,
        $pilkarzkraj,
        $numer,
        $pozycja,
        $id
    ) {
        echo <<<HTML
            <form action="index.php?co=zapisz&id=$id" method="POST">
            <table>
            <tr>
                <td><label>ID</label></td>
                <td><input type="text" value="$id" name="id"></td>
            </tr>
            <tr>
                <td><label>Imie</label></td>
                <td><input type="text" value="$imie" name="imie"></td>
            </tr>
            <tr>
                <td><label>Nazwisko</label></td>
                <td><input type="text" value="$nazwisko" name="nazwisko"></td>
            </tr>
            <tr>
                <td><label>Wzrost</label></td>
                <td><input type="text" value="$wzrost" name="wzrost"></td>
            </tr>
            <tr>
                <td><label>Data urodzenia</label></td>
                <td><input type="text" value="$data_urodzenia" name="data_urodzenia"></td>
            </tr>
            <tr>
                <td><label>Wiodąca noga</label></td>
                <td><input type="text" value="$wiodaca_noga" name="wiodaca_noga"></td>
            </tr>
            <tr>
                <td><label>Wartość rynkowa</label></td>
                <td><input type="text" value="$wartosc_rynkowa" name="wartosc_rynkowa"></td>
            </tr>
            <tr>
                <td><label>Ilość strzelonych goli</label></td>
                <td><input type="text" value="$ilosc_strzelonych_goli" name="ilosc_strzelonych_goli"></td>
            </tr>
            <tr>
                <td><label>Kraj pilkarza</label></td>
                <td><input type="text" value="$pilkarzkraj" name="fk_kraj"></td>
            </tr>
            <tr>
                <td><label>Numer na koszulce</label></td>
                <td><input type="text" value="$numer" name="fk_numernakoszulce"></td>
            </tr>
            <tr>
                <td><label>Pozycja</label></td>
                <td><input type="text" value="$pozycja" name="fk_pozycja"></td>
            </tr>
            <tr>
                <td> <br> <input type="submit" value="Zapisz"></td>

                <!-- <td> <br> <a class="fakeBtn" href='index.php?co=zapisz&id=$id' name='update'>Zapisz</a></td> -->
            </tr>
            </table>
            </form>
            HTML;
    }
}
