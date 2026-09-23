<?php

session_start();

require_once __DIR__ . '/../model/pengaduan.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit;
}

$model = new Pengaduan();

$action =
    $_POST['action'] ?? '';


/* =========================
   UBAH STATUS
========================= */

if ($action === 'status') {

    $id =
        (int)(
            $_POST['pengaduan_id']
            ?? 0
        );

    $status =
        $_POST['status'] ?? '';


    $ok =
        $model->updateStatus(
            $id,
            $status
        );


    header(
        "Location: ../view/admin/dashboard.php?msg=" .
        ($ok ? 'updated' : 'failed')
    );

    exit;
}


/* =========================
   HAPUS
========================= */

if ($action === 'hapus') {

    $id =
        (int)(
            $_POST['pengaduan_id']
            ?? 0
        );


    $ok =
        $model->hapus($id);


    header(
        "Location: ../view/admin/dashboard.php?msg=" .
        ($ok ? 'deleted' : 'failed')
    );

    exit;
}


header(
    "Location: ../view/admin/dashboard.php"
);

exit;