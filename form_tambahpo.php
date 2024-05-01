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
if (isset($_POST['tambah'])) {
  $id_po = $_POST['id_po'];
  $id_barang = $_POST['id_barang'];
  $nama_barang = $_POST['nama_barang'];
  $jum_po = $_POST['jum_po'];
  $harga_beli = $_POST['harga_beli'];
  $cek  = "SELECT * FROM temp_dtl_po where id_barang = '$id_barang'";
  $cek2 = mysqli_query($koneksi, $cek);
  $cek3 = mysqli_num_rows($cek2);

  if (empty($id_barang) or empty($jum_po)) {
    echo "<script language='javascript'>
  alert('Data belum lengkap !');
  </script>";
  } elseif ($cek3 >= 1) {
    echo "<script language='javascript'>
  alert('Data barang sudah ada di list');
  </script>";
  } else {
    $a = "insert into temp_dtl_po values('$id_po','$id_barang','$jum_po','$harga_beli')";
    $b = mysqli_query($koneksi, $a);
    if ($b) {
      echo "<script language='javascript'>
          document.location='form_tambahpo.php';
          </script>";
    }
  }
}
/* simpan data */
if (isset($_POST['simpan'])) {
  $id_po = $_POST['id_po'];
  $tgl_po = $_POST['tgl_po'];
  $username = $_SESSION['username'];
  $ip_access = $_SERVER['REMOTE_ADDR'];
  $date = str_replace('/', '-', $tgl_po);
  $tgl_po2 = date('Y-m-d', strtotime($date));
  $id_supplayer = $_POST['id_supplayer'];
  if (empty($id_po) or empty($tgl_po) or empty($id_supplayer)) {
    echo "<script language='javascript'>
alert('Data belum lengkap !');
</script>";
  } else {
    $a = "INSERT INTO tabel_po (id_po, tgl_po, id_supplayer, created_at, created_by , ip_access)
          VALUES ('$id_po', '$tgl_po2', '$id_supplayer', now() , '$username', '$ip_access')";
    $b = mysqli_query($koneksi, $a);
    if ($a) {
      $simdet  = mysqli_query($koneksi, "SELECT * FROM temp_dtl_po");
      while ($r = mysqli_fetch_row($simdet)) {

        mysqli_query($koneksi, "INSERT INTO dtl_po VALUES ('$id_po','$r[1]','$r[2]','$r[3]')");
      }
      mysqli_query($koneksi, "TRUNCATE TABLE temp_dtl_po");
      echo "<script language='javascript'>
    alert('Cetak PO has been saved');
    document.location='form_tambahpo.php';
    </script>";
    }
  }
}

if (isset($_POST['hapus'])) {
  $a = "delete from temp_dtl_po where id_barang ;";
  $b = mysqli_query($koneksi, $a);
  if ($b) {
    echo "<script language='javascript'>
        document.location='form_tambahpo.php';
        </script>";
  }
}
if (isset($_POST['batal'])) {
  $a = "delete from temp_dtl_po;";
  $b = mysqli_query($koneksi, $a);
  if ($b) {
    echo "<script language='javascript'>
        document.location='form_tambahpo.php';
        </script>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Form tambah data</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <!-- IonIcons -->

  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />

  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
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

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fa fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle" />
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                  </h3>
                  <p class="text-sm">Call me whenever you can...</p>
                  <p class="text-sm text-muted">
                    <i class="fa fa-clock mr-1"></i> 4 Hours Ago
                  </p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3" />
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>
                  </h3>
                  <p class="text-sm">I got your message bro</p>
                  <p class="text-sm text-muted">
                    <i class="fa fa-clock mr-1"></i> 4 Hours Ago
                  </p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3" />
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span>
                  </h3>
                  <p class="text-sm">The subject goes here</p>
                  <p class="text-sm text-muted">
                    <i class="fa fa-clock mr-1"></i> 4 Hours Ago
                  </p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fa fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fa fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fa fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fa fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fa fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fa fa-th-large"></i>
          </a>
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


      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <!-- /.card -->

              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Form Tambah Data</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post">
                  <div class="card-body">
                    <div class="form-group row">
                      <label for="fname" class="col-sm-2 text-right control-label col-form-label">Id Barang</label>
                      <div class="col-sm-3">
                        <input type="text" name="id_barang" id="id_barang" class="form-control" id="fname" placeholder="Id Barang" readonly>
                      </div><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#popup">Cari</button>
                    </div>
                    <div class="form-group row">
                      <label for="fname" class="col-sm-2 text-right control-label col-form-label">Nama Barang</label>
                      <div class="col-sm-3">
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control" id="fname" placeholder="Nama Barang" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="fname" class="col-sm-2 text-right control-label col-form-label">stok</label>
                      <div class="col-sm-3">
                        <input type="text" name="stok" id="stok" class="form-control" id="fname" placeholder="stok" readonly>
                      </div>
                    </div>
                    <div class=" form-group row">
                      <label for="fname" class="col-sm-2 text-right control-label col-form-label">harga</label>
                      <div class="col-sm-3">
                        <input type="text" name="harga_beli" id="harga" class="form-control" id="fname" placeholder="harga" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="fname" class="col-sm-2 text-right control-label col-form-label">jumlah PO</label>
                      <div class="col-sm-3">
                        <input type="text" name="jum_po" id="jumlah_po" class="form-control" id="fname" placeholder="jumlah_po" onchange="jumhar();" onkeypress="return hanyaAngka(event)">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="fname" class="col-sm-2 text-right control-label col-form-label">Jumalah Harga</label>
                      <div class="col-sm-3">
                        <input type="text" name="jml_harga" id="jml_harga" class="form-control" id="fname" placeholder="jumlah harga" readonly>
                      </div>
                      <input type="submit" name="tambah" value="tambah" class="btn btn-success">
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode barang</th>
                          <th>Nama barang</th>
                          <th>Harga barang</th>
                          <th>Jumlah po</th>
                          <th>Jumlah Harga</th>
                          <th>Opsi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        include "koneksi.php";
                        $a = "select 
                                  b.id_barang,
                                  a.nama_barang,
                                  b.harga_beli,
                                  b.jum_po,
                                  b.harga_beli*b.jum_po as kali
                                  from temp_dtl_po b 
                                  join tabel_barang a
                                  on b.id_barang= a.id_barang where deleted_at";
                        $b = mysqli_query($koneksi, $a);
                        $no = 1;
                        while ($c = mysqli_fetch_array($b)) {
                        ?>
                          <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $c['id_barang']; ?></td>
                            <td><?php echo $c['nama_barang']; ?></td>
                            <td><?php echo $c['harga_beli']; ?></td>
                            <td><?php echo $c['jum_po']; ?></td>
                            <td><?php echo $c['kali']; ?></td>
                            <td>
                              <button type="submit" name="batal" class="fa fa-trash" value="Cancel">

                            </td>
                          </tr>
                        <?php $no++;
                        } ?>
                      </tbody>

                      <tfoot>
                        <tr>
                          <th>No</th>
                          <th>Kode barang</th>
                          <th>Nama barang</th>
                          <th>Harga barang</th>
                          <th>Jumlah po</th>
                          <th>Jumlah Harga</th>
                          <th>Opsi</th>
                        </tr>
                      </tfoot>
                    </table>
                    <div class="form-group row">
                      <label for="fname" class="col-sm-2 text-right control-label col-form-label">Kode PO</label>
                      <div class="col-sm-4">
                        <input type="text" name="id_po" class="form-control" id="fname" placeholder="Kode PO" value="<?= autonumber("tabel_po", "id_po", 7, "PO") ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="fname" class="col-sm-2 text-right control-label col-form-label">Tanggal PO</label>
                      <div class="col-sm-4">
                        <input type="date" name="tgl_po" class="form-control">

                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="fname" class="col-sm-2 text-right control-label col-form-label">Id Supplier</label>
                      <div class="col-sm-4">
                        <input type="text" name="id_supplayer" id="id_supplayer" class="form-control" placeholder="Id Supplier" readonly>
                      </div><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#popup2">Cari</button>
                    </div>
                    <div class="form-group row">
                      <label for="fname" class="col-sm-2 text-right control-label col-form-label">Nama Supplier</label>
                      <div class="col-sm-4">
                        <input type="text" name="nama_supplayer" id="nama_supplayer" class="form-control" placeholder="Nama Supplier" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="fname" class="col-sm-2 text-right control-label col-form-label">Total Harga</label>
                      <div class="col-sm-4">
                        <?php
                        $a = "select sum(jum_po * harga_beli) as total from temp_dtl_po";
                        $b = mysqli_query($koneksi, $a);
                        while ($c = mysqli_fetch_array($b)) {
                        ?>
                          <input type="text" name="total_harga" id="total_harga" class="form-control" id="fname" value="<?php echo $c['total'];
                                                                                                                      } ?>" placeholder="Total Harga" readonly>
                      </div>
                    </div>
                    <div class="border-top">
                      <div class="card-body">
                        <input type="submit" name="simpan" class="btn btn-primary" value="Save">
                        <input type="submit" name="batal" class="btn btn-danger" value="Cancel">
                      </div>
                    </div>

                  </div>
              </div>

              <!-- /.card-body -->
              </form>
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>


          <!-- /.card -->
        </div>

      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content -->
  </div>


  <!-- COPY HERE MODAL -->
  <div class="modal fade" id="popup">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Pilih Barang</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>id barang</th>
                  <th>Nama barang</th>
                  <th>stok</th>
                  <th>harga</th>
                  <th>opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                include "koneksi.php";
                $get = mysqli_query($koneksi, "SELECT * FROM tabel_barang order by id_barang");
                while ($tampil = mysqli_fetch_array($get)) {
                ?>
                  <tr>
                    <td id='id_barang_<?php echo $tampil['id_barang']; ?>'><?php echo $tampil['id_barang']; ?></td>
                    <td id='nama_barang_<?php echo $tampil['id_barang']; ?>'><?php echo $tampil['nama_barang']; ?></td>
                    <td id='stok_<?php echo $tampil['id_barang']; ?>'><?php echo $tampil['stok']; ?></td>
                    <td id='harga_<?php echo $tampil['id_barang']; ?>'><?php echo $tampil['harga']; ?></td>
                    <td><button onclick="pilihbarang('<?php echo $tampil['id_barang']; ?>')" class="btn btn-info btn-xs"><i class="fa fa-plus"></i></button></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
      </div>
    </div>
  </div>
  <!-- END HERE MODAL -->


  <!-- COPY HERE MODAL -->
  <div class="modal fade" id="popup2">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Pilih supplayer</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>id supplayer</th>
                  <th>Nama supplayer</th>
                  <th>No Telpon</th>
                  <th>Alamat</th>
                  <th>opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                include "koneksi.php";
                $get = mysqli_query($koneksi, "SELECT * FROM tabel_supplayer order by id_supplayer");
                while ($tampil = mysqli_fetch_array($get)) {
                ?>
                  <tr>
                    <td id='id_supplayer_<?php echo $tampil['id_supplayer']; ?>'><?php echo $tampil['id_supplayer']; ?></td>
                    <td id='nama_supplayer_<?php echo $tampil['id_supplayer']; ?>'><?php echo $tampil['nama_supplayer']; ?></td>
                    <td id='notelpon_<?php echo $tampil['id_supplayer']; ?>'><?php echo $tampil['notelpon']; ?></td>
                    <td id='alamat_<?php echo $tampil['id_supplayer']; ?>'><?php echo $tampil['alamat']; ?></td>
                    <td><button onclick="pilihsupplayer('<?php echo $tampil['id_supplayer']; ?>')" class="btn btn-info btn-xs"><i class="fa fa-plus"></i></button></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
      </div>
    </div>
  </div>
  <!-- END HERE MODAL -->



  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <!-- <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021
      <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
  </div> -->
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
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
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

  <script>
    function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))

        return false;
      return true;
    }

    function pilihbarang(id_barang) {
      id_barang = $('#id_barang_' + id_barang).html();
      nama_barang = $('#nama_barang_' + id_barang).html();
      stok = $('#stok_' + id_barang).html();
      harga = $('#harga_' + id_barang).html();

      $('#id_barang').val(id_barang);
      $('#nama_barang').val(nama_barang);
      $('#stok').val(stok);
      $('#harga').val(harga);

      $('#popup').modal('hide');
    }

    function pilihsupplayer(id_supplayer) {
      id_supplayer = $('#id_supplayer_' + id_supplayer).html();
      nama_supplayer = $('#nama_supplayer_' + id_supplayer).html();
      alamat = $('#alamat_' + id_supplayer).html();

      $('#id_supplayer').val(id_supplayer);
      $('#nama_supplayer').val(nama_supplayer);
      $('#alamat').val(alamat);
      $('#popup2').modal('hide');
    }

    function jumhar() {
      var harga = parseInt($("#harga").val());
      var jumlah_po = parseInt($("#jumlah_po").val());
      var jumhar = (jumlah_po * harga);
      $("#jml_harga").val(jumhar);
    }

    function pembayaran_harga() {
      var bayar = parseInt($("#bayar").val());
      var total_harga = parseInt($("#total_harga").val());
      var kmb = (bayar - total_harga);
      $("#kembalian").val(kmb);
    }
  </script>
  <?php
  function autonumber($tabel, $kolom, $lebar = 0, $awalan = '')
  {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "login";
    $koneksi = mysqli_connect($host, $user, $pass, $db);

    $query = "select $kolom from $tabel order by $kolom desc limit 1";
    $hasil = mysqli_query($koneksi, $query);
    $jumlahrecord = mysqli_num_rows($hasil);
    if ($jumlahrecord == 0)
      $nomor = 1;
    else {
      $row = mysqli_fetch_array($hasil);
      $nomor = intval(substr($row[0], strlen($awalan))) + 1;
    }
    if ($lebar > 0)
      $angka = $awalan . str_pad($nomor, $lebar, "0", STR_PAD_LEFT);
    else
      $angka = $awalan . $nomor;
    return $angka;
  }
  ?>
</body>

</html>