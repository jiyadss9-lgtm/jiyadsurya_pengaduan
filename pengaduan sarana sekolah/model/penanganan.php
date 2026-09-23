<?php

require_once __DIR__ . '/../config/koneksi.php';

class Penanganan
{
    private $db;

    public function __construct()
    {
        $koneksi = new Koneksi();
        $this->db = $koneksi->koneksi;
    }

    public function simpan($data)
    {
        $cek = $this->db->prepare(
            "SELECT penanganan_id, foto_selesai
             FROM penanganan
             WHERE pengaduan_id = ?"
        );
        $cek->bind_param("i", $data['pengaduan_id']);
        $cek->execute();

        $hasil = $cek->get_result();

        if ($hasil->num_rows > 0) {
            $existing = $hasil->fetch_assoc();
            
            // Pertahankan foto lama jika foto baru tidak diunggah
            $foto = !empty($data['foto_selesai']) ? $data['foto_selesai'] : $existing['foto_selesai'];

            $stmt = $this->db->prepare(
                "UPDATE penanganan SET
                    admin_id = ?,
                    tanggal_mulai = ?,
                    tanggal_selesai = ?,
                    catatan_perbaikan = ?,
                    foto_selesai = ?,
                    biaya = ?
                 WHERE pengaduan_id = ?"
            );

            $stmt->bind_param(
                "issssdi",
                $data['admin_id'],
                $data['tanggal_mulai'],
                $data['tanggal_selesai'],
                $data['catatan_perbaikan'],
                $foto,
                $data['biaya'],
                $data['pengaduan_id']
            );
        } else {
            $stmt = $this->db->prepare(
                "INSERT INTO penanganan
                (pengaduan_id, admin_id, tanggal_mulai, tanggal_selesai, catatan_perbaikan, foto_selesai, biaya)
                VALUES (?, ?, ?, ?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "iissssd",
                $data['pengaduan_id'],
                $data['admin_id'],
                $data['tanggal_mulai'],
                $data['tanggal_selesai'],
                $data['catatan_perbaikan'],
                $data['foto_selesai'],
                $data['biaya']
            );
        }

        return $stmt->execute();
    }
}