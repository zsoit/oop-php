<?php

namespace Pilkanozna\Views;

use Pilkanozna\Models\PobieraczObrazowWikipedia;

abstract class SzablonHtml
{

    public static function Zawodnik(array $wiersz): void
    {

        $id = $wiersz['id'];
        $awatar = $wiersz['link'];

        echo <<<HTML
        <div class='card'>
            <ul>
                <div class='card__avatar'>
                   <img src="$awatar" />
                </div>
                <h2>{$wiersz['nazwisko']}</h2>
                <h3>{$wiersz['imie']} </h3>
            <div class='fakeBtn_wrapper'>
                <a class="fakeBtn" href="/usun?id=$id" name='delete'>
                    <i class="fa-solid fa-trash"></i>
                    <span>Usuń</span>
                </a>
                <a class="fakeBtn" href="/edytuj?id=$id" name='edit'>
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edytuj</span>
                </a>
            </div>
            <li> wzrost: <span>{$wiersz['wzrost']} m</span></li>
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

    public static function PotwierdzUsuniecie($id,$imie,$nazwisko): void
    {
        echo <<<HTML
            <div class="alert" >
                <p>Czy na pewno jesteś pewien że chcesz usunąc zawodnika <b>$imie $nazwisko</b>?</p>
                <a href="/usun?id=$id&potwierdzenie=tak">
                    <button class="fakeBtn">
                        <i class="fa-solid fa-check"></i>
                        Tak
                    </button>
                </a>
                <a href="/">
                    <button class="fakeBtn">
                        <i class="fa-solid fa-xmark"></i>
                        Anuluj
                    </button>
                </a>
            </div>
        HTML;
    }


    public static function Formularz(
        array $wiersz, string $adres, $kraje, $numernakoszulce, $pozycja, $napisprzycisk
    ): void
    {


        $imie = $wiersz['imie'];
        $nazwisko = $wiersz['nazwisko'];

        $pobieraczObrazow = new PobieraczObrazowWikipedia($imie, $nazwisko);
        $pobieraczObrazow->pobierzDaneObrazu();
       

        $awatar =  $pobieraczObrazow->wyswietlObraz();


        $id = $wiersz['id'];
        echo <<<HTML
            <form action="$adres" method="POST">
            <table>

            <tr>
                <td  colspan="2">

                    <center style="margin: 20px">
                        $awatar
                    </center>

                </td>
            </tr>
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
                <td><input type="date" value="{$wiersz['data_urodzenia']}" name="data_urodzenia" placeholder="YYYY-MM-DD" required></td>
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
                <script>document.querySelector("select[name='wiodaca_noga'] option[value='{$wiersz['wiodaca_noga']}']").selected = true;</script>
            </tr>
            <tr>
                <td><label>Wartość rynkowa</label></td>
                <td><input type="number" value="{$wiersz['wartosc_rynkowa']}" name="wartosc_rynkowa" min="0" placeholder="np. 22" required></td>
            </tr>
            <tr>
                <td><label>Ilość strzelonych goli</label></td>
                <td><input type="number" value="{$wiersz['ilosc_strzelonych_goli']}" min="0" name="ilosc_strzelonych_goli"  placeholder="np. 5"  required></td>
            </tr>
            <tr>
                <td><label for="kraj">Wybierz kraj:</label></td>

                <td>$kraje</td>
                <script>document.querySelector("select[name='fk_kraj'] option[value='{$wiersz['pk_kraj']}']").selected = true;</script>
            </tr>
            <tr>
                <td><label for="numrnakoszulce">Numer na koszulce</label></td>
                <td>$numernakoszulce</td>
                <script> document.querySelector("select[name='fk_numernakoszulce'] option[value='{$wiersz['pk_numernakoszulce']}']").selected = true;</script>
            </tr>
            <tr>
                <td><label for="pozycja">Pozycja</label></td>
                <td>$pozycja</td>
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

    public static function FormularzLogowania(): void
    {
        echo <<<HTML

        <form method="post" action="/zaloguj" class="form">
            <div class="form__group">
                <label for="uzytkownik" class="form__label">Użytkownik</label>
                <input type="text" class="form__control" id="uzytkownik" name="uzytkownik" required>
            </div>
            <div class="form__group">
                <label for="haslo" class="form__label">Hasło</label>
                <input type="password" class="form__control" id="haslo" name="haslo" required>
            </div>
            <p class="form__note"><i>Treść widoczna tylko dla zalogowanych użytkowników!</i></p>
            <button type="submit" class="form__button">
                Zaloguj <i class="form__icon"></i>
            </button>
        </form>

        <script>
            document.querySelector(".menu").style.display = "none";
        </script>
        HTML;
    }


    public static function Filtry()
    {
        echo <<<HTML
        <div class="filter">
            <div class="filter__item">
                <label for="kraj">Kraj: </label>
                <select name="kraj" id="kraj">
                    <option value="">Polska</option>
                    <option value="">Polska</option>

                </select>
            </div>

            <div class="filter__item">
                <label for="kraj">Pozycja: </label>
                <select name="kraj" id="kraj">
                    <option value="">Napastnik</option>
                    <option value="">Polska</option>

                </select>
            </div>


            <div class="filter__item">
                <label for="kraj">Wiodąca noga: </label>
                <select name="kraj" id="kraj">
                    <option value="">Lewa</option>
                    <option value="">Polska</option>

                </select>
            </div>


            <div class="filter__item">
                <label for="kraj">Sortowanie alfabetyczne: </label>
                <select name="kraj" id="kraj">
                    <option value="">Rosnąco</option>
                    <option value="">Malejąco</option>

                </select>
            </div>
        </div>


        HTML;
    }
}
