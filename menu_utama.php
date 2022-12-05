<?php 
  if (empty($_SESSION['username'])) {
    header("location:index.php");
  }
?>
<h1 style='text-align:center;'>Selamat Datang <?php echo $nama_admin; ?></h1>
<div><center><img class="img-fluid" src="" ></center>
	
</div>