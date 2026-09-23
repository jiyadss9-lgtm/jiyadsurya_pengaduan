<?php

session_start();

require_once __DIR__ . '/../model/pengaduan.php';


// =========================
// CEK LOGIN
// =========================

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}


$model = new Pengaduan();

$action = $_POST['action'] ?? '';

$userId = $_SESSION['user_id'];


// =========================
// REDIRECT
// =========================

function kembali($pesan)
{
    header(
        "Location: ../view/user/dashboard.php?msg=" .
        urlencode($pesan)
    );

    exit;
}


// =========================
// UPLOAD FOTO
// =========================

function uploadFoto()
{
    if (
        !isset($_FILES['foto_bukti']) ||
        $_FILES['foto_bukti']['error'] ===
        UPLOAD_ERR_NO_FILE
    ) {
        return null;
    }


    if (
        $_FILES['foto_bukti']['error'] !==
        UPLOAD_ERR_OK
    ) {
        return false;
    }


    // Maksimal 5 MB
    if (
        $_FILES['foto_bukti']['size'] >
        5 * 1024 * 1024
    ) {
        return false;
    }


    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp'
    ];


    $finfo = finfo_open(
        FILEINFO_MIME_TYPE
    );

    $mime = finfo_file(
        $finfo,
        $_FILES['foto_bukti']['tmp_name']
    );

    finfo_close($finfo);


    if (!isset($allowed[$mime])) {
        return false;
    }


    $folder =
        __DIR__ .
        '/../uploads/bukti/';


    if (!is_dir($folder)) {
        mkdir(
            $folder,
            0777,
            true
        );
    }


    $nama =
        time() .
        '_' .
        bin2hex(
            random_bytes(5)
        ) .
        '.' .
        $allowed[$mime];


    if (
        !move_uploaded_file(
            $_FILES['foto_bukti']['tmp_name'],
            $folder . $nama
        )
    ) {
        return false;
    }


    return $nama;
}


// =========================
// CREATE
// =========================

if ($action === 'tambah') {

    $kategoriId =
        (int)($_POST['kategori_id'] ?? 0);

    $lokasiId =
        (int)($_POST['lokasi_id'] ?? 0);

    $judul =
        trim(
            $_POST['judul_pengaduan'] ?? ''
        );

    $deskripsi =
        trim(
            $_POST['deskripsi'] ?? ''
        );

    $urgensi =
        $_POST['urgensi'] ?? 'sedang';


    if (
        $kategoriId <= 0 ||
        $lokasiId <= 0 ||
        $judul === '' ||
        $deskripsi === ''
    ) {
        kembali('invalid');
    }


    if (
        !in_array(
            $urgensi,
            ['rendah', 'sedang', 'tinggi'],
            true
        )
    ) {
        kembali('invalid');
    }


    $foto = uploadFoto();


    if ($foto === false) {
        kembali('foto_error');
    }


    $ok = $model->create(
        $userId,
        $kategoriId,
        $lokasiId,
        $judul,
        $deskripsi,
        $urgensi,
        $foto ?? ''
    );


    kembali(
        $ok
        ? 'created'
        : 'failed'
    );
}


// =========================
// UPDATE
// =========================

if ($action === 'edit') {

    $id =
        (int)($_POST['pengaduan_id'] ?? 0);

    $kategoriId =
        (int)($_POST['kategori_id'] ?? 0);

    $lokasiId =
        (int)($_POST['lokasi_id'] ?? 0);

    $judul =
        trim(
            $_POST['judul_pengaduan'] ?? ''
        );

    $deskripsi =
        trim(
            $_POST['deskripsi'] ?? ''
        );

    $urgensi =
        $_POST['urgensi'] ?? 'sedang';


    if (
        $id <= 0 ||
        $kategoriId <= 0 ||
        $lokasiId <= 0 ||
        $judul === '' ||
        $deskripsi === ''
    ) {
        kembali('invalid');
    }


    $foto = uploadFoto();


    if ($foto === false) {
        kembali('foto_error');
    }


    $ok = $model->update(
        $id,
        $userId,
        $kategoriId,
        $lokasiId,
        $judul,
        $deskripsi,
        $urgensi,
        $foto
    );


    kembali(
        $ok
        ? 'updated'
        : 'failed'
    );
}


// =========================
// DELETE
// =========================

if ($action === 'hapus') {

    $id =
        (int)($_POST['pengaduan_id'] ?? 0);


    if ($id <= 0) {
        kembali('invalid');
    }


    $ok =
        $model->deleteByUser(
            $id,
            $userId
        );


    kembali(
        $ok
        ? 'deleted'
        : 'cannot_delete'
    );
}


// Kalau action tidak dikenal
kembali('invalid');