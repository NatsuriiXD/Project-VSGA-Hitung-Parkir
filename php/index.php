<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../assets/css/bootstrap.css">
	<title>Sistem Biaya Parkir Mall</title>
</head>

<body>
	<div class="container border p-4 mt-3">
		
		<!-- Menampilkan logo -->
		<div class="d-flex align-items-center mb-3">
			<img src="../assets/images/logo.png" alt="Logo Mall" class="img-fluid mr-2" style="max-width:60px;">
			<h2> Hitung Biaya Parkir Mall</h2>
		</div>

		<br>
		<form action="index.php" method="post" id="formPerhitungan">

			<!-- Masukan data plat nomor kendaraan -->
			<div class="row mb-2">
				<div class="col-lg-2"><label for="nama">Plat Nomor Kendaraan:</label></div>
				<div class="col-lg-2"><input type="text" id="plat" name="plat"></div>
			</div>

			<!-- Masukan pilihan jenis kendaraan -->
			<div class="row mb-2">
				<div class="col-lg-2"><label for="tipe">Jenis Kendaraan:</label></div>
				<div class="col-lg-2">
					<?php
					// membuat array truk,mobil,motor
					$kendaraan = array("Truk", "Motor", "Mobil");
					sort($kendaraan);
					foreach ($kendaraan as $jenis) {
						echo "<input type='radio' name='kendaraan' value='$jenis'> $jenis <br>";
					}
					?>
				</div>
			</div>

			<!-- Masukan Jam Keluar Kendaraan -->
			<div class="row mb-2">
				<div class="col-lg-2"><label for="nomor">Jam Keluar [jam]:</label></div>
				<div class="col-lg-2">
					<select id="keluar" name="keluar">
						<option value="">- Jam Keluar -</option>
						<?php
						for ($i = 1; $i <= 24; $i++) {
							echo "<option value='$i'>$i:00 </option>";
						}
						?>
					</select>
				</div>
			</div>

			<!-- Masukan Jam Masuk Kendaraan -->
			<div class="row mb-2">
				<div class="col-lg-2"><label for="nomor">Jam Masuk [jam]:</label></div>
				<div class="col-lg-2">
					<select id="masuk" name="masuk">
						<option value="">- Jam Masuk -</option>
						<?php
						for ($i = 1; $i <= 24; $i++) {
							echo "<option value='$i'>$i :00 </option>";
						}
						?>
					</select>
				</div>
			</div>

			<!-- Masukan pilihan Member -->
			<div class="row mb-2">
				<div class="col-lg-2"><label for="tipe">Keanggotaan:</label></div>
				<div class="col-lg-2">
					<input type='radio' name='member' value='Member'> Member <br>
					<input type='radio' name='member' value='Non-Member'> Non Member <br>
				</div>
			</div>

			<!-- Tombol Submit -->
			<div class="row">
				<div class="col-lg-2">
					<button class="btn btn-primary" type="submit" form="formPerhitungan" value="hitung" name="hitung">Hitung</button>
				</div>	
			</div>

		</form>
	</div>


	<?php
	/**
	 * Fungsi untuk menghitung biaya parkir berdasarkan
	 * jenis kendaraan dan durasi parkir.
	 * 
	 * @param int $durasi Jumlah jam parkir
	 * @param string $kendaraan Jenis kendaraan (Mobil, Motor, Truk)
	 * @return int Total biaya parkir sebelum diskon
	 */


	function hitung_parkir($durasi, $kendaraan) {
		if ($kendaraan == "Mobil") {
			if ($durasi <= 1) {
				return 5000;
			} else {
				return 5000 + (($durasi - 1) * 3000);
			}
		} elseif ($kendaraan == "Motor") {
			if ($durasi <= 1) {
				return 2000;
			} else {
				return 2000 + (($durasi - 1) * 1000);
			}
		} elseif ($kendaraan == "Truk") {
			return $durasi * 6000;
		}
		return 0;
	}

	if (isset($_POST['hitung'])) {
		$plat = $_POST['plat'];
		$kendaraan = $_POST['kendaraan'];
		$jamMasuk = $_POST['masuk'];
		$jamKeluar = $_POST['keluar'];
		$member = $_POST['member'];

		// hitung durasi
		$durasi = $jamKeluar - $jamMasuk;

		// hitung biaya parkir
		$biaya_parkir = hitung_parkir($durasi, $kendaraan);

		// diskon member
		if ($member == "Member") {
			$biaya_akhir = $biaya_parkir - ($biaya_parkir * 0.1);
		} else {
			$biaya_akhir = $biaya_parkir;
		}

		$dataParkir = array(
			'plat' => $plat,
			'kendaraan' => $kendaraan,
			'masuk' => $jamMasuk,
			'keluar' => $jamKeluar,
			'durasi' => $durasi,
			'member' => $member,
			'biaya' => $biaya_akhir
		);

		// menyimpan ke json
		$berkas = "../data/data.json";
		file_put_contents($berkas, json_encode($dataParkir));

		// Tampilkan hasil
		echo "
		<br/>
		<div class='container'>
			<div class='row'>
				<div class='col-lg-2'>Plat Nomor Kendaraan:</div>
				<div class='col-lg-2'>".$dataParkir['plat']."</div>
			</div>
			<div class='row'>
				<div class='col-lg-2'>Jenis Kendaraan:</div>
				<div class='col-lg-2'>".$dataParkir['kendaraan']."</div>
			</div>
			<div class='row'>
				<div class='col-lg-2'>Durasi Parkir:</div>
				<div class='col-lg-2'>".$dataParkir['durasi']." jam</div>
			</div>
			<div class='row'>
				<div class='col-lg-2'>Keanggotaan:</div>
				<div class='col-lg-2'>".$dataParkir['member']."</div>
			</div>
			<div class='row'>
				<div class='col-lg-2'>Total Biaya Parkir:</div>
				<div class='col-lg-2'>Rp".number_format($biaya_akhir, 0, ".", ".").",-</div>
			</div>
		</div>
		";
	}
	?>
</body>
</html>
