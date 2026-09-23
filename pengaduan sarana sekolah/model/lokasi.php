<?php

require_once __DIR__ . '/../config/koneksi.php';

class Lokasi
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
             FROM lokasi
             ORDER BY nama_ruangan ASC"
        );
    }
}