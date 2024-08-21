<?php
require_once "config.php";
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


  <!-- Bootstrap core JavaScript-->
  <script src="../src/vendor/jquery/jquery.min.js"></script>
  <script src="../src/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>

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
          <h1 class="h3 mb-2 text-gray-800">Data Absensi</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data Absensi Harian</h6>
            </div>
            <div class="card-body">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <a href="data_absen-create.php" class="btn btn-success pull-right">Tambah Data Absensi</a>
                  </div>
                  <div class="col-md-6">
                    <form action="data_absen-index.php" method="get">
                      <div class="col">
                        <input type="text" class="form-control" placeholder="Pencarian Data Absensi" name="search">
                      </div>
                    </form>
                  </div>
                </div>
                <br>

                <?php
                //Pagination
                if (isset($_GET['pageno'])) {
                  $pageno = $_GET['pageno'];
                } else {
                  $pageno = 1;
                }
                $no_of_records_per_page = 10;
                $offset = ($pageno - 1) * $no_of_records_per_page;

                $total_pages_sql = "SELECT data_absen.uid, tanggal, nama, 
								 min(case when status='IN' then  waktu end) jam_masuk,
								 max(CASE WHEN status='OUT' then waktu end) jam_keluar
							  FROM data_absen, data_karyawan 
							  WHERE data_absen.uid=data_karyawan.uid 
							  GROUP BY data_absen.tanggal,data_absen.uid";
                // $total_pages_sql = "SELECT data_absen.uid, tanggal, nama, division,
                // min(case when status='IN' then waktu end) jam_masuk,
                // max(CASE WHEN status='OUT' then waktu end) jam_keluar 
                // FROM data_absen, data_karyawan 
                // WHERE data_absen.uid=data_karyawan.uid AND tanggal LIKE '2024-07-18%'
                // GROUP BY data_absen.tanggal";


                //   $total_pages_sql = "SELECT * 
                //  FROM data_absen JOIN data_karyawan ON data_absensi.uid = data_karyawan.uid
                //  ORDER BY data_karyawan.id";
                $result = mysqli_query($link, $total_pages_sql);
                $total_rows = mysqli_num_rows($result); //mysqli_fetch_array($result)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);


                //Column sorting on column name
                $orderBy = array('tanggal', 'uid', 'nama');
                $order = 'data_absen.id';
                if (isset($_GET['order']) && in_array($_GET['order'], $orderBy)) {
                  $order = $_GET['order'];
                }

                //Column sort order
                $sortBy = array('asc', 'desc');
                $sort = 'desc';
                if (isset($_GET['sort']) && in_array($_GET['sort'], $sortBy)) {
                  if ($_GET['sort'] == 'asc') {
                    $sort = 'desc';
                  } else {
                    $sort = 'asc';
                  }
                }
                // Attempt select query execution
                $sql = "SELECT * FROM data_absen ORDER BY $order $sort LIMIT $offset, $no_of_records_per_page";
                $sql = "SELECT data_absen.uid, tanggal, nama, 
								 min(case when status='IN' then  waktu end) jam_masuk,
								 max(CASE WHEN status='OUT' then waktu end) jam_keluar
							  FROM data_absen, data_karyawan 
							  WHERE data_absen.uid=data_karyawan.uid 
							  GROUP BY data_absen.tanggal,data_absen.uid
							  ORDER BY $order $sort 
							  LIMIT $offset, $no_of_records_per_page";
                // $sql = "SELECT data_absen.uid, tanggal, nama, division,
                // min(case when status='IN' then waktu end) jam_masuk,
                // max(CASE WHEN status='OUT' then waktu end) jam_keluar FROM data_absen, data_karyawan
                // WHERE data_absen.uid=data_karyawan.uid AND tanggal LIKE '2024-07-18'
                // GROUP BY data_absen.tanggal ORDER BY nama desc LIMIT 0, 10;";


                if (!empty($_GET['search'])) {
                  $search = ($_GET['search']);
                  $sql = "SELECT data_absen.uid, tanggal, nama, 
								 min(case when status='IN' then  waktu end) jam_masuk,
								 max(CASE WHEN status='OUT' then waktu end) jam_keluar
							  FROM data_absen, data_karyawan 
							  WHERE data_absen.uid=data_karyawan.uid AND CONCAT (tanggal,data_absen.uid,nama)
							  LIKE '%$search%'
							GROUP BY data_absen.tanggal,data_absen.uid
                            ORDER BY $order $sort 
                            LIMIT $offset, $no_of_records_per_page";
                } else {
                  $search = "";
                }

                if ($result = mysqli_query($link, $sql)) {
                  if (mysqli_num_rows($result) > 0) {
                    echo "<table class='table table-bordered table-striped'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th><a href=?search=$search&sort=&order=tanggal&sort=$sort>Tanggal</th>";
                    echo "<th><a href=?search=$search&sort=&order=uid&sort=$sort>UID</th>";
                    echo "<th><a href=?search=$search&sort=&order=nama&sort=$sort>Nama</th>";
                    echo "<th>Jam Masuk</th>";
                    echo "<th>Jam Keluar</th>";
                    echo "<th>Action</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = mysqli_fetch_array($result)) {
                      echo "<tr>";
                      echo "<td>" . tgl_indo($row['tanggal']) . "</td>";
                      echo "<td>" . $row['uid'] . "</td>";
                      echo "<td>" . $row['nama'] . "</td>";
                      echo "<td>" . $row['jam_masuk'] . "</td>";
                      echo "<td>" . $row['jam_keluar'] . "</td>";
                      echo "<td class='text-center'>";
                      echo "<a href='data_absen-update.php?tanggal=$row[tanggal]&uid=$row[uid]' title='Edit' data-toggle='tooltip'><span class='fa fa-edit'></span></a> &nbsp";
                      echo "<a href='data_absen-delete.php?tanggal=$row[tanggal]&uid=$row[uid]' title='Hapus' data-toggle='tooltip'><span class='fa fa-trash'></span></a>";
                      echo "</td>";
                      echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                ?>
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                        <li class="page-item <?php if ($pageno <= 1) {
                                                echo 'disabled';
                                              } ?>">
                          <a class="page-link" href="<?php if ($pageno <= 1) {
                                                        echo '#';
                                                      } else {
                                                        echo "?pageno=" . ($pageno - 1);
                                                      } ?>">Prev</a>
                        </li>
                        <li class="page-item <?php if ($pageno >= $total_pages) {
                                                echo 'disabled';
                                              } ?>">
                          <a class="page-link" href="<?php if ($pageno >= $total_pages) {
                                                        echo '#';
                                                      } else {
                                                        echo "?pageno=" . ($pageno + 1);
                                                      } ?>">Next</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                      </ul>
                    </nav>
                <?php
                    // Free result set
                    mysqli_free_result($result);
                  } else {
                    echo "<p class='lead'><em>No records were found.</em></p>";
                  }
                } else {
                  echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }

                // Close connection
                mysqli_close($link);
                ?>
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


  <!-- Page level plugins -->
  <script src="../src/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../src/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../src/js/sb-admin-2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#nav-absensi').addClass('active');
    })
  </script>


</body>

</html>