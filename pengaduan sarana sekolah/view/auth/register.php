<?php
$error = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Pengaduan Sarana Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-950 min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-2xl">
    <div class="bg-gray-900 border border-purple-800 rounded-2xl p-8 shadow-2xl">

        <h1 class="text-3xl font-bold text-white mb-2">Buat Akun</h1>
        <p class="text-gray-400 mb-7">Daftar sebagai pengguna sistem pengaduan.</p>

        <?php if ($error): ?>
            <div class="bg-red-900 text-red-200 p-3 rounded-lg mb-5 text-center">
                <?php
                $pesan = [
                    'empty'    => 'Semua data wajib diisi.',
                    'role'     => 'Role tidak valid.',
                    'password' => 'Konfirmasi password tidak sama.',
                    'email'    => 'Email sudah digunakan.',
                    'nomor'    => 'Nomor induk sudah digunakan.',
                    'failed'   => 'Registrasi gagal.'
                ];
                echo $pesan[$error] ?? 'Terjadi kesalahan.';
                ?>
            </div>
        <?php endif; ?>

        <form action="../../controller/AuthController.php" method="POST">
            <input type="hidden" name="action" value="register">

            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="text-gray-300 block mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white">
                </div>

                <div>
                    <label class="text-gray-300 block mb-2">Nomor Induk (NIS/NIP)</label>
                    <input type="text" name="nomor_induk" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white">
                </div>

                <div>
                    <label class="text-gray-300 block mb-2">Role</label>
                    <select name="role" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white">
                        <option value="">Pilih Role</option>
                        <option value="siswa">Siswa</option>
                        <option value="guru">Guru</option>
                    </select>
                </div>

                <div>
                    <label class="text-gray-300 block mb-2">Email</label>
                    <input type="email" name="email" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white">
                </div>

                <div>
                    <label class="text-gray-300 block mb-2">No. WhatsApp</label>
                    <input type="text" name="no_whatsapp"
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white">
                </div>

                <div>
                    <label class="text-gray-300 block mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white">
                </div>

                <div class="md:col-span-2">
                    <label class="text-gray-300 block mb-2">Konfirmasi Password</label>
                    <input type="password" name="konfirmasi_password" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white">
                </div>
            </div>

            <button type="submit" class="w-full mt-7 bg-purple-700 hover:bg-purple-600 text-white py-3 rounded-lg font-semibold transition">
                Daftar
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="../../index.php" class="text-purple-400 hover:text-purple-300">
                ← Kembali ke Login
            </a>
        </div>

    </div>
</div>

</body>
</html>