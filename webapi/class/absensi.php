<?php
require_once('../../apps/connection.php');
date_default_timezone_set('Asia/Jakarta');
class Absensi
{
	// Connection
	private $conn;

	// Table
	private $db_table = "data_absen";
	private $db_table1 = "data_karyawan";
	private $db_table2 = "data_invalid";

	// Columns
	public $id;
	public $tanggal;
	public $waktu;
	public $uid;
	public $status;
	public $last_status;
	public $nama;

	// Db connection
	public function __construct($db)
	{
		$this->conn = $db;
	}

	// CREATE
	public function createData()
	{
		global $link;
		//1. Cek user
		$sqlQuery = "SELECT * FROM " . $this->db_table1 . " WHERE uid = :uid LIMIT 0,1";
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->bindParam(":uid", $this->uid);
		$stmt->execute();
		if ($stmt->errorCode() == 0) {
			while (($dataRow = $stmt->fetch(PDO::FETCH_ASSOC)) != false) {
				$this->nama = $dataRow['nama'];
			}
		} else {
			$errors = $stmt->errorInfo();
			echo ($errors[2]);
		}
		$itemCount = $stmt->rowCount();

		if ($itemCount > 0) {
			//UID terdaftar -> cek status terakhir
			$sqlQuery = "SELECT data_absen.id, data_absen.uid, data_absen.status, data_karyawan.nama 
						FROM " . $this->db_table . ", " . $this->db_table1 . "
						WHERE data_absen.id = (SELECT MAX(data_absen.id) 
						FROM " . $this->db_table . " WHERE data_absen.uid = :uid) 
						AND data_karyawan.uid= :uid AND tanggal = :current_date";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bindParam(":uid", $this->uid);
			$stmt->bindParam(":current_date", date('Y-m-d'));
			$stmt->execute();
			$itemCount = $stmt->rowCount();
			if ($itemCount > 0) {
				//error handling
				if ($stmt->errorCode() == 0) {
					while (($dataRow = $stmt->fetch(PDO::FETCH_ASSOC)) != false) {
						$this->last_status = $dataRow['status'];
						$this->nama = $dataRow['nama'];
						$hari_ini = date('Y-m-d');
						$jumlah_absen = mysqli_num_rows(mysqli_query($link, "SELECT * FROM data_absen WHERE `uid` = '" . $this->uid . "' and tanggal = '$hari_ini'"));
						if ($jumlah_absen > 0) $this->last_status = 'IN';
					}
				} else {
					$errors = $stmt->errorInfo();
					echo ($errors[2]);
				}
			} else {
				$this->last_status = "OUT";
			}

			//set status
			if ($this->last_status == "IN") {
				$this->status = "OUT";
			} else {
				$this->status = "IN";
			}
			//Insert Data to data_absen	
			$sqlQuery = "INSERT INTO " . $this->db_table . "
					SET	waktu = :waktu, uid = :uid, status = :now_status, id_karyawan = :id_karyawan";

			$this->waktu = date("H:i:s");

			$stmt = $this->conn->prepare($sqlQuery);

			// sanitize
			$this->uid = htmlspecialchars(strip_tags($this->uid));
			$id_karyawan = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM data_karyawan WHERE uid = '" . $this->uid . "'"))['id'];
			// bind data
			$stmt->bindParam(":uid", $this->uid);
			$stmt->bindParam(":now_status", $this->status);
			$stmt->bindParam(":waktu", $this->waktu);
			$stmt->bindParam(":id_karyawan", $id_karyawan);

			if ($stmt->execute()) {
				return true;
			}
			return false;
		} else {
			//UID tidak terdaftar
			$this->status = "INVALID";
			$this->nama = "Invalid";

			//Insert Data to data_invalid	
			$sqlQuery = "INSERT INTO
						" . $this->db_table2 . "
					SET
						waktu = :waktu,
						uid = :uid, 
						status = :now_status";
			$this->waktu = date("H:i:s");

			$stmt = $this->conn->prepare($sqlQuery);

			// sanitize
			$this->uid = htmlspecialchars(strip_tags($this->uid));

			// bind data
			$stmt->bindParam(":uid", $this->uid);
			$stmt->bindParam(":now_status", $this->status);
			$stmt->bindParam(":waktu", $this->waktu);

			if ($stmt->execute()) {
				return true;
			}
			return false;
		}
	}
}
