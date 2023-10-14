<?php

class Fl 
{

    public static function Views($name) {
        require_once "./classes/Views/$name.php";
    }


    public static function Models($name) {
        require_once "./classes/Models/$name.php";
    }


    public static function Controllers($name) {
        require_once "./classes/Controllers/$name.php";
    }
}