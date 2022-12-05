<?php 
  if (empty($_SESSION['username'])) {
    header("location:index.php");
  }
?>


<script type="text/javascript">
  <?php
    $query = "SELECT * FROM `centroid`";
    $resultat = $bdd->query($query) or die(print_r($bdd->errorInfo()));
    $index_centroid_cek_nilai = 0;
    while ($row = $resultat->fetch()) {
      echo "var nilai_$index_centroid_cek_nilai = ".$row['NILAI'].";";
      echo "var ext_$index_centroid_cek_nilai = ".$row['EXTRAKULIKULER'].";";
      echo "var perilaku_$index_centroid_cek_nilai = ".$row['PERILAKU'].";";
      echo "var absensi_$index_centroid_cek_nilai = ".$row['ABSENSI'].";";
      $index_centroid_cek_nilai++;
    }
  
    $query_get_max_min    = "SELECT 
                  MAX(NILAI) AS 'NILAI_MAX',
                  MIN(NILAI) AS 'NILAI_MIN',

                  MAX(EXTRAKULIKULER) AS 'EXTRAKULIKULER_MAX',
                  MIN(EXTRAKULIKULER) AS 'EXTRAKULIKULER_MIN', 

                  MAX(PERILAKU) AS 'PERILAKU_MAX',
                  MIN(PERILAKU) AS 'PERILAKU_MIN', 

                  MAX(ABSENSI) AS 'ABSENSI_MAX',
                  MIN(ABSENSI) AS 'ABSENSI_MIN'
                FROM nilai_siswa";
    $resultat_get_max_min   = $bdd->query($query_get_max_min) or die(print_r($bdd->errorInfo()));
    $row_get_max_min    = $resultat_get_max_min->fetch();
  ?>

  var nilai_max             = <?= $row_get_max_min['NILAI_MAX']; ?>;
  var nilai_min             = <?= $row_get_max_min['NILAI_MIN']; ?>;

  var extrakulikuler_max    = <?= $row_get_max_min['EXTRAKULIKULER_MAX']; ?>;
  var extrakulikuler_min    = <?= $row_get_max_min['EXTRAKULIKULER_MIN']; ?>;

  var prilaku_max           = <?= $row_get_max_min['PERILAKU_MAX']; ?>;
  var prilaku_min           = <?= $row_get_max_min['PERILAKU_MIN']; ?>;

  var absensi_max           = <?= $row_get_max_min['ABSENSI_MAX']; ?>;
  var absensi_min           = <?= $row_get_max_min['ABSENSI_MIN']; ?>;

  var new_max             = 0.9;
  var new_min             = 0.3;

  $(document).ready(function() {
    $('#cek_nilai').submit(function (event) {
      check();
      return false;
    });
  });

  function check() {
    var nilai_form =  (document.getElementById('nilai').value-nilai_min)*(new_max-new_min)/(nilai_max-nilai_min)+new_min;
    var ext_form =  (document.getElementById('ext').value-extrakulikuler_min)*(new_max-new_min)/(extrakulikuler_max-extrakulikuler_min)+new_min;
    var perilaku_form = (document.getElementById('perilaku').value-prilaku_min)*(new_max-new_min)/(prilaku_max-prilaku_min)+new_min;
    var absensi_form = (document.getElementById('absensi').value-absensi_min)*(new_max-new_min)/(absensi_max-absensi_min)+new_min;

    var claster_1 = Math.sqrt((Math.pow((nilai_form-nilai_0), 2)+Math.pow((ext_form-ext_0), 2)+Math.pow((perilaku_form-perilaku_0), 2)+Math.pow((absensi_form-absensi_0), 2)));
    var claster_2 = Math.sqrt((Math.pow((nilai_form-nilai_1), 2)+Math.pow((ext_form-ext_1), 2)+Math.pow((perilaku_form-perilaku_1), 2)+Math.pow((absensi_form-absensi_1), 2)));
    var claster_3 = Math.sqrt((Math.pow((nilai_form-nilai_2), 2)+Math.pow((ext_form-ext_2), 2)+Math.pow((perilaku_form-perilaku_2), 2)+Math.pow((absensi_form-absensi_2), 2)));

    if (claster_1 <= claster_2 && claster_1 <= claster_3) {
      document.getElementById('cluster').innerHTML = "UNGGUL";
    }else if(claster_2 <= claster_3 && claster_2 <= claster_1){
      document.getElementById('cluster').innerHTML = "BERKEMBANG";
    }else{
      document.getElementById('cluster').innerHTML = "LEMAH";
    }
    
  }
</script>
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <h3 class="modal-title" style="padding: 5px 20px;">CEK NILAI</h3>
    <div class="modal-body">
      <form action="" method="post" id="cek_nilai">
        <div class="phAnimate">
            <label for="id_siswa">Nilai KKM</label>
            <input id="nilai" type="number" name="NILAI" class="form-control" required="required">
        </div>
        <div class="phAnimate">
            <label for="id_siswa">Extrakulikuler</label>
            <select id="ext" name="EXT" class="form-control" required="required">
              <option value="">-= Pilih =-</option>
              <option value="4">A</option>
              <option value="3">B</option>
              <option value="2">C</option>
              <option value="1">D</option>
            </select>
        </div>
        <div class="phAnimate">
            <label for="id_siswa">Prilaku</label>
            <select id="perilaku" name="PERILAKU" class="form-control" required="required">
              <option value="">-= Pilih =-</option>
              <option value="4">A</option>
              <option value="3">B</option>
              <option value="2">C</option>
              <option value="1">D</option>
            </select>
        </div>
        <div class="phAnimate">
            <label for="id_siswa">Absensi</label>
            <select id="absensi" name="ABSENSI" class="form-control" required="required">
              <option value="">-= Pilih =-</option>
              <option value="4">A</option>
              <option value="3">B</option>
              <option value="2">C</option>
              <option value="1">D</option>
            </select>
        </div> 
        <div class="modal-footer">
            <label for="id_siswa" id="cluster" style="width: 85%; margin-top:5px; text-align: center;font-size: 20px;">UNGGUL</label>
            <button type="submit" name="simpan"  class="btn btn-info glyphicon">CEK</button>
        </div>
      </form>
  </div>
</div>