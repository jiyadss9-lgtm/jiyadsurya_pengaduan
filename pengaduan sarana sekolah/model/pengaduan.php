<?php

require_once __DIR__ . '/../config/koneksi.php';

class Pengaduan
{
    private $db;

    public function __construct()
    {
        $koneksi = new Koneksi();
        $this->db = $koneksi->koneksi;
    }


    /* =========================
       USER
    ========================= */

    public function getUser($userId)
    {
        $sql = "
            SELECT
                p.*,
                k.nama_kategori,
                l.nama_ruangan,
                l.gedung_blok
            FROM pengaduan p
            LEFT JOIN kategori k
                ON p.kategori_id = k.kategori_id
            LEFT JOIN lokasi l
                ON p.lokasi_id = l.lokasi_id
            WHERE p.user_id = ?
            ORDER BY p.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();

        return $stmt->get_result();
    }


    public function getByIdUser($id, $userId)
    {
        $stmt = $this->db->prepare(
            "SELECT *
             FROM pengaduan
             WHERE pengaduan_id = ?
             AND user_id = ?
             LIMIT 1"
        );

        $stmt->bind_param(
            "ii",
            $id,
            $userId
        );

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }


    public function tambah($data)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO pengaduan
            (
                user_id,
                lokasi_id,
                kategori_id,
                judul_pengaduan,
                deskripsi,
                foto_bukti,
                urgensi
            )
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            "iiissss",
            $data['user_id'],
            $data['lokasi_id'],
            $data['kategori_id'],
            $data['judul_pengaduan'],
            $data['deskripsi'],
            $data['foto_bukti'],
            $data['urgensi']
        );

        return $stmt->execute();
    }


    public function edit($data)
    {
        if (!empty($data['foto_bukti'])) {

            $stmt = $this->db->prepare(
                "UPDATE pengaduan
                 SET
                    lokasi_id = ?,
                    kategori_id = ?,
                    judul_pengaduan = ?,
                    deskripsi = ?,
                    foto_bukti = ?,
                    urgensi = ?
                 WHERE pengaduan_id = ?
                 AND user_id = ?
                 AND status IN ('baru','pending')"
            );

            $stmt->bind_param(
                "iissssii",
                $data['lokasi_id'],
                $data['kategori_id'],
                $data['judul_pengaduan'],
                $data['deskripsi'],
                $data['foto_bukti'],
                $data['urgensi'],
                $data['pengaduan_id'],
                $data['user_id']
            );

        } else {

            $stmt = $this->db->prepare(
                "UPDATE pengaduan
                 SET
                    lokasi_id = ?,
                    kategori_id = ?,
                    judul_pengaduan = ?,
                    deskripsi = ?,
                    urgensi = ?
                 WHERE pengaduan_id = ?
                 AND user_id = ?
                 AND status IN ('baru','pending')"
            );

            $stmt->bind_param(
                "iisssii",
                $data['lokasi_id'],
                $data['kategori_id'],
                $data['judul_pengaduan'],
                $data['deskripsi'],
                $data['urgensi'],
                $data['pengaduan_id'],
                $data['user_id']
            );
        }

        return $stmt->execute();
    }


    public function hapusUser($id, $userId)
    {
        $data = $this->getByIdUser(
            $id,
            $userId
        );

        if (!$data) {
            return false;
        }

        if (
            !in_array(
                $data['status'],
                ['baru', 'pending'],
                true
            )
        ) {
            return false;
        }

        return $this->hapus($id);
    }


    /* =========================
       ADMIN
    ========================= */

    public function getAll()
    {
        $sql = "
            SELECT
                p.*,
                u.nama_lengkap,
                k.nama_kategori,
                l.nama_ruangan,
                l.gedung_blok
            FROM pengaduan p
            LEFT JOIN users u
                ON p.user_id = u.user_id
            LEFT JOIN kategori k
                ON p.kategori_id = k.kategori_id
            LEFT JOIN lokasi l
                ON p.lokasi_id = l.lokasi_id
            ORDER BY p.created_at DESC
        ";

        return $this->db->query($sql);
    }


    public function updateStatus($id, $status)
    {
        $allowed = [
            'baru',
            'pending',
            'diproses',
            'selesai',
            'ditolak'
        ];

        if (!in_array($status, $allowed, true)) {
            return false;
        }

        $stmt = $this->db->prepare(
            "UPDATE pengaduan
             SET status = ?
             WHERE pengaduan_id = ?"
        );

        $stmt->bind_param(
            "si",
            $status,
            $id
        );

        return $stmt->execute();
    }


    public function hapus($id)
    {
        $this->db->begin_transaction();

        try {

            $stmt = $this->db->prepare(
                "DELETE FROM feedback
                 WHERE pengaduan_id = ?"
            );

            if ($stmt) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
            }


            $stmt = $this->db->prepare(
                "DELETE FROM penanganan
                 WHERE pengaduan_id = ?"
            );

            if ($stmt) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
            }


            $stmt = $this->db->prepare(
                "DELETE FROM pengaduan
                 WHERE pengaduan_id = ?"
            );

            $stmt->bind_param("i", $id);
            $stmt->execute();


            $this->db->commit();

            return true;

        } catch (Throwable $e) {

            $this->db->rollback();

            return false;
        }
    }


    /* =========================
       DASHBOARD
    ========================= */

    public function getStats()
    {
        $data = [
            'total' => 0,
            'selesai' => 0,
            'diproses' => 0,
            'menunggu' => 0
        ];

        $result = $this->db->query(
            "SELECT
                COUNT(*) AS total,
                SUM(status = 'selesai') AS selesai,
                SUM(status = 'diproses') AS diproses,
                SUM(
                    status IN ('baru','pending')
                ) AS menunggu
             FROM pengaduan"
        );

        if ($result) {
            $row = $result->fetch_assoc();

            $data['total'] =
                (int)$row['total'];

            $data['selesai'] =
                (int)$row['selesai'];

            $data['diproses'] =
                (int)$row['diproses'];

            $data['menunggu'] =
                (int)$row['menunggu'];
        }

        return $data;
    }


    public function getCategoryStats()
    {
        return $this->db->query(
            "SELECT
                k.nama_kategori,
                COUNT(p.pengaduan_id) AS jumlah
             FROM kategori k
             LEFT JOIN pengaduan p
                ON p.kategori_id = k.kategori_id
             GROUP BY
                k.kategori_id,
                k.nama_kategori
             ORDER BY jumlah DESC"
        );
    }


    public function getKategori()
    {
        return $this->db->query(
            "SELECT *
             FROM kategori
             ORDER BY nama_kategori ASC"
        );
    }


    public function getLokasi()
    {
        return $this->db->query(
            "SELECT *
             FROM lokasi
             ORDER BY nama_ruangan ASC"
        );
    }
}