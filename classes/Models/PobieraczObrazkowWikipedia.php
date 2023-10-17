<?php


namespace Pilkanozna\Views;

class PobieraczObrazowWikipedia 
{
    private $szukaneHaslo;
    private $daneJson;

    public function __construct($imie, $nazwisko) {
        $this->szukaneHaslo = urlencode("{$imie}_{$nazwisko}");
    }

    public function pobierzDaneObrazu() {
        $daneWikipedia = file_get_contents("https://pl.wikipedia.org/w/api.php?action=query&prop=pageimages&format=json&piprop=original&titles=" . $this->szukaneHaslo);
        $this->daneJson = json_decode($daneWikipedia, true);
    }

    public function pobierzZrodloPierwszejStrony() {
        if (isset($this->daneJson['query']['pages'])) {
            $dane = $this->daneJson;
            $pierwszyKluczStrony = key($dane['query']['pages']);
            if (isset($dane['query']['pages'][$pierwszyKluczStrony]['original']['source'])) {
                return $dane['query']['pages'][$pierwszyKluczStrony]['original']['source'];
            }
        }
        return "https://as2.ftcdn.net/v2/jpg/02/00/60/53/1000_F_200605342_J2OWrDUM57tnrGwPpbwMe4mqPvhIERjO.jpg";
    }

    public function wyswietlObraz() {
        $zrodloObrazu = $this->pobierzZrodloPierwszejStrony();
        return "<img data-src='$zrodloObrazu' width='50px'  class='lazyload' />";
    }
}

// Przykład użycia:

// $imie = "Robert";
// $nazwisko = "Lewandowski";

// // $imie = "Kylian";
// // $nazwisko = "Mbappé";

// $pobieraczObrazow = new PobieraczObrazowWikipedia($imie, $nazwisko);
// $pobieraczObrazow->pobierzDaneObrazu();
// $pobieraczObrazow->wyswietlObraz();

?>
