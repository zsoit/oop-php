<?php
/* 
Klasa łączy z API wikipedii i pobiera obrazy znanych osob z wikipedii na podstawie imienia i nazwiska
Zrodlo: https://www.mediawiki.org/wiki/API:Main_page/pl
*/

namespace Pilkanozna\Models;


class PobieraczObrazowWikipedia 
{
    const API_URL = "https://pl.wikipedia.org/w/api.php?action=query&prop=pageimages&format=json&piprop=original&titles=";
    const ANON_AVATAR = "public/user.png";


    private $szukaneHaslo;
    private $daneJson;
    
    
    public function __construct($imie, $nazwisko) {
        $this->szukaneHaslo = urlencode("{$imie}_{$nazwisko}");
    }
    
    public function pobierzDaneObrazu() {
        $daneWikipedia = file_get_contents(self::API_URL . $this->szukaneHaslo);
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
        return self::ANON_AVATAR;
    }

    public function wyswietlObraz() {
        $zrodloObrazu = $this->pobierzZrodloPierwszejStrony();
        return  <<<HTML
        
        <img 
            data-src='$zrodloObrazu' 
            width='50px'  
            class='lazyload' 
        />
        
        HTML;
    }
}