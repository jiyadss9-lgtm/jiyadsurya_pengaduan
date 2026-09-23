<?php

require_once __DIR__ . '/../config/koneksi.php';

class Kategori
{
    private $db;

    public function __construct()
    {
        $koneksi = new Koneksi();
        $this->db = $koneksi->koneksi;
    }

    public function getAll()
    {
        return $this->db->query(
            "SELECT *
             FROM kategori
             ORDER BY nama_kategori ASC"
        );
    }
}