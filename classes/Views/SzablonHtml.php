<?php

namespace Pilkanozna\Views;

use Pilkanozna\Models\PobieraczObrazowWikipedia;

interface ISzablonHtml
{
    public static function Zawodnik(array $wiersz): void;
    public static function Naglowek(string $napis): void;
    public static function PotwierdzUsuniecie($id,$imie,$nazwisko): void;
    public static function Formularz(array $wiersz, string $adres, $kraje, $numernakoszulce, $pozycja, $napisprzycisk): void;
    public static function FormularzLogowania(): void;
    public static function FormularzFilrowaniaJs(): void;
    public static function FormularzFiltrowania($kraje,$numernakoszulce,$pozycja): void;

}

abstract class SzablonHtml implements ISzablonHtml
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


    public static function Formularz(array $wiersz, string $adres, $kraje, $numernakoszulce, $pozycja, $napisprzycisk): void
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
                Zaloguj <i class="fa-solid fa-right-to-bracket"></i>
            </button>
        </form>

        <script>
            document.querySelector(".menu").style.display = "none";
        </script>
        HTML;
    }


    public static function FormularzFilrowaniaJs(): void
    {
        echo <<<HTML
                 <script>
            function setupCheckboxAndSelect(checkboxId, selectId) {
                // Pobierz checkbox i pole wyboru na podstawie przekazanych identyfikatorów
                var checkbox = document.getElementById(checkboxId);
                var select = document.getElementById(selectId);

                // Ustaw początkowy stan (domyślnie wyłączone)
                select.disabled = true;

                // Nasłuchuj zdarzenia zmiany stanu checkboxa
                checkbox.addEventListener("change", function () {
                    if (checkbox.checked) {
                        select.disabled = false;
                        checkbox.value="1";
                    }
                    else {
                        select.disabled = true;
                        checkbox.value="0";
                    }
                });
            }

                function pobierzParametrGet(parametr) {
                    const queryString = window.location.search.substr(1);

                    const paryParametrow = queryString.split('&');

                    for (const paraParametru of paryParametrow) {
                    const [nazwa, wartosc] = paraParametru.split('=');
                    if (nazwa === parametr) {
                    return decodeURIComponent(wartosc);
                }
                }

                    return null;
                }



                function setFormularzPole(getparametr,formularzid){

                   
                    var wartosc = pobierzParametrGet(getparametr);;
                    var pole = document.querySelector(formularzid);

                    pole.value = wartosc;

                }

                function clickBox(id,id2){
                    var box = document.getElementById(id);
                    var wartosc = document.getElementById(id2);

                    if(wartosc.value == "") console.log("puste"); 
                    else box.click();
                }

                function WynikiWyszukiwania()
                {
                    var imie = pobierzParametrGet("imie");
                    var nazwisko = pobierzParametrGet("nazwisko");


                    var pole = document.querySelector("#szukanypilkarz");
                    var wartosc = imie + " " + nazwisko;
                    if(imie==null && nazwisko==null) wartosc=" "; 
                   

                    pole.innerHTML = wartosc;


                }

            window.addEventListener("load", function () {
                setupCheckboxAndSelect("noga_check", "noga");
                setupCheckboxAndSelect("kraj_check", "fk_kraj");
                setupCheckboxAndSelect("numernakoszulce_check", "fk_numernakoszulce");
                setupCheckboxAndSelect("pozycja_check", "fk_pozycja");

                setFormularzPole("sortuj","#sortuj");
                setFormularzPole("imie","#imie");
                setFormularzPole("nazwisko","#nazwisko");

                setFormularzPole("wiodaca_noga","#noga");
                clickBox("noga_check","noga");

                setFormularzPole("fk_kraj","#fk_kraj");
                clickBox("kraj_check","fk_kraj");

                setFormularzPole("fk_pozycja","#fk_pozycja");
                clickBox("pozycja_check","fk_pozycja");

                setFormularzPole("fk_numernakoszulce","#fk_numernakoszulce");
                clickBox("numernakoszulce_check","fk_numernakoszulce");

                WynikiWyszukiwania()



            });
            </script>

        HTML;

    }

    public static function FormularzFiltrowania($kraje,$numernakoszulce,$pozycja): void
    {
        echo <<<HTML

        <form action="/szukaj" method="GET">
            <table>

            <tr>
                <td>
                    <label>Imie</label>
                </td>
                <td>
                    <input type="text" name="imie" id="imie">
                </td>
            </tr>

            <tr>
                <td>
                    <label>Nazwisko</label>
                </td>
                <td>
                    <input type="text" name="nazwisko" id="nazwisko">
                </td>
            </tr>

            <tr>
                <td><label>Sortuj</label></td>
                <td>
                    <select name="sortuj" id="sortuj">
                        <option value="najnowsze">Najnowsze wpisy</option>
                        <option value="najstarsze">Najstarsze wpisy</option>

                        <option value="a-z">Alfabetycznie A-Z (Nazwisko)</option>
                        <option value="z-a">Alfabetycznie Z-A (Nazwisko)</option>

                        <option value="wzrost-asc">Rosnąco: Wzrost</option>
                        <option value="wzrost-desc">Malejąco: Wzrost</option>

                        <option value="dataurodzania-asc">Rosnąco: Data urodzenia</option>
                        <option value="dataurodzania-desc">Malejąco: Data urodzenia</option>

                        <option value="wartosc-asc">Malejąco: Wartośc rynkowa</option>
                        <option value="wartosc-desc">Malejąco: Wartośc rynkowa</option>

                    </select>
                </td>
            </tr>


            <tr>
                <td>
                    <input type="checkbox" id="noga_check" value="1">
                    <label>Wiodąca noga</label>
                </td>
                <td>
                    <select name="wiodaca_noga" id="noga" disabled>
                        <option value="LEWA">LEWA</option>
                        <option value="PRAWA">PRAWA</option>
                        <option value="OBU-NOŻNY">OBU-NOŻNY</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" id="kraj_check" value="1">
                    <label for="kraj">Wybierz kraj:</label>
                </td>
                <td>$kraje</td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" id="numernakoszulce_check" value="1">
                    <label for="numrnakoszulce">Numer na koszulce</label>
                </td>
                <td>$numernakoszulce</td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" id="pozycja_check" value="1">
                    <label for="pozycja">Pozycja</label>
                </td>
                <td>$pozycja</td>
            </tr>
            <tr>
                <td><br>
                <button class="fakeBtn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>Szukaj</span>
                </button>
                </td>
            </tr>
            </table>
            </form>
        HTML;
    }



}
