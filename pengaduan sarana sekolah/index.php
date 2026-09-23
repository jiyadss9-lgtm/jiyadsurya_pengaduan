<?php

session_start();

if (isset($_SESSION['admin_id'])) {
    header("Location: view/admin/dashboard.php");
    exit;
}

if (isset($_SESSION['user_id'])) {
    header("Location: view/user/dashboard.php");
    exit;
}

$error = $_GET['error'] ?? '';
$success = $_GET['register'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pengaduan Sarana Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-950 flex items-center justify-center p-6">

<div class="w-full max-w-md">

    <div class="bg-gray-900 border border-purple-800 rounded-2xl p-8 shadow-2xl">

        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-purple-700 rounded-2xl mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold">
                PS
            </div>
            <h1 class="text-2xl font-bold text-white">
                Pengaduan Sarana Sekolah
            </h1>
            <p class="text-gray-400 mt-2">
                Silakan masuk ke akun Anda
            </p>
        </div>

        <?php if ($error === 'login'): ?>
            <div class="bg-red-900 text-red-200 p-3 rounded-lg mb-4 text-center">
                Email atau password salah.
            </div>
        <?php elseif ($error === 'empty'): ?>
            <div class="bg-red-900 text-red-200 p-3 rounded-lg mb-4 text-center">
                Mohon isi email dan password.
            </div>
        <?php endif; ?>

        <?php if ($success === 'success'): ?>
            <div class="bg-green-900 text-green-200 p-3 rounded-lg mb-4 text-center">
                Registrasi berhasil. Silakan login.
            </div>
        <?php endif; ?>

        <form action="controller/AuthController.php" method="POST">
            <input type="hidden" name="action" value="login">

            <div class="mb-5">
                <label class="text-gray-300 block mb-2">Email</label>
                <input type="email" name="email" required
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-purple-500 outline-none"
                       placeholder="Masukkan email">
            </div>

            <div class="mb-6">
                <label class="text-gray-300 block mb-2">Password</label>
                <input type="password" name="password" required
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-purple-500 outline-none"
                       placeholder="Masukkan password">
            </div>

            <button type="submit" class="w-full bg-purple-700 hover:bg-purple-600 text-white py-3 rounded-lg font-semibold transition">
                Login
            </button>
        </form>

        <div class="text-center mt-6 text-gray-400">
            Belum punya akun?
            <a href="view/auth/register.php" class="text-purple-400 hover:text-purple-300">
                Daftar sekarang
            </a>
        </div>

    </div>

</div>

</body>
</html>