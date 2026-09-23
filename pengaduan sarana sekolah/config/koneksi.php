<?php

class Koneksi
{
    //properti
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "pengaduan_sarana_sekolah";
    //private tidak bisa di akses oleh siapapun kecuali class itu sendiri

    public $koneksi;
    //publik bisa di akses oleh siapapun

    public function __construct()
    {
        //parameter
        $this->koneksi = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if ($this->koneksi->connect_error) {
            die("Koneksi database gagal: " . $this->koneksi->connect_error);
        }

        $this->koneksi->set_charset("utf8mb4");
    }
}