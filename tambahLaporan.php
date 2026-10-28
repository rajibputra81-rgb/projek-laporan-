<?php
include 'koneksi.php';
$error = '';
if (isset($_POST['submit'])) {
    $tanggal   = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $kelas     = mysqli_real_escape_string($conn, $_POST['kelas']);
    $kategori  = mysqli_real_escape_string($conn, $_POST['kategori']);
    $judul     = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $pelapor   = mysqli_real_escape_string($conn, $_POST['pelapor']);
    $status    = mysqli_real_escape_string($conn, $_POST['status']);

    if (!empty($tanggal) && !empty($kelas) && !empty($kategori) && !empty($judul) && !empty($deskripsi) && !empty($pelapor)) {
        $query = "INSERT INTO tb_laporan (tanggal, kelas, kategori, judul, deskripsi, pelapor, status) 
                  VALUES ('$tanggal', '$kelas', '$kategori', '$judul', '$deskripsi', '$pelapor', '$status')";
        if (mysqli_query($conn, $query)) {
            header("Location: tampilLaporan.php");
            exit();
        } else { $error = "Gagal menyimpan data."; }
    } else { $error = "Semua field wajib diisi!"; }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Tambah Laporan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen py-10 font-sans text-slate-800">
    <div class="max-w-xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Tambah Laporan Baru</h1>
            <?php if (!empty($error)) { echo "<div class='mb-4 bg-rose-50 text-rose-700 p-3 rounded-xl text-sm'>$error</div>"; } ?>
            <form action="" method="POST" class="space-y-4">
                <div><label class="block text-sm font-medium mb-1">Tanggal</label><input type="date" name="tanggal" required value="<?= date('Y-m-d'); ?>" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium mb-1">Kelas / Lokasi</label><input type="text" name="kelas" required placeholder="Contoh: XII IPA 1" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm"></div>
                    <div><label class="block text-sm font-medium mb-1">Kategori</label><select name="kategori" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm bg-white"><option value="Fasilitas">Fasilitas</option><option value="Kebersihan">Kebersihan</option><option value="Keamanan">Keamanan</option><option value="Lainnya">Lainnya</option></select></div>
                </div>
                <div><label class="block text-sm font-medium mb-1">Judul Masalah</label><input type="text" name="judul" required placeholder="Contoh: Kipas Rusak" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm"></div>
                <div><label class="block text-sm font-medium mb-1">Deskripsi</label><textarea name="deskripsi" rows="3" required class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm"></textarea></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium mb-1">Pelapor</label><input type="text" name="pelapor" required class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm"></div>
                    <div><label class="block text-sm font-medium mb-1">Status</label><select name="status" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm bg-white"><option value="dilaporkan">Dilaporkan</option><option value="diproses">Diproses</option><option value="selesai">Selesai</option></select></div>
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <a href="tampilLaporan.php" class="px-5 py-2.5 rounded-xl border border-slate-300 text-sm font-medium">Batal</a>
                    <button type="submit" name="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-xl text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>