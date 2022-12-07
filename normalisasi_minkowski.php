<?php if (@$_GET['action'] === 'normalisasi_data'): ?>
	<?php
		$query = "SELECT * FROM nilai_siswa_minkowski ";
		$resultat = $bdd->query($query) or die(print_r($bdd->errorInfo()));
	
		$query_get_max_min 		= "SELECT 
									MAX(NILAI) AS 'NILAI_MAX',
									MIN(NILAI) AS 'NILAI_MIN',

									MAX(EXTRAKULIKULER) AS 'EXTRAKULIKULER_MAX',
									MIN(EXTRAKULIKULER) AS 'EXTRAKULIKULER_MIN', 

									MAX(PERILAKU) AS 'PERILAKU_MAX',
									MIN(PERILAKU) AS 'PERILAKU_MIN', 

									MAX(ABSENSI) AS 'ABSENSI_MAX',
									MIN(ABSENSI) AS 'ABSENSI_MIN'
								FROM nilai_siswa_minkowski ";
		$resultat_get_max_min 	= $bdd->query($query_get_max_min) or die(print_r($bdd->errorInfo()));
		$row_get_max_min 		= $resultat_get_max_min->fetch();

		$nilai_max 				= $row_get_max_min['NILAI_MAX'];
		$nilai_min 				= $row_get_max_min['NILAI_MIN'];

		$extrakulikuler_max		= $row_get_max_min['EXTRAKULIKULER_MAX'];
		$extrakulikuler_min		= $row_get_max_min['EXTRAKULIKULER_MIN'];

		$prilaku_max			= $row_get_max_min['PERILAKU_MAX'];
		$prilaku_min			= $row_get_max_min['PERILAKU_MIN'];

		$absensi_max			= $row_get_max_min['ABSENSI_MAX'];
		$absensi_min			= $row_get_max_min['ABSENSI_MIN'];

		$new_max				= 0.9;
		$new_min				= 0.3;


		while ($row = $resultat->fetch()) { 
			$id 								= $row['ID_NILAI'];
			$hasil_normalisasi_nilai			= ($row['NILAI']-$nilai_min)*($new_max-$new_min)/($nilai_max-$nilai_min)+$new_min;
			$hasil_normalisasi_extrakulikuler	= ($row['EXTRAKULIKULER']-$extrakulikuler_min)*($new_max-$new_min)/($extrakulikuler_max-$extrakulikuler_min)+$new_min;
			$hasil_normalisasi_prilaku			= ($row['PERILAKU']-$prilaku_min)*($new_max-$new_min)/($prilaku_max-$prilaku_min)+$new_min;
			$hasil_normalisasi_absensi			= ($row['ABSENSI']-$absensi_min)*($new_max-$new_min)/($absensi_max-$absensi_min)+$new_min;
		

			$query_save = "UPDATE `nilai_siswa_minkowski` SET `NILAI_NORMALISASI`=ROUND('$hasil_normalisasi_nilai', 2),`EXTRAKULIKULER_NORMALISASI`=ROUND('$hasil_normalisasi_extrakulikuler', 2),`PERILAKU_NORMALISASI`=ROUND('$hasil_normalisasi_prilaku', 2),`ABSENSI_NORMALISASI`=ROUND('$hasil_normalisasi_absensi', 2) WHERE `ID_NILAI`='$id'";
		    $cek = $bdd->query($query_save) or die(print_r($bdd->errorInfo()));
		    if($cek):
		      echo "<script language='javascript'>swal('Selamat...', 'Data Berhasil di input!', 'success');</script>" ;
		    endif;
		}
	?>			

	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="index.html">Home</a>
				</li>
				<li class="active">Normalisasi Data</li>
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
			<a href="?hal=perhitungan_minkowski&action=hitung_ulang">
				<button style="margin-bottom: 20px;" class="width-30 pull-left btn btn-sm btn-success">
					<i class="ace-icon fa fa-refresh"></i>
					<span class="bigger-110">Proses Perhitungan K-Means</span>
				</button>
			</a>
			<br>

			<?php
				$nilai_rata_rata = array();
			?>

			<table class="table table-bordered small datatablesku">
				<thead>
					<tr bgcolor="#e0ebeb">
						<th>No</th>
						<th>NAMA</th>
						<th>NILAI KKM</th>
						<th>EXTRAKULIKULER</th>
						<th>PERILAKU</th>
						<th>ABSENSI</th>
						<th>RATA</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$query = "SELECT * FROM nilai_siswa_minkowski ";
						$resultat = $bdd->query($query) or die(print_r($bdd->errorInfo()));
						$bantu = 1;

						while ($row = $resultat->fetch()) { 
						
							echo "<tr>";
								echo "<td>$bantu</td>";
								echo "<td>".$row['NAMA']."</td>";
								echo "<td>".$row['NILAI_NORMALISASI']."</td>";
								echo "<td>".$row['EXTRAKULIKULER_NORMALISASI']."</td>";
								echo "<td>".$row['PERILAKU_NORMALISASI']."</td>";
								echo "<td>".$row['ABSENSI_NORMALISASI']."</td>";
								echo "<td>".
									(($row['NILAI_NORMALISASI']+$row['EXTRAKULIKULER_NORMALISASI']+$row['PERILAKU_NORMALISASI']+$row['ABSENSI_NORMALISASI'])/4)
								."</td>";
								$bantu++;
							echo "</tr>";

							array_push($nilai_rata_rata, (($row['NILAI_NORMALISASI']+$row['EXTRAKULIKULER_NORMALISASI']+$row['PERILAKU_NORMALISASI']+$row['ABSENSI_NORMALISASI'])/4));
						}
						sort($nilai_rata_rata);
					?>
				</tbody>
			</table>
			<br>
			<a href="javascript:void(0)">
				<button style="margin-bottom: 20px;" class="width-30 pull-left btn btn-sm btn-success">
					<i class="ace-icon fa fa-refresh"></i>
					<span class="bigger-110">Nilai Minimun (C-3) : <?= $nilai_rata_rata[0] ?></span>
				</button>
			</a>

			<a href="javascript:void(0)">
				<button style="margin-bottom: 20px;" class="width-30 pull-left btn btn-sm btn-info">
					<i class="ace-icon fa fa-refresh"></i>
					<span class="bigger-110">Nilai Tengah (C-2) : <?= $nilai_rata_rata[count($nilai_rata_rata)/2] ?></span>
				</button>
			</a>

			<a href="javascript:void(0)">
				<button style="margin-bottom: 20px;" class="width-30 pull-left btn btn-sm btn-primary">
					<i class="ace-icon fa fa-refresh"></i>
					<span class="bigger-110">Nilai Maximum (C-1) : <?= $nilai_rata_rata[count($nilai_rata_rata)-1] ?></span>
				</button>
			</a>
			<br>
		</div>
	</div>
<?php endif ?>