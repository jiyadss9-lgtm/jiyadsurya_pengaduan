<?php

require_once __DIR__ . '/../config/koneksi.php';

class Admin
{
    private $db;

    public function __construct()
    {
        $koneksi = new Koneksi();
        $this->db = $koneksi->koneksi;
    }

    public function login($email)
    {
        $stmt = $this->db->prepare(
            "SELECT *
             FROM admin
             WHERE email = ?
             LIMIT 1"
        );

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
}