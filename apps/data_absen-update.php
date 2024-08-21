<?php
require_once('config.php');

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
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">

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
          $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
          $uid = isset($_GET['uid']) ? $_GET['uid'] : '';
          $res = [];
          $data_absen = mysqli_query($link, "SELECT * FROM data_absen WHERE tanggal = '$tanggal' AND uid = '$uid'");
          while ($row = mysqli_fetch_assoc($data_absen)) {
            $status = $row['status'];
            if ($status == 'IN') $res['jam_masuk'] = $row['waktu'];
            else if ($status == 'OUT') $res['jam_keluar'] = $row['waktu'];
          }
          if (isset($_POST['submit'])) {
            $nama = $_POST['nama'];
            $uid = $_POST['uid'];
            $tanggal = $_POST['tanggal'];
            $jam_masuk = $_POST['jam_masuk'];
            $jam_keluar = $_POST['jam_keluar'];
            $tanggal_get = $_POST['tanggal_get'];

            mysqli_query($link, "DELETE FROM data_absen WHERE `uid` = '$uid' AND tanggal = '$tanggal_get'");
            mysqli_query($link, "INSERT INTO `data_absen` (
              `tanggal`,
              `waktu`,
              `uid`,
              `status`
            )
            VALUES
              (
                '$tanggal',
                '$jam_masuk',
                '$uid',
                'IN'
              );
            ");
            mysqli_query($link, "INSERT INTO `data_absen` (
              `tanggal`,
              `waktu`,
              `uid`,
              `status`
            )
            VALUES
              (
                '$tanggal',
                '$jam_keluar',
                '$uid',
                'OUT'
              );
            ");
            echo "<script>alert('Berhasil Update Absen'); window.location.href='data_absen-index.php'</script>";
          }
          ?>

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Data Absen</h1>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Update Data</h6>
            </div>
            <div class="card-body">
              <div class="col-md-12">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="nama">Nama</label>
                      <select class="form-control" name="nama" id="nama" required>
                        <option value="">-- Pilih --</option>
                        <?php
                        $list_data_karyawan = mysqli_query($link, "SELECT * FROM data_karyawan ORDER BY nama");
                        while ($row = mysqli_fetch_assoc($list_data_karyawan)) {
                          $nama = $row['nama'];
                          $uid = $row['uid'];
                        ?>
                          <option value="<?= $nama ?>" data-uid="<?= $uid ?>" <?= ($_GET['uid'] == $uid ? 'selected' : '') ?>><?= $nama ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                    <input type="hidden" name="tanggal_get" value="<?= $_GET['tanggal'] ?>">
                    <div class="form-group col-md-6">
                      <label for="uid">UID</label>
                      <input type="text" name="uid" class="form-control" id="uid" placeholder="UID" readonly required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="tanggal">Tanggal</label>
                      <input type="text" name="tanggal" class="form-control datepicker" id="tanggal" value="<?= $_GET['tanggal'] ?>" placeholder="tanggal" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="jam_masuk">Jam Masuk</label>
                      <input type="text" name="jam_masuk" class="form-control timepicker" id="jam_masuk" value="<?= $res['jam_masuk'] ?>" placeholder="Jam Masuk" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="jam_keluar">Jam Keluar</label>
                      <input type="text" name="jam_keluar" class="form-control timepicker" id="jam_keluar" value="<?= $res['jam_keluar'] ?>" placeholder="Jam Keluar" required>
                    </div>
                  </div>

                  <hr>
                  <div class="row justify-content-end">
                    <input type="submit" class="btn btn-success" value="Edit" name="submit"> &nbsp
                    <a href="data_absen-index.php" class="btn btn-primary">Batal</a>
                  </div>
                </form>

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
            <span>Copyright &copy; AutoClean Waterless</span>
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


  <!-- Core plugin JavaScript-->
  <script src="../src/vendor/jquery/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="../src/js/sb-admin-2.min.js"></script>

  <!-- Bootstrap core JavaScript-->
  <script src="../src/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".datepicker").datepicker({
        dateFormat: "yy-mm-dd",
      });
      $(".timepicker").timepicker({
        timeFormat: "HH:mm:ss",
        showSecond: true
      });
      $('#nama').change(function() {
        var uid = $(this).find(':selected').attr('data-uid');
        console.log(uid);
        $('#uid').val(uid);
      })
      $('#nama').trigger('change');
    })
  </script>


</body>

</html>