<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('location:index.php');
} else {
  $username = $_SESSION['username'];
  $hak_akses = $_SESSION['hak_akses'];
}
?>

<?php
include "koneksi.php";

if (isset($_POST['batal'])) {
  // Pastikan nilai id_po sudah diterima dari form
  if (isset($_POST['id_po'])) {
    $id_po = $_POST['id_po'];

    // Buat query DELETE dengan menggunakan placeholder untuk nilai id_po
    $a = "DELETE FROM tabel_po WHERE id_po = ?";
    $stmt = mysqli_prepare($koneksi, $a);

    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "s", $id_po); // Sesuaikan "s" dengan tipe data id_po
      mysqli_stmt_execute($stmt);

      // Periksa apakah penghapusan berhasil
      if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "<script language='javascript'>
                    alert('Data PO berhasil dihapus');
                    document.location='form_po.php';
                    </script>";
      } else {
        echo "<script language='javascript'>
                    alert('Gagal menghapus data PO');
                    </script>";
      }

      mysqli_stmt_close($stmt);
    } else {
      echo "<script language='javascript'>
                alert('Gagal melakukan persiapan statement');
                </script>";
    }
  } else {
    echo "<script language='javascript'>
            alert('ID PO tidak valid');
            </script>";
  }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>AdminLTE 3 | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome Icons -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" /> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <!-- IonIcons -->

  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />

  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css" />
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fa fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" />
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fa fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light">AdminLTE 3</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" />
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $username . ' - ' . $hak_akses ?></a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" />
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fa fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
              <a href="dashboard.php" class="nav-link">
                <i class="nav-icon fa fa-address-book-o"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-database"></i>
                <p>
                  Data Master
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="v_barang.php" class="nav-link">
                    <i class="fa fa-circle nav-icon"></i>
                    <p>Barang</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="v_supplayer.php" class="nav-link">
                    <i class="fa fa-circle nav-icon"></i>
                    <p>Supplier</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="form_po.php" class="nav-link active">
                <i class="nav-icon fa fa fa-user"></i>
                <p>PO</p>
              </a>
            <li class="nav-item">
              <a href="logout.php" class="nav-link">
                <i class="nav-icon fa fa fa-user"></i>
                <p>Logout</p>
              </a>

            </li>

            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->

      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <!-- /.card -->
              <form class="form-horizontal" method="post">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">DataTable data user</h3>
                    <div class="box-header">
                      <br><a class="btn btn-success" href="form_tambahpo.php">Tambah Data</a>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>No PO</th>
                          <th>Supplayer</th>
                          <th>Tanggal PO</th>
                          <th>Hapus PO</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        include "koneksi.php";
                        $a = "SELECT a.id_po, a.tgl_po, b.nama_supplayer
                      FROM tabel_po a
                      JOIN tabel_supplayer b ON a.id_supplayer = b.id_supplayer
                      ORDER BY a.id_po";
                        $b = mysqli_query($koneksi, $a);
                        $no = 1;
                        while ($c = mysqli_fetch_array($b)) {
                        ?>
                          <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $c['id_po']; ?></td>
                            <td><?php echo $c['nama_supplayer']; ?></td>
                            <td><?php echo $c['tgl_po']; ?></td>
                            <td>
                              <form method="post" onsubmit="return confirm('Yakin ingin menghapus data?');">
                                <input type="hidden" name="id_po" value="<?php echo $c['id_po']; ?>" />
                                <button type="submit" name="batal" class="btn btn-link"><i class="fa fa-trash"></i></button>
                              </form>
                            </td>
                          </tr>
                        <?php $no++;
                        } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>No</th>
                          <th>No PO</th>
                          <th>Supplayer</th>
                          <th>Tanggal PO</th>
                          <th>Hapus PO</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
              </form>
              <!-- /.card -->
              <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021
      <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE -->
  <script src="dist/js/adminlte.js"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard3.js"></script>
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="plugins/jszip/jszip.min.js"></script>
  <script src="plugins/pdfmake/pdfmake.min.js"></script>
  <script src="plugins/pdfmake/vfs_fonts.js"></script>
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
</body>

</html>