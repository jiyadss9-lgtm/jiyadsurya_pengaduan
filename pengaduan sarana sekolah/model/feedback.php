<?php

require_once __DIR__ . '/../config/koneksi.php';

class Feedback
{
    private $db;

    public function __construct()
    {
        $koneksi = new Koneksi();
        $this->db = $koneksi->koneksi;
    }

    public function simpan($pengaduan_id, $rating, $komentar)
    {
        $cek = $this->db->prepare(
            "SELECT feedback_id FROM feedback WHERE pengaduan_id = ?"
        );
        $cek->bind_param("i", $pengaduan_id);
        $cek->execute();

        if ($cek->get_result()->num_rows > 0) {
            $stmt = $this->db->prepare(
                "UPDATE feedback SET rating = ?, komentar = ? WHERE pengaduan_id = ?"
            );
            $stmt->bind_param("isi", $rating, $komentar, $pengaduan_id);
        } else {
            $stmt = $this->db->prepare(
                "INSERT INTO feedback (pengaduan_id, rating, komentar) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("iis", $pengaduan_id, $rating, $komentar);
        }

        return $stmt->execute();
    }
}