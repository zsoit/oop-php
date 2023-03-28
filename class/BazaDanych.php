<?php

class BazaDanych
{
    protected $polaczenie;
    protected function DBPolaczenie(){

        include_once 'KonfiguracjaDB.php';
        $this->polaczenie = mysqli_connect($servername, $username, $password, $database);
    }

    protected function DBRozlaczenie()
    {
        mysqli_close($this->polaczenie);
    }

}