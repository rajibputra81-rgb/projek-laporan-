<?php
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM tb_laporan ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan Masalah Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen font-sans text-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Pelaporan Masalah Sekolah</h1>
                <p class="text-slate-500 mt-1">Sistem pemantauan fasilitas dan kebersihan lingkungan sekolah.</p>
            </div>
            <a href="tambahLaporan.php" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-xl shadow-sm transition">
                + Tambah Laporan
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-100/70 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                            <th class="py-4 px-4">Tanggal</th>
                            <th class="py-4 px-4">Kelas</th>
                            <th class="py-4 px-4">Kategori</th>
                            <th class="py-4 px-4">Judul</th>
                            <th class="py-4 px-4">Deskripsi</th>
                            <th class="py-4 px-4">Pelapor</th>
                            <th class="py-4 px-4">Status</th>
                            <th class="py-4 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        <?php if (mysqli_num_rows($result) > 0) { ?>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-4 text-slate-600 whitespace-nowrap"><?= date('d M Y', strtotime($row['tanggal'])); ?></td>
                                    <td class="py-4 px-4 font-medium text-slate-900 whitespace-nowrap"><?= htmlspecialchars($row['kelas']); ?></td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <span class="inline-block bg-slate-100 text-slate-700 text-xs px-2.5 py-0.5 rounded-full font-medium">
                                            <?= htmlspecialchars($row['kategori']); ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 font-semibold text-slate-800"><?= htmlspecialchars($row['judul']); ?></td>
                                    <td class="py-4 px-4 text-slate-600 max-w-xs truncate" title="<?= htmlspecialchars($row['deskripsi']); ?>">
                                        <?= htmlspecialchars($row['deskripsi']); ?>
                                    </td>
                                    <td class="py-4 px-4 text-slate-600 whitespace-nowrap"><?= htmlspecialchars($row['pelapor']); ?></td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <?php 
                                            $status = $row['status'];
                                            $badgeColor = 'bg-amber-100 text-amber-800 border-amber-200';
                                            if ($status == 'diproses') { 
                                                $badgeColor = 'bg-blue-100 text-blue-800 border-blue-200'; 
                                            } elseif ($status == 'selesai') { 
                                                $badgeColor = 'bg-emerald-100 text-emerald-800 border-emerald-200'; 
                                            }
                                        ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold border <?= $badgeColor; ?> uppercase">
                                            <?= htmlspecialchars($status); ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="editLaporan.php?id=<?= $row['id_laporan']; ?>" class="bg-amber-50 hover:bg-amber-100 text-amber-700 px-3 py-1.5 rounded-lg text-xs font-medium transition">Edit</a>
                                            <a href="hapusLaporan.php?id=<?= $row['id_laporan']; ?>" onclick="return confirm('Yakin ingin menghapus?');" class="bg-rose-50 hover:bg-rose-100 text-rose-700 px-3 py-1.5 rounded-lg text-xs font-medium transition">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="8" class="py-8 text-center text-slate-400">Belum ada data laporan.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>