<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Intruksi Kerja Nomor 1 CSS -->
	<link rel="stylesheet" href="../assets/css/bootstrap copy.css">

	<title>Hitung Biaya Parkir Mall</title>
</head>
<body>

<div class="container border">
		<!-- Instruksi Kerja Nomor 2. -->
		<!-- Menampilkan logo Mall -->
		<img src="../assets/images/logo.png" alt="Logo Restoran Terserah" width="100px">
		

		<span><b>Hitung Biaya Parkir Mall</b></span>
		<br>
		<form action="index.php" method="post" id="formPerhitungan">
			<div class="row">
				<!-- Masukan data plat nomor kendaraan. Tipe data text. -->
				<div class="col-lg-2"><label for="nama">Plat Nomor Kendaraan:</label></div>
				<div class="col-lg-2"><input type="text" id="plat" name="plat" required></div>
			</div>

			<div class="row">
				<!-- Masukan pilihan jenis kendaraan. -->
				<div class="col-lg-2"><label for="tipe">Jenis Kendaraan:</label></div>
				<div class="col-lg-2">
					<!-- Instruksi Kerja Nomor 3, 4, dan 5 -->
					<?php tampilkan_radio_kendaraan(); ?>
				</div>
			</div>

			<div class="row">
				<!-- Masukan Jam Masuk Kendaraan -->
				<div class="col-lg-2"><label for="nomor">Jam Masuk [jam]:</label></div>
				<div class="col-lg-2">
					<select id="masuk" name="masuk" required>
					<option value="">- Jam Masuk -</option>
					<!-- Instruksi Kerja Nomor 6 -->
					<?php tampilkan_options_jam(); ?>
					</select>
				</div>
			</div>

			<div class="row">
				<!-- Masukan Jam Keluar Kendaraan. -->
				<div class="col-lg-2"><label for="nomor">Jam Keluar [jam]:</label></div>
				<div class="col-lg-2">
					<select id="keluar" name="keluar" required>
					<option value="">- Jam Keluar -</option>
					<!-- Instruksi Kerja Nomor 6 -->
					<?php tampilkan_options_jam(); ?>
					</select>
				</div>
			</div>

			<div class="row">
				<!-- Masukan pilihan Member. -->
				<div class="col-lg-2"><label for="tipe">Keanggotaan:</label></div>
				<div class="col-lg-2">
					<input type='radio' name='member' value='Member' required> Member <br>
					<input type='radio' name='member' value='Non-Member'> Non Member <br>
					
				</div>
			</div>

			<div class="row">
				<!-- Tombol Submit -->
				<div class="col-lg-2"><button class="btn btn-primary" type="submit" form="formPerhitungan" value="hitung" name="hitung">Hitung</button></div>
				<div class="col-lg-2"></div>		
			</div>
		</form>
	</div>
<?php
// ===============================================
// BAGIAN FUNCTION


/**
 * Fungsi untuk menghitung biaya parkir berdasarkan jenis kendaraan dan durasi
 * @param int $durasi - Durasi parkir dalam jam
 * @param string $kendaraan - Jenis kendaraan (Mobil/Motor/Truk)
 * @return int $biaya - Total biaya parkir sebelum diskon
 */
function hitung_parkir($durasi, $kendaraan){
	$biaya = 0;
	
	if($kendaraan == "Mobil") {
		// Mobil: 1 jam pertama Rp 5.000, jam berikutnya Rp 3.000
		$biaya = 5000 + (($durasi - 1) * 3000);
	} 
	elseif($kendaraan == "Motor") {
		// Motor: 1 jam pertama Rp 2.000, jam berikutnya Rp 1.000
		$biaya = 2000 + (($durasi - 1) * 1000);
	} 
	elseif($kendaraan == "Truk") {
		// Truk: Rp 6.000 per jam
		$biaya = 6000 * $durasi;
	}
	
	return $biaya;
}

/**
 * Fungsi untuk menghitung biaya akhir setelah diskon
 * @param int $biaya_parkir - Biaya parkir sebelum diskon
 * @param string $status_member - Status keanggotaan (Member/Non-Member)
 * @return int $biaya_akhir - Total biaya setelah diskon
 */
function hitung_diskon($biaya_parkir, $status_member) {
	if($status_member == "Member") {
		// Member mendapat diskon 10%
		$diskon = $biaya_parkir * 0.1;
		$biaya_akhir = $biaya_parkir - $diskon;
	} else {
		// Non-Member tidak dapat diskon
		$biaya_akhir = $biaya_parkir;
	}
	
	return $biaya_akhir;
}

/**
 * Fungsi untuk menyimpan data parkir ke file JSON
 * @param array $data - Data parkir yang akan disimpan
 * @param string $nama_file - Nama file JSON
 * @return bool - True jika berhasil, False jika gagal
 */
function simpan_ke_json($data, $nama_file = "data/data.json") {
	// Membaca data lama jika file sudah ada
	$dataLama = array();
	if(file_exists($nama_file)) {
		$dataJson = file_get_contents($nama_file);
		$dataLama = json_decode($dataJson, true);
		if(!is_array($dataLama)) {
			$dataLama = array();
		}
	}
	
	// Menambahkan data baru ke array
	$dataLama[] = $data;
	
	// Menyimpan ke file JSON
	$dataJson = json_encode($dataLama, JSON_PRETTY_PRINT);
	return file_put_contents($nama_file, $dataJson);
}

/**
 * Fungsi untuk mengambil array jenis kendaraan yang sudah diurutkan
 * @return array - Array jenis kendaraan terurut
 */
function get_jenis_kendaraan() {
	$jenis_kendaraan = array("Truk", "Motor", "Mobil");
	sort($jenis_kendaraan); // Mengurutkan ascending
	return $jenis_kendaraan;
}

/**
 * Fungsi untuk generate radio button jenis kendaraan
 * @return void - Menampilkan HTML radio button
 */
function tampilkan_radio_kendaraan() {
	$jenis_kendaraan = get_jenis_kendaraan();
	foreach($jenis_kendaraan as $kendaraan) {
		echo "<input type='radio' name='kendaraan' value='$kendaraan' required> $kendaraan <br>";
	}
}

/**
 * Fungsi untuk generate options jam (1-24)
 * @return void - Menampilkan HTML options
 */
function tampilkan_options_jam() {
	for($i = 1; $i <= 24; $i++) {
		echo "<option value='$i'>$i:00</option>";
	}
}

/**
 * Fungsi untuk validasi durasi parkir
 * @param int $durasi - Durasi parkir
 * @return bool - True jika valid, False jika tidak
 */
function validasi_durasi($durasi) {
	return $durasi > 0;
}

/**
 * Fungsi untuk menampilkan hasil perhitungan parkir
 * @param array $dataParkir - Data parkir
 * @param int $biaya_akhir - Biaya akhir setelah diskon
 * @return void - Menampilkan HTML hasil
 */
function tampilkan_hasil($dataParkir, $biaya_akhir) {
	echo "
	<br/>
	<div class='container'>
	<div class='row'>
	<!-- Menampilkan Plat Nomor Kendaraan. -->
	<div class='col-lg-2'>Plat Nomor Kendaraan:</div>
	<div class='col-lg-2'>".$dataParkir['plat']."</div>
	</div>
	<div class='row'>
	<!-- Menampilkan Jenis Kendaraan. -->
	<div class='col-lg-2'>Jenis Kendaraan:</div>
	<div class='col-lg-2'>".$dataParkir['kendaraan']."</div>
	</div>
	<div class='row'>
	<!-- Menampilkan Durasi Parkir. -->
	<div class='col-lg-2'>Durasi Parkir:</div>
	<div class='col-lg-2'>".$dataParkir['durasi']." jam</div>
	</div>
	<div class='row'>
	<!-- Menampilkan Jenis Keanggotaan. -->
	<div class='col-lg-2'>Keanggotaan:</div>
	<div class='col-lg-2'>".$dataParkir['member']." </div>
	</div>
	<div class='row'>
	<!-- Menampilkan Total Biaya Parkir. -->
	<div class='col-lg-2'>Total Biaya Parkir:</div>
	<div class='col-lg-2'>Rp".number_format($biaya_akhir, 0, ".", ".").",-</div>
	</div>

	</div>
	";
}

// AKHIR BAGIAN FUNGSI

?>

	

	<?php
	
	// BAGIAN PROSES PERHITUNGAN

    
	if(isset($_POST['hitung'])) {

		// Instruksi Kerja Nomor 7 (hitung durasi)
		$durasi = $_POST['keluar'] - $_POST['masuk'];
		
		// Validasi durasi
		if(!validasi_durasi($durasi)) {
			echo "<div class='container'><div class='alert alert-danger'>Error: Jam keluar harus lebih besar dari jam masuk!</div></div>";
			exit;
		}

		// Instruksi Kerja Nomor 10 ($biaya_parkir)
		$biaya_parkir = hitung_parkir($durasi, $_POST['kendaraan']);

		// Instruksi Kerja Nomor 11 (hitung diskon dan simpan hasil akhir)
		$biaya_akhir = hitung_diskon($biaya_parkir, $_POST['member']);

		// Membuat array data parkir
		$dataParkir = array(
			'plat' => $_POST['plat'],
			'kendaraan' => $_POST['kendaraan'],
			'masuk' => $_POST['masuk'],
			'keluar' => $_POST['keluar'],
			'durasi' => $durasi,
			'member' => $_POST['member'],
			'biaya_akhir' => $biaya_akhir
		);

		// Instruksi Kerja Nomor 12 (menyimpan ke json)
		simpan_ke_json($dataParkir, "data/data.json");

		// Menampilkan hasil perhitungan
		tampilkan_hasil($dataParkir, $biaya_akhir);
	}
	?>

</body>
</html>