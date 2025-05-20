<?php
require 'function.php';
$anggota = mysqli_query($koneksi, "SELECT * FROM tbanggota ORDER BY idanggota DESC");
$result = mysqli_query($koneksi, "SELECT COUNT(*) AS total_anggota FROM tbanggota");
$jumlah = mysqli_fetch_assoc($result)['total_anggota'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Data Anggota Perpustakaan</title>
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-secondary">
    <a class="navbar-brand ps-3 text-white-50" href="index.php">Sistem Perpustakaan</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
  </nav>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark bg-secondary" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <div class="sb-sidenav-menu-heading fs-6">Menu</div>
            <a class="nav-link" href="index.php">
              <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
              Data Anggota
            </a>
            <a class="nav-link" href="buku.php">
              <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
              Data Buku
            </a>
            <a class="nav-link" href="peminjaman.php">
              <div class="sb-nav-link-icon"><i class="fas fa-exchange-alt"></i></div>
              Peminjaman
            </a>
            <a class="nav-link" href="logout.php">
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
          <h1 class="mt-4 text-black-50">Data Anggota</h1>
          <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="card bg-secondary text-white mb-4">
                <div class="card-body">Jumlah Anggota: <?php echo $jumlah ?></div>
              </div>
              <div class="d-flex gap-2">
            <button type="button" class="btn btn-secondary text-white" data-bs-toggle="modal" data-bs-target="#tambahAnggotaModal">
                Tambah
            </button>
            <button type="button" class="btn btn-secondary text-white" onclick="window.print()">
                Cetak Laporan
            </button>
            </div>
            </div>
            <div class="card mb-4">
              <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabel Anggota
              </div>
              <div class="card-body">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>ID Anggota</th>
                      <th>Nama</th>
                      <th>Jenis Kelamin</th>
                      <th>Alamat</th>
                      <th>Status</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($anggota as $gota): ?>
                      <tr>
                        <td><?= $gota['idanggota'] ?></td>
                        <td><?= $gota['nama'] ?></td>
                        <td><?= $gota['jeniskelamin'] ?></td>
                        <td><?= $gota['alamat'] ?></td>
                        <td><?= $gota['status'] ?></td>
                        <td>
                          <button type="button" class="btn btn-light  btn-sm" data-bs-toggle="modal" data-bs-target="#editAnggotaModal<?= $gota['idanggota'] ?>">
                            Edit
                          </button>
                          <a href="function.php?hapus_anggota=<?= $gota['idanggota'] ?>" class="btn btn-light btn-sm" onclick="return confirm('Yakin ingin menghapus anggota?')">
                            Hapus
                          </a>
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

  <!-- Modal Tambah Anggota -->
  <div class="modal" id="tambahAnggotaModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Anggota Baru</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form method="POST" action="function.php">
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input type="text" class="form-control" name="nama" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Jenis Kelamin</label>
              <select class="form-control" name="jeniskelamin" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Alamat</label>
              <textarea class="form-control" name="alamat" required></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Status</label>
              <select class="form-control" name="status" required>
                <option value="">Pilih Status</option>
                <option value="Sedang meminjam">Sedang Meminjam</option>
                <option value="Tidak meminjam">Tidak meminjam</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="tambah_anggota">Simpan</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Edit Anggota (akan dibuat dinamis untuk setiap anggota) -->
  <?php foreach ($anggota as $gota): ?>
    <div class="modal" id="editAnggotaModal<?= $gota['idanggota'] ?>">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Anggota</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form method="POST" action="function.php">
            <input type="hidden" name="idanggota" value="<?= $gota['idanggota'] ?>">
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama" value="<?= $gota['nama'] ?>" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select class="form-control" name="jeniskelamin" required>
                  <option value="Laki-laki" <?= $gota['jeniskelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                  <option value="Perempuan" <?= $gota['jeniskelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea class="form-control" name="alamat" required><?= $gota['alamat'] ?></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Status</label>
                <select class="form-control" name="status" required>
                  <option value="Sedang Meminjam" <?= $gota['status'] == 'Sedang Meminjam' ? 'selected' : '' ?>>Sedang Meminjam</option>
                  <option value="Tidak meminjam" <?= $gota['status'] == 'Tidak meminjam' ? 'selected' : '' ?>>Tidak Meminjam</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success" name="edit_anggota">Update</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
  <script src="js/datatables-simple-demo.js"></script>
</body>

</html>