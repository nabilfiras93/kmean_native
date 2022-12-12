<?php 
  if (empty($_SESSION['username'])) {
    header("location:index.php");
  }
?>

<?php if (@$_GET['action'] === 'hitung_ulang'): ?>
	<?php
		$query_total_data = "SELECT COUNT(*) as 'SIZE' FROM nilai_siswa";
		$resultat_total_data = $bdd->query($query_total_data) or die(print_r($bdd->errorInfo()));

		$n_iterasi = 20;
		$n_data = $resultat_total_data->fetch()['SIZE'];
		$n_cluster = 3;
		$old_iterasi = array();
		
		for ($i=0; $i < $n_iterasi; $i++) {
	?>
			<div class="page-header">
				<h1>
					<small>
						Iterasi ke 
						<i class="ace-icon fa fa-angle-double-right"></i>
						<?php echo ($i+1) ?>
					</small>
				</h1>
			</div>
			<div style="margin: 15px 45px;">
	<?php
			$centroid = array();
			
			if ($i == 0) {
				$query = "SELECT * FROM nilai_siswa";
				$resultat = $bdd->query($query) or die(print_r($bdd->errorInfo()));
				$index_centroid = 1;
	?>
				<div class="page-header">
					<small>
						Centroid Awal 
					</small>
				</div>
				<table class = "table table-bordered small">
				<tr bgcolor="#578CA9">
				<th>CLUSTER</th>
				<th>NILAI</th>
				<th>PRESTASI</th>
				<th>PERILAKU</th>
				<th>ABSENSI</th>
			</tr>	
	<?php
				$cluster_ = 1;
				while ($row = $resultat->fetch()) {
					//Centroid awal
					if ($index_centroid == 35 or $index_centroid == 90 or $index_centroid == 262) {
						array_push($centroid, $row);
	?>
						<tr bgcolor="#e0ebeb">
							<th><?php echo 'CLUSTER '.$cluster_++; ?></th>
							<th><?php echo $row['NILAI_NORMALISASI'] ?></th>
							<th><?php echo $row['PRESTASI_NONAKADEMIK_NORMALISASI'] ?></th>
							<th><?php echo $row['PERILAKU_NORMALISASI'] ?></th>
							<th><?php echo $row['ABSENSI_NORMALISASI'] ?></th>
						</tr>
	<?php
					}
					$index_centroid++;
				}
	?>
				</table>
	<?php
			}else{
				//Menghitung centroid baru
	?>
				<div class="page-header">
					<small>
						Centroid Baru 
					</small>
				</div>
				<table class = "table table-bordered small">
				<tr bgcolor="#578CA9">
				<th>CLUSTER</th>
				<th>NILAI</th>
				<th>PRESTASI</th>
				<th>PERILAKU</th>
				<th>ABSENSI</th>
			</tr>	
	<?php
				for ($j=0; $j < $n_cluster; $j++) {
					$query_centroid = "SELECT AVG(NILAI_NORMALISASI) as 'NILAI_NORMALISASI', AVG(PRESTASI_NONAKADEMIK_NORMALISASI) as 'PRESTASI_NONAKADEMIK_NORMALISASI', AVG(PERILAKU_NORMALISASI) as 'PERILAKU_NORMALISASI', AVG(ABSENSI_NORMALISASI) as 'ABSENSI_NORMALISASI' FROM nilai_siswa WHERE CLUSTER = 'CLUSTER-".($j+1)."'";
					$resultat_centroid = $bdd->query($query_centroid) or die(print_r($bdd->errorInfo()));
					while ($row_centroid = $resultat_centroid->fetch()) {
						array_push($centroid, $row_centroid);

						$update_nilai = $row_centroid['NILAI_NORMALISASI'] ?? 0;
						$update_ext = $row_centroid['PRESTASI_NONAKADEMIK_NORMALISASI'] ?? 0;
						$update_perilaku = $row_centroid['PERILAKU_NORMALISASI'] ?? 0;
						$update_absensi = $row_centroid['ABSENSI_NORMALISASI'] ?? 0;

						$query_update = "UPDATE `centroid` SET `NILAI`= $update_nilai,`PRESTASI_NONAKADEMIK`= $update_ext, `PERILAKU`= $update_perilaku,`ABSENSI`= $update_absensi WHERE `ID_CENTROID` = $j";
						$bdd->query($query_update) or die(print_r($bdd->errorInfo()));
	?>
						<tr bgcolor="#e0ebeb">
							<th><?php echo 'CLUSTER '.($j+1); ?></th>
							<th><?php echo $row_centroid['NILAI_NORMALISASI'] ?></th>
							<th><?php echo $row_centroid['PRESTASI_NONAKADEMIK_NORMALISASI'] ?></th>
							<th><?php echo $row_centroid['PERILAKU_NORMALISASI'] ?></th>
							<th><?php echo $row_centroid['ABSENSI_NORMALISASI'] ?></th>
						</tr>
	<?php
					}
				}
	?>
			</table>
	<?php
			}
			$query = "SELECT * FROM nilai_siswa";
			$resultat = $bdd->query($query) or die(print_r($bdd->errorInfo()));
	?>
			<div class="page-header">
				<small>
					Hasil Cluster
				</small>
			</div>
			<table class = "table table-bordered small datatablesku">
				<thead>
					<tr bgcolor="#578CA9">
						<th>No</th>
						<th>NISN</th>
						<th>NAMA</th>
						<th>NILAI</th>
						<th>PRESTASI</th>
						<th>PERILAKU</th>
						<th>ABSENSI</th>
						<th>CLUSTER 1</th>
						<th>CLUSTER 2</th>
						<th>CLUSTER 3</th>
						<th>CLUSTER</th>
					</tr>
				</thead>
			<tbody>
			<?php
				$no = 1;
				while ($row = $resultat->fetch()) {
					$temp_cluster = array();
					for ($j=0; $j < $n_cluster; $j++) {
						$nilai_cluster = sqrt(pow(($row['NILAI_NORMALISASI']-$centroid[$j]['NILAI_NORMALISASI']), 2)+pow(($row['PRESTASI_NONAKADEMIK_NORMALISASI']-$centroid[$j]['PRESTASI_NONAKADEMIK_NORMALISASI']), 2)+pow(($row['PERILAKU_NORMALISASI']-$centroid[$j]['PERILAKU_NORMALISASI']), 2)+pow(($row['ABSENSI_NORMALISASI']-$centroid[$j]['ABSENSI_NORMALISASI']), 2));
						$temp_cluster['CLUSTER-'.($j+1)] = $nilai_cluster;
					}

					$my_cluster = array($temp_cluster['CLUSTER-1'], $temp_cluster['CLUSTER-2'], $temp_cluster['CLUSTER-3']);
					sort($my_cluster);


					$cluster = '';
					foreach ($temp_cluster as $key => $value) {
						if ($value == $my_cluster[0]) {
							$cluster = $key;
							break;
						}
					}

		?>
					<tr bgcolor="#e0ebeb">
						<th><?php echo $no++; ?></th>
						<th><?php echo $row['NISN'] ?></th>
						<th><?php echo $row['NAMA'] ?></th>
						<th><?php echo $row['NILAI_NORMALISASI'] ?></th>
						<th><?php echo $row['PRESTASI_NONAKADEMIK_NORMALISASI'] ?></th>
						<th><?php echo $row['PERILAKU_NORMALISASI'] ?></th>
						<th><?php echo $row['ABSENSI_NORMALISASI'] ?></th>
						<th><?php echo $temp_cluster['CLUSTER-1'] ?></th>
						<th><?php echo $temp_cluster['CLUSTER-2'] ?></th>
						<th><?php echo $temp_cluster['CLUSTER-3'] ?></th>
						<th><?php echo $cluster ?></th>
					</tr>
		<?php

					$id_nilai =  $row['ID_NILAI'];
					$query_update = "UPDATE `nilai_siswa` SET `CLUSTER`= '$cluster' WHERE `ID_NILAI` = $id_nilai";
					$bdd->query($query_update) or die(print_r($bdd->errorInfo()));
				}
		?>
			</tbody>
		</table>
	<?php

			if ($i <= 0) {
				for ($k=0; $k < $n_cluster; $k++) { 
					$query_old_iterasi = "SELECT `ID_NILAI`, `CLUSTER` FROM `nilai_siswa`WHERE `CLUSTER` = 'CLUSTER-".($k+1)."'";
					$resultat_old_iterasi = $bdd->query($query_old_iterasi) or die(print_r($bdd->errorInfo()));
					
					while ($row = $resultat_old_iterasi->fetch()) {
						$old_iterasi[$row['ID_NILAI']] = $row['CLUSTER'];
					}
				}
			}else{
				$check = true;

				for ($k=0; $k < $n_cluster; $k++) { 
					$query_old_iterasi = "SELECT `ID_NILAI`, `CLUSTER` FROM `nilai_siswa`WHERE `CLUSTER` = 'CLUSTER-".($k+1)."'";
					$resultat_old_iterasi = $bdd->query($query_old_iterasi) or die(print_r($bdd->errorInfo()));
					while ($row = $resultat_old_iterasi->fetch()) {
						if($old_iterasi[$row['ID_NILAI']] != $row['CLUSTER']){
							$check = false;
							$k = $k + $n_cluster+1;
							break;
						}
					}
				}

				if ($check == true) {				
					$i = $n_iterasi+1;
				}else{
					$old_iterasi = array();
					for ($k=0; $k < $n_cluster; $k++) { 
					$query_old_iterasi = "SELECT `ID_NILAI`, `CLUSTER` FROM `nilai_siswa`WHERE `CLUSTER` = 'CLUSTER-".($k+1)."'";
					$resultat_old_iterasi = $bdd->query($query_old_iterasi) or die(print_r($bdd->errorInfo()));
					
					while ($row = $resultat_old_iterasi->fetch()) {
						$old_iterasi[$row['ID_NILAI']] = $row['CLUSTER'];
					}
				}
			}
		}
	?>
			</div>
	<?php
		}
	?>
	<div class="page-header">
		<center><large>
					Centroid Terakhir 
					</large></center>
					
				</div>
		
				<div class="container">
				<table class = "table table-bordered small">
				<tr bgcolor="#578CA9">
				<th>CLUSTER</th>
				<th>NILAI</th>
				<th>PRESTASI</th>
				<th>PERILAKU</th>
				<th>ABSENSI</th>
			</tr>	
	<?php
				for ($j=0; $j < $n_cluster; $j++) {
					$query_centroid = "SELECT AVG(NILAI_NORMALISASI) as 'NILAI_NORMALISASI', AVG(PRESTASI_NONAKADEMIK_NORMALISASI) as 'PRESTASI_NONAKADEMIK_NORMALISASI', AVG(PERILAKU_NORMALISASI) as 'PERILAKU_NORMALISASI', AVG(ABSENSI_NORMALISASI) as 'ABSENSI_NORMALISASI' FROM nilai_siswa WHERE CLUSTER = 'CLUSTER-".($j+1)."'";
					$resultat_centroid = $bdd->query($query_centroid) or die(print_r($bdd->errorInfo()));
					while ($row_centroid = $resultat_centroid->fetch()) {
						array_push($centroid, $row_centroid);

						$update_nilai = $row_centroid['NILAI_NORMALISASI'];
						$update_ext = $row_centroid['PRESTASI_NONAKADEMIK_NORMALISASI'];
						$update_perilaku = $row_centroid['PERILAKU_NORMALISASI'];
						$update_absensi = $row_centroid['ABSENSI_NORMALISASI'];

						$query_update = "UPDATE `centroid` SET `NILAI`= $update_nilai,`PRESTASI_NONAKADEMIK`= $update_ext, `PERILAKU`= $update_perilaku,`ABSENSI`= $update_absensi WHERE `ID_CENTROID` = $j";
						$bdd->query($query_update) or die(print_r($bdd->errorInfo()));
	?>
						<tr bgcolor="#e0ebeb">
							<th><?php echo 'CLUSTER '.($j+1); ?></th>
							<th><?php echo $row_centroid['NILAI_NORMALISASI'] ?></th>
							<th><?php echo $row_centroid['PRESTASI_NONAKADEMIK_NORMALISASI'] ?></th>
							<th><?php echo $row_centroid['PERILAKU_NORMALISASI'] ?></th>
							<th><?php echo $row_centroid['ABSENSI_NORMALISASI'] ?></th>
						</tr>
	<?php
					}
				}
	?>
			</table>

</div>
<?php else: ?>
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="index.html">Home</a>
				</li>
				<li class="active">Perhitungan K-Means</li>
			</ul>
			<div class="nav-search" id="nav-search">
				<form class="form-search">
					<span class="input-icon">
						<input placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" type="text">
						<i class="ace-icon fa fa-search nav-search-icon"></i>
					</span>
				</form>
			</div><!-- /.nav-search -->
		</div>
		<div style="margin: 15px 45px;">
			<a href="?hal=normalisasi&action=normalisasi_data">
				<button style="margin-bottom: 20px;" class="width-30 pull-left btn btn-sm">
					<i class="ace-icon fa fa-refresh"></i>
					<span class="bigger-110">Proses Normalisasi Data</span>
				</button>
			</a>
			<br><br><br>
			<h3><center>HASIL PROSES PERHITUNGAN</center></h3>
			<div class="w3-bar w3-black">
			  <button class="w3-bar-item w3-button" onclick="openCity('Semua')">Semua Data</button>
			  <button class="w3-bar-item w3-button" onclick="openCity('Tinggi')">Kategori Siswa Tinggi</button>
			  <button class="w3-bar-item w3-button" onclick="openCity('Sedang')">Kategori Siswa Sedang</button>
			  <button class="w3-bar-item w3-button" onclick="openCity('Rendah')">Kategori Siswa Rendah</button>
			</div>

			<div id="Semua" class="w3-container city">
			  	<h2>Semua Kategori</h2>
				<table class="table table-bordered small datatablesku">
					<thead>
						<tr bgcolor="#e0ebeb">
							<th>No</th>
							<th>NISN</th>
							<th>NAMA</th>
							<th>NILAI KKM</th>
							<th>PRESTASI</th>
							<th>PERILAKU</th>
							<th>ABSENSI</th>
							<th>CLUSTER</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$query = "SELECT * FROM nilai_siswa";
							$resultat = $bdd->query($query) or die(print_r($bdd->errorInfo()));
							$bantu = 1;

							while ($row = $resultat->fetch()) { 
							
								echo "<tr>";
									echo "<td>$bantu</td>";
									echo "<td>".$row['NISN']."</td>";
									echo "<td>".$row['NAMA']."</td>";
									echo "<td>".$row['NILAI']."</td>";
									echo "<td>".$row['PRESTASI_NONAKADEMIK']."</td>";
									echo "<td>".$row['PERILAKU']."</td>";
									echo "<td>".$row['ABSENSI']."</td>";
									echo "<td>";
									if ($row['CLUSTER'] == 'CLUSTER-1') {
										echo "TINGGI";
									}else if ($row['CLUSTER'] == 'CLUSTER-2') {
										echo "SEDANG";
									}else if ($row['CLUSTER'] == 'CLUSTER-3') {
										echo "RENDAH";
									}
									echo "</td>";
									$bantu++;
								echo "</tr>";
							}
						?>
					</tbody>
				</table>
			</div>

			<div id="Tinggi" class="w3-container city" style="display:none">
			  <h2>Kategori Siswa Tinggi</h2>
				  <table class="table table-bordered small datatablesku">
					<thead>
						<tr bgcolor="#e0ebeb">
							<th>No</th>
							<th>NISN</th>
							<th>NAMA</th>
							<th>NILAI KKM</th>
							<th>PRESTASI</th>
							<th>PERILAKU</th>
							<th>ABSENSI</th>
							<th>CLUSTER</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$query = "SELECT * FROM nilai_siswa WHERE CLUSTER='CLUSTER-1'";
							$resultat = $bdd->query($query) or die(print_r($bdd->errorInfo()));
							$bantu = 1;

							while ($row = $resultat->fetch()) { 
							
								echo "<tr>";
									echo "<td>$bantu</td>";
									echo "<td>".$row['NISN']."</td>";
									echo "<td>".$row['NAMA']."</td>";
									echo "<td>".$row['NILAI']."</td>";
									echo "<td>".$row['PRESTASI_NONAKADEMIK']."</td>";
									echo "<td>".$row['PERILAKU']."</td>";
									echo "<td>".$row['ABSENSI']."</td>";
									echo "<td>";
									if ($row['CLUSTER'] == 'CLUSTER-1') {
										echo "TINGGI";
									}else if ($row['CLUSTER'] == 'CLUSTER-2') {
										echo "SEDANG";
									}else if ($row['CLUSTER'] == 'CLUSTER-3') {
										echo "RENDAH";
									}
									echo "</td>";
									$bantu++;
								echo "</tr>";
							}
						?>
					</tbody>
				</table>
			</div>

			<div id="Sedang" class="w3-container city" style="display:none">
			  	<h2>Kategori Siswa Sedang</h2>
			  	<table class="table table-bordered small datatablesku">
					<thead>
						<tr bgcolor="#e0ebeb">
							<th>No</th>
							<th>NISN</th>
							<th>NAMA</th>
							<th>NILAI KKM</th>
							<th>PRESTASI</th>
							<th>PERILAKU</th>
							<th>ABSENSI</th>
							<th>CLUSTER</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$query = "SELECT * FROM nilai_siswa WHERE CLUSTER='CLUSTER-2'";
							$resultat = $bdd->query($query) or die(print_r($bdd->errorInfo()));
							$bantu = 1;

							while ($row = $resultat->fetch()) { 
							
								echo "<tr>";
									echo "<td>$bantu</td>";
									echo "<td>".$row['NISN']."</td>";
									echo "<td>".$row['NAMA']."</td>";
									echo "<td>".$row['NILAI']."</td>";
									echo "<td>".$row['PRESTASI_NONAKADEMIK']."</td>";
									echo "<td>".$row['PERILAKU']."</td>";
									echo "<td>".$row['ABSENSI']."</td>";
									echo "<td>";
									if ($row['CLUSTER'] == 'CLUSTER-1') {
										echo "TINGGI";
									}else if ($row['CLUSTER'] == 'CLUSTER-2') {
										echo "SEDANG";
									}else if ($row['CLUSTER'] == 'CLUSTER-3') {
										echo "RENDAH";
									}
									echo "</td>";
									$bantu++;
								echo "</tr>";
							}
						?>
					</tbody>
				</table>
			</div>

			<div id="Rendah" class="w3-container city" style="display:none">
			  	<h2>Kategori Siswa Rendah</h2>
			  	<table class="table table-bordered small datatablesku">
					<thead>
						<tr bgcolor="#e0ebeb">
							<th>No</th>
							<th>NISN</th>
							<th>NAMA</th>
							<th>NILAI KKM</th>
							<th>PRESTASI</th>
							<th>PERILAKU</th>
							<th>ABSENSI</th>
							<th>CLUSTER</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$query = "SELECT * FROM nilai_siswa WHERE CLUSTER='CLUSTER-3'";
							$resultat = $bdd->query($query) or die(print_r($bdd->errorInfo()));
							$bantu = 1;

							while ($row = $resultat->fetch()) { 
							
								echo "<tr>";
									echo "<td>$bantu</td>";
									echo "<td>".$row['NISN']."</td>";
									echo "<td>".$row['NAMA']."</td>";
									echo "<td>".$row['NILAI']."</td>";
									echo "<td>".$row['PRESTASI_NONAKADEMIK']."</td>";
									echo "<td>".$row['PERILAKU']."</td>";
									echo "<td>".$row['ABSENSI']."</td>";
									echo "<td>";
									if ($row['CLUSTER'] == 'CLUSTER-1') {
										echo "TINGGI";
									}else if ($row['CLUSTER'] == 'CLUSTER-2') {
										echo "SEDANG";
									}else if ($row['CLUSTER'] == 'CLUSTER-3') {
										echo "RENDAH";
									}
									echo "</td>";
									$bantu++;
								echo "</tr>";
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php endif ?>