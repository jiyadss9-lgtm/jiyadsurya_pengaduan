<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header(
        "Location: ../../index.php"
    );
    exit;
}

require_once __DIR__ .
    '/../../model/pengaduan.php';

$model = new Pengaduan();

$data =
    $model->getUser(
        $_SESSION['user_id']
    );

$kategori =
    $model->getKategori();

$lokasi =
    $model->getLokasi();

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

<title>Dashboard User</title>

<script src="https://cdn.tailwindcss.com"></script>

<link
    rel="stylesheet"
    href="../../asset/css/style.css"
>

</head>


<body
class="bg-[#202020]
       text-white
       min-h-screen"
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
            <?= htmlspecialchars(
                $_SESSION['user_nama']
                ?? 'USER'
            ) ?>
        </h2>

        <p
        class="text-xs
               text-gray-500"
        >
            <?= htmlspecialchars(
                $_SESSION['user_role']
                ?? 'SISWA'
            ) ?>
        </p>

    </div>


    <a
    href="#"
    class="block
           bg-purple-700
           rounded-lg
           px-4
           py-3
           font-semibold"
    >
        🏠 Dashboard
    </a>


    <a
    href="#pengaduan"
    class="block
           px-4
           py-3
           mt-2
           rounded-lg
           hover:bg-white/5"
    >
        📋 Pengaduan Saya
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


<div
class="flex
       justify-between
       items-center
       mb-8"
>

    <div>

        <p
        class="text-purple-400
               text-sm"
        >
            HALO 👋
        </p>

        <h1
        class="text-3xl
               font-bold"
        >
            Dashboard Saya
        </h1>

        <p
        class="text-gray-500
               mt-1"
        >
            Pantau pengaduan sarana sekolah kamu.
        </p>

    </div>


    <button
    onclick="bukaModal()"
    class="bg-purple-700
           hover:bg-purple-600
           px-5
           py-3
           rounded-xl
           font-semibold"
    >
        + Buat Pengaduan
    </button>

</div>


<?php if ($msg): ?>

<div
class="bg-purple-900/40
       border
       border-purple-500/30
       rounded-xl
       p-4
       mb-5"
>

<?php

$pesan = [
    'created' =>
        'Pengaduan berhasil dibuat.',
    'updated' =>
        'Pengaduan berhasil diperbarui.',
    'deleted' =>
        'Pengaduan berhasil dihapus.',
    'cannot_delete' =>
        'Pengaduan sudah diproses dan tidak dapat dihapus.',
    'foto' =>
        'Foto tidak valid.',
    'failed' =>
        'Terjadi kesalahan.'
];

echo htmlspecialchars(
    $pesan[$msg] ?? 'Selesai.'
);

?>

</div>

<?php endif; ?>



<!-- LIST -->

<section
id="pengaduan"
class="bg-[#30302b]
       rounded-xl
       p-5"
>

    <div
    class="flex
           justify-between
           mb-5"
    >

        <h2
        class="text-xl
               font-semibold"
        >
            PENGADUAN SAYA
        </h2>

    </div>


    <div
    class="space-y-3"
    >

    <?php if (
        !$data ||
        $data->num_rows === 0
    ): ?>

        <div
        class="text-center
               py-12
               text-gray-500"
        >

            <div
            class="text-5xl
                   mb-3"
            >
                📋
            </div>

            Belum ada pengaduan.

        </div>

    <?php else: ?>


        <?php while (
            $row =
            $data->fetch_assoc()
        ): ?>


            <div
            class="bg-[#242421]
                   rounded-xl
                   p-4"
            >

                <div
                class="flex
                       gap-4"
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
                        class="w-20
                               h-20
                               rounded-xl
                               object-cover"
                        >

                    <?php else: ?>

                        <div
                        class="w-20
                               h-20
                               rounded-xl
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

                        <div
                        class="flex
                               justify-between
                               gap-2"
                        >

                            <h3
                            class="font-bold
                                   text-lg"
                            >
                                <?= htmlspecialchars(
                                    $row['judul_pengaduan']
                                ) ?>
                            </h3>


                            <?php

                            $status =
                                strtolower(
                                    $row['status']
                                );

                            $warna =
                                'bg-gray-600';

                            if (
                                $status === 'selesai'
                            ) {
                                $warna =
                                    'bg-green-500';
                            }

                            if (
                                $status === 'diproses'
                            ) {
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
                                   py-1
                                   rounded-lg
                                   text-xs
                                   font-bold
                                   h-fit"
                            >
                                <?= htmlspecialchars(
                                    $status
                                ) ?>
                            </span>

                        </div>


                        <p
                        class="text-sm
                               text-gray-400
                               mt-1"
                        >
                            <?= htmlspecialchars(
                                $row['nama_kategori']
                            ) ?>
                            ·
                            <?= htmlspecialchars(
                                $row['nama_ruangan']
                            ) ?>
                        </p>


                        <p
                        class="text-sm
                               text-gray-500
                               mt-2"
                        >
                            <?= htmlspecialchars(
                                $row['deskripsi']
                            ) ?>
                        </p>

                    </div>

                </div>


                <?php if (
                    in_array(
                        $status,
                        ['baru','pending'],
                        true
                    )
                ): ?>

                <div
                class="flex
                       justify-end
                       gap-2
                       mt-4
                       pt-3
                       border-t
                       border-white/5"
                >

                    <button
                    type="button"
                    onclick='editPengaduan(
                        <?= json_encode([
                            'id' =>
                                $row['pengaduan_id'],
                            'judul' =>
                                $row['judul_pengaduan'],
                            'kategori' =>
                                $row['kategori_id'],
                            'lokasi' =>
                                $row['lokasi_id'],
                            'urgensi' =>
                                $row['urgensi'],
                            'deskripsi' =>
                                $row['deskripsi']
                        ]) ?>
                    )'
                    class="bg-purple-500/20
                           text-purple-300
                           px-4
                           py-2
                           rounded-lg
                           text-sm"
                    >
                        ✏ Edit
                    </button>


                    <form
                    action="../../controller/pengaduancontroller.php"
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
                               px-4
                               py-2
                               rounded-lg
                               text-sm"
                        >
                            🗑 Hapus
                        </button>

                    </form>

                </div>

                <?php endif; ?>

            </div>


        <?php endwhile; ?>


    <?php endif; ?>

    </div>

</section>

</main>



<!-- MODAL -->

<div
id="modal"
class="hidden
       fixed
       inset-0
       bg-black/70
       items-center
       justify-center
       p-5
       z-50"
>

<div
class="bg-[#292927]
       rounded-2xl
       p-6
       w-full
       max-w-xl"
>


<div
class="flex
       justify-between
       mb-5"
>

    <h2
    id="judulModal"
    class="text-xl
           font-bold"
    >
        Buat Pengaduan
    </h2>

    <button
    onclick="tutupModal()"
    class="text-2xl
           text-gray-500"
    >
        ×
    </button>

</div>


<form
id="formPengaduan"
action="../../controller/pengaduancontroller.php"
method="POST"
enctype="multipart/form-data"
class="space-y-4"
>


<input
type="hidden"
name="action"
id="action"
value="tambah"
>


<input
type="hidden"
name="pengaduan_id"
id="pengaduan_id"
>


<input
type="text"
name="judul_pengaduan"
id="judul"
placeholder="Judul pengaduan"
required
class="w-full
       bg-[#191919]
       border
       border-white/10
       rounded-xl
       px-4
       py-3"
>


<select
name="kategori_id"
id="kategori"
required
class="w-full
       bg-[#191919]
       border
       border-white/10
       rounded-xl
       px-4
       py-3"
>

<option value="">
    Pilih kategori
</option>

<?php while (
    $kat =
    $kategori->fetch_assoc()
): ?>

<option
value="<?= $kat['kategori_id'] ?>"
>
    <?= htmlspecialchars(
        $kat['nama_kategori']
    ) ?>
</option>

<?php endwhile; ?>

</select>


<select
name="lokasi_id"
id="lokasi"
required
class="w-full
       bg-[#191919]
       border
       border-white/10
       rounded-xl
       px-4
       py-3"
>

<option value="">
    Pilih lokasi
</option>

<?php while (
    $lok =
    $lokasi->fetch_assoc()
): ?>

<option
value="<?= $lok['lokasi_id'] ?>"
>
    <?= htmlspecialchars(
        $lok['nama_ruangan']
    ) ?>
</option>

<?php endwhile; ?>

</select>


<select
name="urgensi"
id="urgensi"
class="w-full
       bg-[#191919]
       border
       border-white/10
       rounded-xl
       px-4
       py-3"
>

<option value="rendah">
    Rendah
</option>

<option value="sedang" selected>
    Sedang
</option>

<option value="tinggi">
    Tinggi
</option>

</select>


<textarea
name="deskripsi"
id="deskripsi"
rows="4"
placeholder="Jelaskan masalahnya..."
required
class="w-full
       bg-[#191919]
       border
       border-white/10
       rounded-xl
       px-4
       py-3"
></textarea>


<input
type="file"
name="foto_bukti"
accept=".jpg,.jpeg,.png,.webp"
class="w-full
       text-sm
       text-gray-400"
>


<div
class="flex
       justify-end
       gap-2"
>

<button
type="button"
onclick="tutupModal()"
class="px-4
       py-2
       bg-white/5
       rounded-lg"
>
    Batal
</button>


<button
class="px-5
       py-2
       bg-purple-700
       rounded-lg"
>
    Simpan
</button>

</div>

</form>

</div>

</div>



<script>

const modal =
    document.getElementById('modal');

function bukaModal()
{
    document.getElementById(
        'action'
    ).value = 'tambah';

    document.getElementById(
        'judulModal'
    ).innerText =
        'Buat Pengaduan';

    document.getElementById(
        'formPengaduan'
    ).reset();

    document.getElementById(
        'action'
    ).value = 'tambah';

    modal.classList.remove(
        'hidden'
    );

    modal.classList.add(
        'flex'
    );
}


function tutupModal()
{
    modal.classList.add(
        'hidden'
    );

    modal.classList.remove(
        'flex'
    );
}


function editPengaduan(data)
{
    document.getElementById(
        'action'
    ).value = 'edit';

    document.getElementById(
        'pengaduan_id'
    ).value = data.id;

    document.getElementById(
        'judul'
    ).value = data.judul;

    document.getElementById(
        'kategori'
    ).value = data.kategori;

    document.getElementById(
        'lokasi'
    ).value = data.lokasi;

    document.getElementById(
        'urgensi'
    ).value = data.urgensi;

    document.getElementById(
        'deskripsi'
    ).value = data.deskripsi;

    document.getElementById(
        'judulModal'
    ).innerText =
        'Edit Pengaduan';

    modal.classList.remove(
        'hidden'
    );

    modal.classList.add(
        'flex'
    );
}

</script>

<script src="../../asset/js/script.js"></script>

</body>
</html>