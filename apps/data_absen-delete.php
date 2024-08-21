<?php
require_once('config.php');
$uid = $_GET['uid'];
$tanggal = $_GET['tanggal'];
$nama = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM data_karyawan WHERE uid = '$uid'"))['nama'];

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Absen Digital</title>

  <!-- Custom fonts for this template-->
  <link href="../src/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../src/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="../src/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include 'partial_sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include 'partial_topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <?php
          if (isset($_POST['submit'])) {
            $tanggal = $_POST['tanggal'];
            $uid = $_POST['uid'];
            $query = "DELETE FROM data_absen WHERE uid = '$uid' AND tanggal = '$tanggal'";
            mysqli_query($link, $query);

            echo "<script>alert('Berhasil Hapus Absen'); window.location.href='data_absen-index.php'</script>";
          }
          ?>
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Data Absen</h1>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Hapus Absen</h6>
            </div>
            <div class="card-body">
              <div class="col-md-12 ">
                <div class="alert alert-danger" role="alert">
                  <p>Apakah anda ingin menghapus data absen <?= $nama ?> Tanggal <?= tgl_indo($tanggal) ?>?</p>
                </div>
                <hr>
                <div class="row justify-content-end">
                  <form action="" method="POST">
                    <input type="hidden" name="tanggal" value="<?php echo $tanggal; ?>">
                    <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                    <input type="submit" name="submit" value="Ya" class="btn btn-danger">
                  </form> &nbsp;
                  <a href="data_karyawan-index.php" class="btn btn-primary">Batal</a>
                </div>
              </div>
            </div>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy;Absen Digital</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>



  <!-- Bootstrap core JavaScript-->
  <script src="../src/vendor/jquery/jquery.min.js"></script>
  <script src="../src/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../src/js/sb-admin-2.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#nav-absensi').addClass('active');
    })
  </script>

</body>

</html>