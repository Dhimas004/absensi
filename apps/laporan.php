<?php
require_once('config.php');
$uid = $_GET['uid'];
$tanggal_awal = $_GET['tanggal_awal'];
$tanggal_akhir = $_GET['tanggal_akhir'];
$jabatan_get = $_GET['jabatan'];

function menghitungMenitKerja($waktuMasuk, $waktuKeluar)
{
    // Konversi waktu masuk dan keluar ke objek DateTime
    $masuk = new DateTime($waktuMasuk);
    $keluar = new DateTime($waktuKeluar);

    // Hitung selisih waktu
    $selisih = $masuk->diff($keluar);

    // Ambil total jam dan menit
    $jam = $selisih->h;
    $menit = $selisih->i;

    // Konversi jam menjadi menit dan tambahkan menit
    $totalMenit = ($jam * 60) + $menit;

    return $totalMenit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Digital</title>
    <style>
        * {
            margin: 0 5px;
            font-family: 'Times New Roman', Times, serif;
        }

        th,
        td {
            padding: 0 5px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div style="position: relative; margin-top: 10px;">
        <center style="color: #008080; text-transform: uppercase;">
            <h3 style="padding: 0; margin: 0;">
                LAPORAN ABSENSI
            </h3>
            <span>
                <?php
                if ($tanggal_awal == $tanggal_akhir) {
                    echo tgl_indo($tanggal_awal);
                } else {
                    echo tgl_indo($tanggal_awal) . " - " . tgl_indo($tanggal_akhir);
                }
                ?>
            </span><br />
            <span>PT. AUTOCLEAN WATERLESS</span>
            <br />
            <span>Citra Raya, Komplek Ruko Rembrant Blok R01 No. 29 R, Ciakar, Panongan, Kabupaten Tangerang, Banten</span>

        </center>
        <button type="button" class="no-print" id="btn-print" style="position: absolute; top: 10px; right: 0;">Print</button>
    </div>
    <div style="margin-top: 1rem;">
        <table border="1" style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 15%;">UID</th>
                    <th style="width: 15%;">Nama</th>
                    <th style="width: 15%;">Jabatan</th>
                    <th style="width: 12%;">Jam Masuk</th>
                    <th style="width: 12%;">Jam Pulang</th>
                    <th style="width: 12%;">Jam Telat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $list_data_absen = "SELECT * FROM data_absen JOIN data_karyawan ON data_karyawan.uid = data_absen.uid WHERE 1";
                if ($uid != '') $list_data_absen .= " AND `uid` = '$uid'";
                if ($tanggal_awal != '' && $tanggal_akhir != '') {
                    $list_data_absen .= " AND `tanggal` BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
                }
                $list_data_absen .= " GROUP BY tanggal,data_absen.uid ORDER BY tanggal, data_absen.id";
                $list_data_absen = mysqli_query($link, $list_data_absen);
                while ($row = mysqli_fetch_assoc($list_data_absen)) {
                    $tanggal = $row['tanggal'];
                    $uid = $row['uid'];
                    $nama = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM data_karyawan WHERE uid = '$uid'"))['nama'];
                    $id_jabatan = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM data_karyawan WHERE uid = '$uid'"))['id_jabatan'];
                    $jabatan = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM data_jabatan WHERE id = '$id_jabatan'"))['jabatan'];
                    $jam_masuk = mysqli_fetch_assoc(mysqli_query($link, "SELECT MIN(waktu) as waktu FROM data_absen WHERE uid = '$uid' AND tanggal = '$tanggal' AND status = 'IN'"))['waktu'];
                    $jam_keluar = mysqli_fetch_assoc(mysqli_query($link, "SELECT MAX(waktu) as waktu FROM data_absen WHERE uid = '$uid' AND tanggal = '$tanggal' AND status = 'OUT'"))['waktu'];

                    $show = 1;

                    if ($jabatan_get != '') {
                        if ($id_jabatan != $jabatan_get) {
                            $show = 0;
                        }
                    }
                    if ($show == 1) {

                        // for ($i = 1; $i <= 50; $i++) {
                ?>
                        <tr>
                            <td align="center"><?= $no ?></td>
                            <td align="center"><?= tgl_indo($tanggal) ?></td>
                            <td align="center"><?= $uid ?></td>
                            <td align="left"><?= $nama ?></td>
                            <td align="left"><?= $jabatan ?></td>
                            <td align="center"><?= $jam_masuk ?></td>
                            <td align="center"><?= $jam_keluar ?></td>
                            <td align="center">
                                <?php
                                if (strtotime($jam_masuk) > strtotime("08:00:00")) {
                                    echo "<span style='color:red; font-weight: bold'>" . menghitungMenitKerja("08:00:00", $jam_masuk) . "</span>";
                                } else {
                                    echo "0";
                                }
                                ?>
                            </td>
                        </tr>
                <?php
                        // }
                        $no++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#btn-print').click(function() {
                window.print();
            })
        })
    </script>
</body>

</html>