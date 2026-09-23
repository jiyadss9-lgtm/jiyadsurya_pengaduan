<?php

session_start();

/*
|--------------------------------------------------------------------------
| CEK LOGIN
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| TENTUKAN USER
|--------------------------------------------------------------------------
*/

$isAdmin = isset($_SESSION['admin_id']);

if ($isAdmin) {

    $nama = $_SESSION['admin_nama'] ?? 'Admin Sekolah';
    $email = $_SESSION['admin_email'] ?? '-';
    $role = 'Administrator';

} else {

    $nama = $_SESSION['user_nama'] ?? 'User';
    $email = $_SESSION['user_email'] ?? '-';
    $role = $_SESSION['user_role'] ?? 'Siswa';

}


/*
|--------------------------------------------------------------------------
| SIMPAN PROFIL
|--------------------------------------------------------------------------
*/

$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $namaBaru = trim($_POST['nama'] ?? '');
    $emailBaru = trim($_POST['email'] ?? '');

    if ($namaBaru !== '') {

        if ($isAdmin) {
            $_SESSION['admin_nama'] = $namaBaru;
        } else {
            $_SESSION['user_nama'] = $namaBaru;
        }

        $nama = $namaBaru;
    }


    if ($emailBaru !== '') {

        if ($isAdmin) {
            $_SESSION['admin_email'] = $emailBaru;
        } else {
            $_SESSION['user_email'] = $emailBaru;
        }

        $email = $emailBaru;
    }


    $success = "Profil berhasil diperbarui.";
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Profil</title>

    <link rel="stylesheet"
          href="../asset/css/style.css">

</head>


<body class="profile-page">

<div class="profile-wrapper">


    <!-- HEADER -->

    <div class="profile-topbar">

        <a
            href="<?= $isAdmin
                ? '../view/admin/dashboard.php'
                : '../view/user/dashboard.php'
            ?>"
            class="profile-back"
        >
            ← Kembali
        </a>


        <div>

            <h1>Profil Saya</h1>

            <p>
                Informasi akun pengguna
            </p>

        </div>

    </div>



    <!-- CARD -->

    <div class="profile-container">


        <!-- AVATAR -->

        <div class="profile-avatar">

            <?= strtoupper(
                substr($nama, 0, 1)
            ); ?>

        </div>


        <h2 class="profile-name">

            <?= htmlspecialchars($nama); ?>

        </h2>


        <p class="profile-role">

            <?= htmlspecialchars($role); ?>

        </p>


        <?php if ($success): ?>

            <div class="profile-success">

                ✓ <?= htmlspecialchars($success); ?>

            </div>

        <?php endif; ?>


        <!-- INFORMASI -->

        <div class="profile-info">


            <div class="profile-info-item">

                <div>

                    <small>
                        Nama Lengkap
                    </small>

                    <strong>
                        <?= htmlspecialchars($nama); ?>
                    </strong>

                </div>

                <span>👤</span>

            </div>


            <div class="profile-info-item">

                <div>

                    <small>
                        Email
                    </small>

                    <strong>
                        <?= htmlspecialchars($email); ?>
                    </strong>

                </div>

                <span>✉️</span>

            </div>


            <div class="profile-info-item">

                <div>

                    <small>
                        Hak Akses
                    </small>

                    <strong>
                        <?= htmlspecialchars($role); ?>
                    </strong>

                </div>

                <span>🛡️</span>

            </div>


        </div>



        <!-- EDIT -->

        <div class="profile-edit">

            <h3>
                ✏️ Edit Profil
            </h3>


            <form method="POST">


                <label>
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    name="nama"
                    value="<?= htmlspecialchars($nama); ?>"
                    required
                >


                <label>
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="<?= htmlspecialchars($email); ?>"
                    required
                >


                <button type="submit">
                    💾 Simpan Perubahan
                </button>


            </form>

        </div>


    </div>

</div>


<script src="../asset/js/script.js"></script>

</body>
</html>