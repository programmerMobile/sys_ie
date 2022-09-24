<?php

class Db {

    private function __construct() {  }

    public static function conectar() 
    {
        $mysqli = new mysqli("localhost", "root", "", "escuela");
        if($mysqli->connect_errno)
        {
            print "Error en la conexion: " . $mysqli->connect_errno;
            die();
        }
        return $mysqli;
    }
}