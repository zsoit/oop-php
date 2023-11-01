<?php
namespace Pilkanozna\Models;

class PobieraczObrazowWikipedia 
{
    const API_URL = "https://pl.wikipedia.org/w/api.php?action=query&prop=pageimages&format=json&piprop=original&titles=";
    const ANON_AVATAR = "public/user.png";


    private string $szukaneHaslo;
    private string | array $daneJson;
    
    
    public function __construct($imie, $nazwisko) {
        $this->szukaneHaslo = urlencode("{$imie}_{$nazwisko}");
    }
    
    public function pobierzDaneObrazu(): void {
        $daneWikipedia = file_get_contents(self::API_URL . $this->szukaneHaslo);
        $this->daneJson = json_decode($daneWikipedia, true);
    }

    public function pobierzZrodlo(): mixed {
        if (isset($this->daneJson['query']['pages'])) {
            $dane = $this->daneJson;
            $pierwszyKluczStrony = key($dane['query']['pages']);
            if (isset($dane['query']['pages'][$pierwszyKluczStrony]['original']['source'])) {
                return $dane['query']['pages'][$pierwszyKluczStrony]['original']['source'];
            }
        }
        return self::ANON_AVATAR;
    }

    public function updateObrazka(): mixed{
        $this->pobierzDaneObrazu();
        return $this->pobierzZrodlo();
    }

    public function wyswietlObraz(): string {
        $zrodloObrazu = $this->pobierzZrodlo();
        return  <<<HTML
        
        <img 
            data-src='$zrodloObrazu' 
            class='lazyload' 
            width="150px"
            style="border-radius: 20px;"
        />
        
        HTML;
    }
}