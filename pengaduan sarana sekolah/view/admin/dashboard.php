<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header(
        "Location: ../../index.php"
    );
    exit;
}

require_once __DIR__ .
    '/../../model/pengaduan.php';

$model = new Pengaduan();

$stats =
    $model->getStats();

$pengaduan =
    $model->getAll();

$kategori =
    $model->getCategoryStats();

$msg =
    $_GET['msg'] ?? '';

?>
<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Dashboard Admin</title>

<script src="https://cdn.tailwindcss.com"></script>

<link
    rel="stylesheet"
    href="../../asset/css/style.css"
>

</head>


<body
class="bg-[#202020] text-white min-h-screen"
>


<!-- SIDEBAR -->

<aside
class="fixed
       left-0
       top-0
       bottom-0
       w-52
       bg-[#191919]
       border-r
       border-white/5
       p-5"
>

    <div
    class="text-center
           mb-8"
    >

        <div
        class="w-12
               h-12
               mx-auto
               rounded-full
               bg-gradient-to-br
               from-purple-400
               to-purple-800
               flex
               items-center
               justify-center
               text-xl"
        >
            👤
        </div>

        <h2
        class="font-bold
               mt-2"
        >
            ADMIN SEKOLAH
        </h2>

        <p
        class="text-xs
               text-gray-500"
        >
            ADMINISTRATOR
        </p>

    </div>


    <a
    href="#"
    class="block
           bg-purple-700
           rounded-lg
           px-4
           py-3
           mb-3
           font-semibold"
    >
        🏠 Dashboard
    </a>


    <p
    class="text-xs
           text-gray-500
           mt-7
           mb-3"
    >
        MENU
    </p>


    <a
    href="#pengaduan"
    class="block
           px-4
           py-3
           rounded-lg
           hover:bg-white/5"
    >
        📋 Pengaduan
    </a>


   <a
    href="../../controller/profilcontroller.php"
    class="block
           px-4
           py-3
           rounded-lg
           hover:bg-white/5"
>
    👤 Profil
</a>

 <a
    href="../../controller/pengaturancontroller.php"
    class="block
           px-4
           py-3
           rounded-lg
           hover:bg-white/5"
>
    ⚙️ Pengaturan
</a>


    <a
    href="../../logout.php"
    class="block
           px-4
           py-3
           mt-8
           text-red-400
           rounded-lg
           hover:bg-red-500/10"
    >
        ↪ Logout
    </a>

</aside>



<!-- MAIN -->

<main
class="ml-52
       p-7"
>


<!-- HEADER -->

<div
class="flex
       justify-between
       items-center
       mb-8"
>

    <div>

        <p
        class="text-purple-400
               text-sm
               font-semibold"
        >
            SISTEM PENGADUAN
        </p>

        <h1
        class="text-3xl
               font-bold"
        >
            Dashboard Admin
        </h1>

    </div>


    <div
    class="text-right"
    >

        <p
        class="font-bold"
        >
            <?= htmlspecialchars(
                $_SESSION['admin_nama']
                ?? 'Admin Sekolah'
            ) ?>
        </p>

        <p
        class="text-xs
               text-gray-500"
        >
            Administrator
        </p>

    </div>

</div>


<?php if ($msg): ?>

<div
class="bg-purple-900/40
       border
       border-purple-500/30
       p-4
       rounded-xl
       mb-5"
>

    <?php

    if ($msg === 'updated') {
        echo "Status pengaduan berhasil diperbarui.";
    } elseif ($msg === 'deleted') {
        echo "Pengaduan berhasil dihapus.";
    } else {
        echo "Terjadi kesalahan.";
    }

    ?>

</div>

<?php endif; ?>



<!-- STATISTIK -->

<div
class="grid
       grid-cols-1
       md:grid-cols-2
       xl:grid-cols-4
       gap-3
       mb-5"
>


    <!-- TOTAL -->

    <div
    class="bg-[#30302b]
           rounded-xl
           p-5
           flex
           items-center
           gap-4"
    >

        <div
        class="w-14
               h-14
               rounded-full
               bg-purple-600
               flex
               items-center
               justify-center
               text-2xl"
        >
            📋
        </div>

        <div>

            <p
            class="text-3xl"
            >
                <?= $stats['total'] ?>
            </p>

            <p
            class="text-gray-300"
            >
                total pengaduan
            </p>

        </div>

    </div>



    <!-- SELESAI -->

    <div
    class="bg-[#30302b]
           rounded-xl
           p-5
           flex
           items-center
           gap-4"
    >

        <div
        class="w-14
               h-14
               rounded-full
               bg-purple-600
               flex
               items-center
               justify-center
               text-2xl"
        >
            ✓
        </div>

        <div>

            <p
            class="text-3xl"
            >
                <?= $stats['selesai'] ?>
            </p>

            <p
            class="text-gray-300"
            >
                pengaduan selesai
            </p>

        </div>

    </div>



    <!-- DIPROSES -->

    <div
    class="bg-[#30302b]
           rounded-xl
           p-5
           flex
           items-center
           gap-4"
    >

        <div
        class="w-14
               h-14
               rounded-full
               bg-purple-600
               flex
               items-center
               justify-center
               text-2xl"
        >
            ◷
        </div>

        <div>

            <p
            class="text-3xl"
            >
                <?= $stats['diproses'] ?>
            </p>

            <p
            class="text-gray-300"
            >
                sedang diproses
            </p>

        </div>

    </div>



    <!-- MENUNGGU -->

    <div
    class="bg-[#30302b]
           rounded-xl
           p-5
           flex
           items-center
           gap-4"
    >

        <div
        class="w-14
               h-14
               rounded-full
               bg-purple-600
               flex
               items-center
               justify-center
               text-2xl"
        >
            !
        </div>

        <div>

            <p
            class="text-3xl"
            >
                <?= $stats['menunggu'] ?>
            </p>

            <p
            class="text-gray-300"
            >
                menunggu ditangani
            </p>

        </div>

    </div>

</div>



<!-- CONTENT -->

<div
class="grid
       lg:grid-cols-5
       gap-4"
>


<!-- PENGADUAN -->

<section
id="pengaduan"
class="lg:col-span-3
       bg-[#30302b]
       rounded-xl
       p-4"
>

    <div
    class="flex
           justify-between
           items-center
           mb-4"
    >

        <h2
        class="text-xl
               font-semibold"
        >
            PENGADUAN TERBARU
        </h2>

        <span
        class="text-xs
               text-gray-500"
        >
            <?= $stats['total'] ?> laporan
        </span>

    </div>


    <div
    class="space-y-3"
    >

    <?php

    $jumlah = 0;

    if ($pengaduan):

    while (
        $row =
        $pengaduan->fetch_assoc()
    ):

        if ($jumlah >= 6) {
            break;
        }

        $jumlah++;

    ?>

        <div
        class="bg-[#242421]
               rounded-xl
               p-3
               flex
               gap-3"
        >


            <?php if (
                !empty(
                    $row['foto_bukti']
                )
            ): ?>

                <img
                src="../../uploads/bukti/<?= htmlspecialchars(
                    $row['foto_bukti']
                ) ?>"
                class="w-16
                       h-16
                       rounded-lg
                       object-cover"
                >

            <?php else: ?>

                <div
                class="w-16
                       h-16
                       rounded-lg
                       bg-purple-900
                       flex
                       items-center
                       justify-center
                       text-2xl"
                >
                    📷
                </div>

            <?php endif; ?>


            <div
            class="flex-1"
            >

                <p
                class="font-bold"
                >
                    <?= htmlspecialchars(
                        $row['judul_pengaduan']
                    ) ?>
                </p>


                <p
                class="text-sm
                       text-gray-400"
                >
                    <?= htmlspecialchars(
                        $row['nama_ruangan']
                    ) ?>
                </p>


                <p
                class="text-xs
                       text-gray-500
                       mt-1"
                >
                    <?= htmlspecialchars(
                        $row['nama_lengkap']
                    ) ?>
                </p>

            </div>


            <div>

                <?php

                $status =
                    strtolower(
                        $row['status']
                    );

                $warna =
                    'bg-gray-600';

                if ($status === 'selesai') {
                    $warna =
                        'bg-green-500';
                }

                if ($status === 'diproses') {
                    $warna =
                        'bg-yellow-500
                         text-black';
                }

                if (
                    $status === 'baru' ||
                    $status === 'pending'
                ) {
                    $warna =
                        'bg-red-500';
                }

                ?>

                <span
                class="<?= $warna ?>
                       px-3
                       py-2
                       rounded-lg
                       text-xs
                       font-bold
                       inline-block
                       min-w-24
                       text-center"
                >
                    <?= htmlspecialchars(
                        $status
                    ) ?>
                </span>

            </div>

        </div>


        <!-- AKSI -->

        <div
        class="flex
               justify-end
               gap-2
               -mt-1
               mb-2"
        >

            <form
            action="../../controller/admincontroller.php"
            method="POST"
            class="flex gap-2"
            >

                <input
                type="hidden"
                name="action"
                value="status"
                >

                <input
                type="hidden"
                name="pengaduan_id"
                value="<?= $row['pengaduan_id'] ?>"
                >

                <select
                name="status"
                class="bg-[#191919]
                       border
                       border-white/10
                       rounded-lg
                       px-2
                       py-1
                       text-xs"
                >

                    <option
                    value="baru"
                    <?= $status === 'baru'
                        ? 'selected'
                        : '' ?>
                    >
                        Baru
                    </option>

                    <option
                    value="pending"
                    <?= $status === 'pending'
                        ? 'selected'
                        : '' ?>
                    >
                        Pending
                    </option>

                    <option
                    value="diproses"
                    <?= $status === 'diproses'
                        ? 'selected'
                        : '' ?>
                    >
                        Diproses
                    </option>

                    <option
                    value="selesai"
                    <?= $status === 'selesai'
                        ? 'selected'
                        : '' ?>
                    >
                        Selesai
                    </option>

                    <option
                    value="ditolak"
                    <?= $status === 'ditolak'
                        ? 'selected'
                        : '' ?>
                    >
                        Ditolak
                    </option>

                </select>


                <button
                class="bg-purple-700
                       hover:bg-purple-600
                       px-3
                       py-1
                       rounded-lg
                       text-xs"
                >
                    Simpan
                </button>

            </form>


            <form
            action="../../controller/admincontroller.php"
            method="POST"
            onsubmit="return confirm('Hapus pengaduan ini?')"
            >

                <input
                type="hidden"
                name="action"
                value="hapus"
                >

                <input
                type="hidden"
                name="pengaduan_id"
                value="<?= $row['pengaduan_id'] ?>"
                >

                <button
                class="bg-red-500/20
                       text-red-300
                       px-3
                       py-1
                       rounded-lg
                       text-xs"
                >
                    Hapus
                </button>

            </form>

        </div>

    <?php endwhile; endif; ?>

    </div>

</section>



<!-- KATEGORI -->

<section
class="lg:col-span-2
       bg-[#30302b]
       rounded-xl
       p-4"
>

    <h2
    class="text-xl
           font-semibold
           mb-5"
    >
        PENGADUAN PER KATEGORI
    </h2>


    <div
    class="space-y-4"
    >

    <?php

    if ($kategori):

    while (
        $kat =
        $kategori->fetch_assoc()
    ):

    ?>

        <div>

            <div
            class="flex
                   justify-between
                   text-sm
                   mb-1"
            >

                <span>
                    <?= htmlspecialchars(
                        $kat['nama_kategori']
                    ) ?>
                </span>

                <span
                class="text-gray-400"
                >
                    <?= $kat['jumlah'] ?>
                </span>

            </div>


            <div
            class="h-3
                   bg-[#1b1b1b]
                   rounded-full
                   overflow-hidden"
            >

                <?php

                $persen = $stats['total'] > 0
                    ? (
                        $kat['jumlah']
                        / $stats['total']
                    ) * 100
                    : 0;

                ?>

                <div
                class="h-full
                       bg-purple-500
                       rounded-full"
                style="
                    width: <?= $persen ?>%;
                "
                ></div>

            </div>

        </div>

    <?php endwhile; endif; ?>

    </div>

</section>

</div>

</main>

<script src="../../asset/js/script.js"></script>

</body>
</html>