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
          <!-- Page Heading -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Laporan</h6>
            </div>
            <div class="card-body">
              <div class="col-md-12">
                <form action="laporan.php" method="get" target="_blank">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="uid">Nama</label>
                      <select class="form-control" name="uid" id="uid">
                        <option value="">-- Pilih --</option>
                        <?php
                        $list_data_karyawan = mysqli_query($link, "SELECT * FROM data_karyawan ORDER BY nama");
                        while ($row = mysqli_fetch_assoc($list_data_karyawan)) {
                          $nama = $row['nama'];
                          $uid = $row['uid'];
                        ?>
                          <option value="<?= $uid ?>"><?= $nama ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>

                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="jabatan">Jabatan</label>
                      <select class="form-control" name="jabatan">
                        <option value="">-- Pilih --</option>
                        <?php
                        $list_jabatan = mysqli_query($link, "SELECT * FROM data_jabatan ORDER BY jabatan");
                        while ($data = mysqli_fetch_assoc($list_jabatan)) {
                          echo '<option value="' . $data['id'] . '">' . $data['jabatan'] . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="tanggal_awal">Tanggal Awal</label>
                      <input type="text" name="tanggal_awal" class="form-control datepicker" id="tna" placeholder="Tanggal Awal" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="tanggal_akhir">Tanggal Akhir</label>
                      <input type="text" name="tanggal_akhir" class="form-control datepicker" id="tanggal_akhir" placeholder="Tanggal Akhir" required>
                    </div>
                  </div>

                  <hr>
                  <div class="row justify-content-end">
                    <button type="submit" class="btn btn-success">Cari</button>
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
      $('#nav-laporan').addClass('active');

      $(".datepicker").datepicker({
        dateFormat: "yy-mm-dd",
      });
      $(".timepicker").timepicker({
        timeFormat: "HH:mm:ss",
        showSecond: true
      });
    })
  </script>


</body>

</html>