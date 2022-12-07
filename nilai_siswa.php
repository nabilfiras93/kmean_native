<?php 
  if (empty($_SESSION['username'])) {
    header("location:index.php");
  }
?>

<div class="main-content-inner">
	<div class="breadcrumbs ace-save-state" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-home home-icon"></i>
				<a href="index.html">Home</a>
			</li>
			<li class="active">Data Siswa</li>
		</ul><!-- /.breadcrumb -->
<?php
  if(isset($_POST['simpan'])){
    $nisn = $_POST['NISN'];
    $id_admin = $_SESSION['id_admin'];
    $nama_siswa = $_POST['NAMA'];
    $nilai_siswa = $_POST['NILAI'];
    $extra = $_POST['EXT'];
    $prilaku = $_POST['PERILAKU'];
    $absensi = $_POST['ABSENSI'];
    $query = "INSERT INTO `nilai_siswa`(`ID_ADMIN`,`NISN`,`NAMA`, `NILAI`, `EXTRAKULIKULER`, `PERILAKU`, `ABSENSI`) VALUES ('$id_admin','$nisn', '$nama_siswa', '$nilai_siswa', '$extra', '$prilaku', '$absensi')";
    $cek = $bdd->query($query) or die(print_r($bdd->errorInfo()));

    if($cek):
      echo "<script language='javascript'>swal('Selamat...', 'Data Berhasil di input!', 'success');</script>" ;
      echo '<meta http-equiv="Refresh" content="3; URL=dashboard.php?hal=nilai_siswa">';
    endif;
  }

  if(isset($_POST['update'])){
    $id = $_POST['ID_NILAI'];
    $nisn = $_POST['NISN'];
 	  $nama_siswa = $_POST['NAMA'];
    $nilai_siswa = $_POST['NILAI'];
    $extra = $_POST['EXT'];
    $prilaku = $_POST['PERILAKU'];
    $absensi = $_POST['ABSENSI'];
    $query = "UPDATE `nilai_siswa` SET `NISN`='$nisn', `NAMA`='$nama_siswa',`NILAI`='$nilai_siswa',`EXTRAKULIKULER`='$extra',`PERILAKU`='$prilaku',`ABSENSI`='$absensi' WHERE `ID_NILAI`='$id'";
    $cek = $bdd->query($query) or die(print_r($bdd->errorInfo()));
    if($cek):
      echo "<script language='javascript'>swal('Selamat...', 'Data Berhasil di input!', 'success');</script>" ;
    endif;
  }

  if(isset($_POST['hapus'])){
   	$id=$_POST['ID_NILAI'];
    $query = "DELETE FROM nilai_siswa WHERE ID_NILAI='$id'";
    $cek = $bdd->query($query) or die(print_r($bdd->errorInfo()));

    if($cek):
      echo "<script language='javascript'>swal('Selamat...', 'Data Berhasil di hapus!', 'success');</script>" ;
    endif;
  }

?>
<div class="container">
  <div class="panel panel-danger col-md-12">
    <div class="panel-body">
      <!-- Modal -->
	    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
	   <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
	   <hr>
     <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Tambah Data</h3>
          </div>
          <div class="modal-body">
			       <form action="" method="POST" role="form">
               <div class="phAnimate">
                  <label for="id_nisn">NISN</label>
                  <input type="text" name="NISN" class="form-control" required="required">
              </div>
              <div class="phAnimate">
                  <label for="id_siswa">Nama</label>
                  <input type="text" name="NAMA" class="form-control" required="required">
              </div>
              <div class="phAnimate">
                  <label for="id_siswa">Nilai KKM</label>
                  <input type="number" name="NILAI" class="form-control" required="required">
              </div>
              <div class="phAnimate">
                  <label for="id_siswa">Prestasi</label>
                  <select name="EXT" class="form-control" required="required">
                    <option value="">-= Pilih =-</option>
                    <option value="4">Juara Matematika</option>
                    <option value="3">Juara Teknologi</option>
                    <option value="2">Juara MTQ</option>
                    <option value="1">Juara Olahraga</option>
                  </select>
              </div>
              <div class="phAnimate">
                  <label for="id_siswa">Prilaku</label>
                  <select name="PERILAKU" class="form-control" required="required">
                    <option value="">-= Pilih =-</option>
                    <option value="4">A</option>
                    <option value="3">B</option>
                    <option value="2">C</option>
                    <option value="1">D</option>
                  </select>
              </div>
              <div class="phAnimate">
                  <label for="id_siswa">Absen</label>
                  <select name="ABSENSI" class="form-control" required="required">
                    <option value="">-= Pilih =-</option>
                    <option value="4">A</option>
                    <option value="3">B</option>
                    <option value="2">C</option>
                    <option value="1">D</option>
                  </select>
              </div> 
              <div class="modal-footer">
                  <button type="button" class="btn btn-default glyphicon glyphicon-chevron-left" data-dismiss="modal"></button>
                  <button type="submit" name="simpan" class="btn btn-info glyphicon glyphicon-ok"></button>
              </div>
            </form>
        </div>
      </div>
     </div>
    </div> 
    <!-- Tutup modal -->
    
    <!-- Table data -->
    <table class="table table-bordered data datatablesku">
      <thead>
        <tr>
          <th>NO</th>
          <th>NISN</th>
          <th>NAMA</th>
          <th>NILAI KKM</th>
          <th>PRESTASI</th>
          <th>PERILAKU</th>
          <th>ABSENSI</th>
          <th>Aksi</th>
        </tr>       
      </thead>
      <tbody>
        <?php
          $query = "SELECT * FROM nilai_siswa";
          $resultat = $bdd->query($query);

          $no = 1;
          while($data = $resultat->fetch()){
        ?>
        <tr>
          <td><?php echo $no++;?></td>
          <td><?php echo $data['NISN'];?></td>
          <td><?php echo $data['NAMA'];?></td>
          <td><?php echo $data['NILAI'];?></td>
          <td><?php echo $data['EXTRAKULIKULER'];?></td>
          <td><?php echo $data['PERILAKU'];?></td>
          <td><?php echo $data['ABSENSI'];?></td>
          <td>
            <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#my<?php echo $data['ID_NILAI'];?>">
            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
            <!-- Mdal edit -->
            <div class="modal fade" id="my<?php echo $data['ID_NILAI'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      		         <h3 class="modal-title" id="myModalLabel">Edit Data</h3>
                  </div>
                  <div class="modal-body">
                    <form action="" method="POST" role="form">
                      <input type="hidden" name="ID_NILAI" value="<?php echo $data['ID_NILAI'] ?>" class="form-control">
                     <div class="phAnimate">
                        <label for="id_nisn">NISN</label>
                        <input type="text" name="NISN" class="form-control" required="required">
                    </div>
                     <div class="phAnimate">
                        <label for="id_siswa">Nama</label>
                        <input type="text" name="NAMA" value="<?php echo $data['NAMA'] ?>" class="form-control" required="required">
                    </div>
                    <div class="phAnimate">
                        <label for="id_siswa">Nilai KKM</label>
                        <input type="number" name="NILAI" value="<?php echo $data['NILAI'] ?>" class="form-control" required="required">
                    </div>
                    <div class="phAnimate">
                        <label for="id_siswa">Prestasi</label>
                        <select name="EXT" class="form-control" required="required">
                          <option value="">-= Pilih =-</option>
                          <option <?= $data['EXTRAKULIKULER'] == 4 ? 'selected="selected"' : '' ?> value="4">Juara Matematika</option>
                          <option <?= $data['EXTRAKULIKULER'] == 3 ? 'selected="selected"' : '' ?> value="3">Juara Teknologi</option>
                          <option <?= $data['EXTRAKULIKULER'] == 2 ? 'selected="selected"' : '' ?> value="2">Juara MTQ</option>
                          <option <?= $data['EXTRAKULIKULER'] == 1 ? 'selected="selected"' : '' ?> value="1">Juara Olahraga</option>
                        </select>
                    </div>
                    <div class="phAnimate">
                        <label for="id_siswa">Prilaku</label>
                        <select name="PERILAKU" class="form-control" required="required">
                          <option value="">-= Pilih =-</option>
                          <option <?= $data['PERILAKU'] == 4 ? 'selected="selected"' : '' ?> value="4">A</option>
                          <option <?= $data['PERILAKU'] == 3 ? 'selected="selected"' : '' ?> value="3">B</option>
                          <option <?= $data['PERILAKU'] == 2 ? 'selected="selected"' : '' ?> value="2">C</option>
                          <option <?= $data['PERILAKU'] == 1 ? 'selected="selected"' : '' ?> value="1">D</option>
                        </select>
                    </div>
                    <div class="phAnimate">
                        <label for="id_siswa">Absen</label>
                        <select name="ABSENSI" class="form-control" required="required">
                          <option value="">-= Pilih =-</option>
                          <option <?= $data['ABSENSI'] == 4 ? 'selected="selected"' : '' ?> value="4">A</option>
                          <option <?= $data['ABSENSI'] == 3 ? 'selected="selected"' : '' ?> value="3">B</option>
                          <option <?= $data['ABSENSI'] == 2 ? 'selected="selected"' : '' ?> value="2">C</option>
                          <option <?= $data['ABSENSI'] == 1 ? 'selected="selected"' : '' ?> value="1">D</option>
                        </select>
                    </div> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default glyphicon glyphicon-chevron-left" data-dismiss="modal"></button>
                        <button type="submit" name="update" class="btn btn-info glyphicon glyphicon-ok"></button>
                    </div>
                  </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal Hapus-->
            <button type="button" class="btn btn-xs btn btn-danger" data-toggle="modal" data-target="#myy<?php echo $data['ID_NILAI']; ?>">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
            <div class="modal fade" id="myy<?php echo $data['ID_NILAI'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="myModalLabel">Delete</h3>
                  </div>
                  <div class="modal-body">
                    <form action="" method="POST" role="form">
                      <div class="phAnimate">
                        <label for="ID_NILAI">Kode Nilai</label>
                        <input type="text" name="ID_NILAI" class="form-control" placeholder="input id" value="<?php echo $data['ID_NILAI']; ?>" readonly="" style="color:red">
                      </div>
                      <div class="phAnimate">
                        <label for="NAMA">Nama siswa</label>
                        <input type="text" name="NAMA" class="form-control" placeholder="input name" value="<?php echo $data['NAMA']; ?>">
                      </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default glyphicon glyphicon-chevron-left" data-dismiss="modal"></button>
                    <button type="submit" name="hapus" class="btn btn-danger glyphicon glyphicon-ok"></button>
                  </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- tutup modal hapus -->
        </tr>
        <?php  
          }
        ?>
      </tbody>
    </table>

    <div class="footer">
      <div class="footer-inner">
        <div class="footer-content">
          <span class="bigger-120">
            <span class="blue bolder">MI.DARMA</span>
            Application &copy; 2022
            </span>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>