<?php

require_once __DIR__ . '/../config/koneksi.php';

class User
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
             FROM users
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

    public function register($data)
    {
        $password = password_hash(
            $data['password'],
            PASSWORD_DEFAULT
        );

        $stmt = $this->db->prepare(
            "INSERT INTO users
            (
                nama_lengkap,
                nomor_induk,
                role,
                email,
                no_whatsapp,
                password
            )
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            "ssssss",
            $data['nama_lengkap'],
            $data['nomor_induk'],
            $data['role'],
            $data['email'],
            $data['no_whatsapp'],
            $password
        );

        return $stmt->execute();
    }

    public function emailExists($email)
    {
        $stmt = $this->db->prepare(
            "SELECT user_id
             FROM users
             WHERE email = ?
             LIMIT 1"
        );

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    public function nomorExists($nomor)
    {
        $stmt = $this->db->prepare(
            "SELECT user_id
             FROM users
             WHERE nomor_induk = ?
             LIMIT 1"
        );

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $nomor);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }
}