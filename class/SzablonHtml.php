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
            <li> wzrost: <span>{$wiersz['wzrost']}</span></li>
            <li> data urodzenia: <span>{$wiersz['data_urodzenia']}</span></li>
            <li> wiodąca noga: <span>{$wiersz['wiodaca_noga']}</span></li>
            <li> wartość rynkowa: <span>{$wiersz['wartosc_rynkowa']}</span></li>
            <li> ilość strzelonych goli: <span>{$wiersz['ilosc_strzelonych_goli']}</span></li>
            <li> kraj: <span>{$wiersz['pilkarzkraj']}</span></li>
            <li> numer na koszulce: <span>{$wiersz['numer']}</span></li>
            <li> pozycja: <span>{$wiersz['pozycja']}</span></li>
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
                <td><input type="text" value="{$wiersz['imie']}" name="imie" required></td>
            </tr>
            <tr>
                <td><label>Nazwisko</label></td>
                <td><input type="text" value="{$wiersz['nazwisko']}" name="nazwisko" required></td>
            </tr>
            <tr>
                <td><label>Wzrost</label></td>
                <td><input type="number" value="{$wiersz['wzrost']}" name="wzrost" step="0.01" min="0"  placeholder="np. 1.77"  required></td>
            </tr>
            <tr>
                <td><label>Data urodzenia</label></td>
                <td><input type="text" value="{$wiersz['data_urodzenia']}" name="data_urodzenia" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" placeholder="YYYY-MM-DD" required></td>
            </tr>
            <tr>
                <td><label>Wiodąca noga</label></td>
                <td>
                    <select name="wiodaca_noga">
                        <option value="LEWA">LEWA</option>
                        <option value="PRAWA">PRAWA</option>
                        <option value="OBU-NOŻNY">OBU-NOŻNY</option>
                    </select>
                </td>
                <!-- ZAZNACZA NUMER NA KOSZULCE PILKARZA Z BAZY-->
                <script>document.querySelector("select[name='wiodaca_noga'] option[value='{$wiersz['wiodaca_noga']}']").selected = true;</script>
            </tr>
            <tr>
                <td><label>Wartość rynkowa</label></td>
                <td><input type="number" value="{$wiersz['wartosc_rynkowa']}" name="wartosc_rynkowa" required></td>
            </tr>
            <tr>
                <td><label>Ilość strzelonych goli</label></td>
                <td><input type="number" value="{$wiersz['ilosc_strzelonych_goli']}" name="ilosc_strzelonych_goli" required></td>
            </tr>
            <tr>
                <td><label for="kraj">Wybierz kraj:</label></td>

                <td>$kraje</td>
                <!-- ZAZNACZA NUMER NA KOSZULCE PILKARZA Z BAZY-->
                <script>document.querySelector("select[name='fk_kraj'] option[value='{$wiersz['pk_kraj']}']").selected = true;</script>
            </tr>
            <tr>
                <td><label for="numrnakoszulce">Numer na koszulce</label></td>
                <td>$numernakoszulce</td>
                <!-- ZAZNACZA NUMER NA KOSZULCE PILKARZA Z BAZY-->
                <script> document.querySelector("select[name='fk_numernakoszulce'] option[value='{$wiersz['pk_numernakoszulce']}']").selected = true;</script>
            </tr>
            <tr>
                <td><label for="pozycja">Pozycja</label></td>
                <td>$pozycja</td>
                <!-- ZAZNACZA POZYCJE PILKARZA Z BAZY-->
                <script>document.querySelector("select[name='fk_pozycja'] option[value='{$wiersz['pk_pozycja']}']").selected = true;</script>
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
