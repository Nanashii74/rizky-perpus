<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Data Peminjaman Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="/Assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="sb-nav-fixed">
    <?php if (!session()->get('logged_in')): ?>
        <script>
            window.location.href = '/login';
        </script>
    <?php endif; ?>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-secondary">
        <a class="navbar-brand ps-3 text-white-50" href="<?= base_url('/peminjaman') ?>">Sistem Perpustakaan</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark bg-secondary" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading fs-6">Menu</div>
                        <a class="nav-link" href="<?= base_url('/anggota') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Data Anggota
                        </a>
                        <a class="nav-link" href="<?= base_url('/buku') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                            Data Buku
                        </a>
                        <a class="nav-link" href="<?= base_url('/peminjaman') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-exchange-alt"></i></div>
                            Peminjaman
                        </a>
                        <a class="nav-link" href="javascript:void(0)" onclick="confirmLogout()">
                            <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                            Log Out
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 text-black-50">Data Peminjaman</h1>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-secondary text-white mb-4">
                                <div class="card-body">Jumlah Peminjaman: <?= $jumlah ?></div>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-secondary text-white" data-bs-toggle="modal" data-bs-target="#tambahPeminjamanModal">
                                    Tambah
                                </button>
                                <button type="button" class="btn btn-secondary text-white" onclick="generatePDF()">
                                    Cetak Laporan
                                </button>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Tabel Peminjaman
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID Transaksi</th>
                                            <th>Nama Anggota</th>
                                            <th>Judul Buku</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Tanggal Kembali</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($peminjaman as $p): ?>
                                            <tr>
                                                <td><?= $p['idtransaksi'] ?></td>
                                                <td><?= $p['nama'] ?></td>
                                                <td><?= $p['judulbuku'] ?></td>
                                                <td><?= $p['tglpinjam'] ?></td>
                                                <td><?= $p['tglkembali'] ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#editPeminjamanModal<?= $p['idtransaksi'] ?>">
                                                        Edit
                                                    </button>
                                                    <form method="POST" action="<?= base_url('peminjaman/hapus/' . $p['idtransaksi']) ?>" style="display: inline;">
                                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                                        <button type="submit" class="btn btn-light btn-sm" onclick="return confirm('Yakin ingin menghapus peminjaman?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Perpustakaan</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal Tambah Peminjaman -->
    <div class="modal" id="tambahPeminjamanModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Peminjaman Baru</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="<?= base_url('/peminjaman/tambah') ?>">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">ID Transaksi</label>
                            <input type="text" class="form-control" name="idtransaksi" value="<?= $model->generateTransactionId() ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Anggota</label>
                            <select class="form-select" name="idanggota" required>
                                <option value="">Pilih Anggota</option>
                                <?php foreach ($anggota as $a): ?>
                                    <option value="<?= $a['idanggota'] ?>"><?= $a['idanggota'] ?> - <?= $a['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Buku</label>
                            <select class="form-select" name="idbuku" required>
                                <option value="">Pilih Buku</option>
                                <?php foreach ($buku as $b): ?>
                                    <option value="<?= $b['idbuku'] ?>"><?= $b['idbuku'] ?> - <?= $b['judulbuku'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" name="tglpinjam" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Kembali</label>
                            <input type="date" class="form-control" name="tglkembali" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Peminjaman -->
    <?php foreach ($peminjaman as $p): ?>
        <div class="modal" id="editPeminjamanModal<?= $p['idtransaksi'] ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Peminjaman</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="<?= base_url('peminjaman/edit/' . $p['idtransaksi']) ?>">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Anggota</label>
                                <select class="form-select" name="idanggota" required>
                                    <?php foreach ($anggota as $a): ?>
                                        <option value="<?= $a['idanggota'] ?>" <?= $a['idanggota'] == $p['idanggota'] ? 'selected' : '' ?>>
                                            <?= $a['idanggota'] ?> - <?= $a['nama'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Buku</label>
                                <select class="form-select" name="idbuku" required>
                                    <?php foreach ($buku as $b): ?>
                                        <option value="<?= $b['idbuku'] ?>" <?= $b['idbuku'] == $p['idbuku'] ? 'selected' : '' ?>>
                                            <?= $b['idbuku'] ?> - <?= $b['judulbuku'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pinjam</label>
                                <input type="date" class="form-control" name="tglpinjam" value="<?= $p['tglpinjam'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Kembali</label>
                                <input type="date" class="form-control" name="tglkembali" value="<?= $p['tglkembali'] ?>" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Update</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/Assets/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="/Assets/js/datatables-simple-demo.js"></script>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: "Apakah Anda yakin ingin keluar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Keluar!!!',
                cancelButtonText: 'Batal!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url('/logout') ?>";
                }
            });
            return false;
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

    <script>
        function generatePDF() {
            // Load jsPDF library dynamically if not already loaded
            if (typeof jsPDF === 'undefined') {
                loadScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', function() {
                    loadScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js', createPDF);
                });
            } else {
                createPDF();
            }
        }

        function loadScript(url, callback) {
            const script = document.createElement('script');
            script.src = url;
            script.onload = callback;
            document.head.appendChild(script);
        }

        function createPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // Add title
            doc.setFontSize(16);
            doc.text("LAPORAN DATA PEMINJAMAN ", 105, 15, null, null, "center");
            doc.setFontSize(12);
            doc.text("PERPUSTAKAAN UMUM", 105, 23, null, null, "center");

            // Prepare data
            const rows = [
                <?php foreach ($peminjaman as $index => $p): ?>[
                        <?= $index + 1 ?>,
                        "<?= addslashes($p['idtransaksi']) ?>",
                        "<?= addslashes($p['nama']) ?>",
                        "<?= addslashes($p['judulbuku']) ?>",
                        "<?= addslashes($p['tglpinjam']) ?>",
                        "<?= addslashes($p['tglkembali']) ?>"
                    ],
                <?php endforeach; ?>
            ];

            // Create table
            doc.autoTable({
                startY: 30,
                head: [
                    ['No', 'ID Transaksi', 'Nama', 'Judul Buku', 'Tanggal Pinjam', 'Tanggal Kembali']
                ],
                body: rows,
                styles: {
                    fontSize: 10,
                    cellPadding: 3
                },
                headStyles: {
                    fillColor: [0, 0, 0]
                },
                theme: 'grid',
                margin: {
                    top: 30
                }
            });

            // Save the PDF
            doc.save("laporan-data-peminjaman-<?= date('Y-m-d') ?>.pdf");
        }
    </script>
</body>

</html>