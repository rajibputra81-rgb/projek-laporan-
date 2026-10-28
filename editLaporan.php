<?php
include 'koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: tampilLaporan.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM tb_laporan WHERE id_laporan = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: tampilLaporan.php");
    exit();
}

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
        $update = "UPDATE tb_laporan SET tanggal='$tanggal', kelas='$kelas', kategori='$kategori', judul='$judul', deskripsi='$deskripsi', pelapor='$pelapor', status='$status' WHERE id_laporan='$id'";
        
        if (mysqli_query($conn, $update)) {
            header("Location: tampilLaporan.php");
            exit();
        } else {
            $error = "Gagal update data: " . mysqli_error($conn);
        }
    } else {
        $error = "Semua field wajib diisi!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laporan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen py-10 font-sans text-slate-800">
    <div class="max-w-xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Edit Laporan</h1>
            
            <?php if (!empty($error)) { ?>
                <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-700 p-3 rounded-xl text-sm"><?= $error; ?></div>
            <?php } ?>

            <form action="" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal</label>
                    <input type="date" name="tanggal" required value="<?= htmlspecialchars($data['tanggal']); ?>" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Kelas / Lokasi</label>
                        <input type="text" name="kelas" required value="<?= htmlspecialchars($data['kelas']); ?>" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Kategori</label>
                        <select name="kategori" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                            <option value="Fasilitas" <?= ($data['kategori'] == 'Fasilitas') ? 'selected' : ''; ?>>Fasilitas</option>
                            <option value="Kebersihan" <?= ($data['kategori'] == 'Kebersihan') ? 'selected' : ''; ?>>Kebersihan</option>
                            <option value="Keamanan" <?= ($data['kategori'] == 'Keamanan') ? 'selected' : ''; ?>>Keamanan</option>
                            <option value="Lainnya" <?= ($data['kategori'] == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Judul Masalah</label>
                    <input type="text" name="judul" required value="<?= htmlspecialchars($data['judul']); ?>" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" required class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20"><?= htmlspecialchars($data['deskripsi']); ?></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Pelapor</label>
                        <input type="text" name="pelapor" required value="<?= htmlspecialchars($data['pelapor']); ?>" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Status</label>
                        <select name="status" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                            <option value="dilaporkan" <?= ($data['status'] == 'dilaporkan') ? 'selected' : ''; ?>>Dilaporkan</option>
                            <option value="diproses" <?= ($data['status'] == 'diproses') ? 'selected' : ''; ?>>Diproses</option>
                            <option value="selesai" <?= ($data['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <a href="tampilLaporan.php" class="px-5 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</a>
                    <button type="submit" name="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-xl text-sm transition">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>