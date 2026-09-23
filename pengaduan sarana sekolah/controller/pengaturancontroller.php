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
| SIMPAN TEMA
|--------------------------------------------------------------------------
*/

if (isset($_GET['theme'])) {

    if ($_GET['theme'] === 'dark') {

        $_SESSION['theme'] = 'dark';

    }

    if ($_GET['theme'] === 'light') {

        $_SESSION['theme'] = 'light';

    }

}


/*
|--------------------------------------------------------------------------
| TEMA DEFAULT
|--------------------------------------------------------------------------
*/

$theme = $_SESSION['theme'] ?? 'dark';


/*
|--------------------------------------------------------------------------
| NOTIFIKASI
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['notification'])) {

    $_SESSION['notification'] = true;

}


if (isset($_GET['notification'])) {

    if ($_GET['notification'] === 'on') {

        $_SESSION['notification'] = true;

    }

    if ($_GET['notification'] === 'off') {

        $_SESSION['notification'] = false;

    }

}


$isAdmin = isset($_SESSION['admin_id']);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Pengaturan
    </title>

    <link
        rel="stylesheet"
        href="../asset/css/style.css"
    >

</head>


<body class="settings-page <?= $theme; ?>">


<div class="settings-wrapper">


    <!-- HEADER -->

    <div class="settings-topbar">


        <a
            href="<?= $isAdmin
                ? '../view/admin/dashboard.php'
                : '../view/user/dashboard.php'
            ?>"
            class="settings-back"
        >

            ← Kembali

        </a>


        <div>

            <h1>
                Pengaturan
            </h1>

            <p>
                Atur tampilan aplikasi
            </p>

        </div>


    </div>



    <!-- CARD -->

    <div class="settings-container">


        <div class="settings-title">

            <div class="settings-icon">
                ⚙️
            </div>

            <div>

                <h2>
                    Pengaturan
                </h2>

                <p>
                    Sesuaikan aplikasi
                    sesuai kebutuhan kamu.
                </p>

            </div>

        </div>



        <!-- =================================
             TAMPILAN
        ================================== -->

        <div class="settings-section">


            <div class="settings-section-title">

                <div>
                    🎨
                </div>

                <span>

                    <strong>
                        Tampilan
                    </strong>

                    <small>
                        Pilih mode tampilan
                    </small>

                </span>

            </div>



            <div class="theme-options">


                <!-- GELAP -->

                <a
                    href="?theme=dark"
                    class="theme-option
                    <?= $theme === 'dark'
                        ? 'selected'
                        : ''
                    ?>"
                >

                    <div class="theme-option-icon">
                        🌙
                    </div>

                    <div>

                        <strong>
                            Mode Gelap
                        </strong>

                        <small>
                            Nyaman untuk digunakan
                            pada malam hari
                        </small>

                    </div>


                    <?php if ($theme === 'dark'): ?>

                        <span class="theme-check">
                            ✓
                        </span>

                    <?php endif; ?>

                </a>



                <!-- TERANG -->

                <a
                    href="?theme=light"
                    class="theme-option
                    <?= $theme === 'light'
                        ? 'selected'
                        : ''
                    ?>"
                >

                    <div class="theme-option-icon">
                        ☀️
                    </div>

                    <div>

                        <strong>
                            Mode Terang
                        </strong>

                        <small>
                            Tampilan cerah dan bersih
                        </small>

                    </div>


                    <?php if ($theme === 'light'): ?>

                        <span class="theme-check">
                            ✓
                        </span>

                    <?php endif; ?>

                </a>


            </div>

        </div>



        <!-- =================================
             NOTIFIKASI
        ================================== -->

        <div class="settings-section">


            <div class="settings-section-title">

                <div>
                    🔔
                </div>

                <span>

                    <strong>
                        Notifikasi
                    </strong>

                    <small>
                        Atur pemberitahuan
                    </small>

                </span>

            </div>



            <div class="notification-row">


                <div>

                    <strong>
                        Notifikasi Pengaduan
                    </strong>

                    <small>
                        Pemberitahuan status pengaduan
                    </small>

                </div>


                <?php if ($_SESSION['notification']): ?>

                    <a
                        href="?notification=off"
                        class="switch active"
                    >

                        <span></span>

                    </a>

                <?php else: ?>

                    <a
                        href="?notification=on"
                        class="switch"
                    >

                        <span></span>

                    </a>

                <?php endif; ?>


            </div>

        </div>



        <!-- =================================
             KEAMANAN
        ================================== -->

        <div class="settings-section">


            <div class="settings-section-title">

                <div>
                    🔐
                </div>

                <span>

                    <strong>
                        Keamanan
                    </strong>

                    <small>
                        Pengaturan keamanan akun
                    </small>

                </span>

            </div>


            <button
                type="button"
                class="password-button"
                onclick="alert('Fitur ubah password dapat ditambahkan nanti.')"
            >

                🔑 Ubah Password

            </button>


        </div>



        <!-- =================================
             INFORMASI
        ================================== -->

        <div class="settings-section">


            <div class="settings-section-title">

                <div>
                    ℹ️
                </div>

                <span>

                    <strong>
                        Informasi Sistem
                    </strong>

                    <small>
                        Pengaduan Sarana Sekolah
                    </small>

                </span>

            </div>


            <div class="system-version">

                <span>
                    Versi Sistem
                </span>

                <strong>
                    1.0.0
                </strong>

            </div>


        </div>


    </div>

</div>


<script src="../asset/js/script.js"></script>

</body>

</html>