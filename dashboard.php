<?php session_start();
	include 'koneksi.php';
	$nama_admin = @$_SESSION['username'];

	if (empty($_SESSION['username'])) {
		header("location:index.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Selamat datang - <?php echo $nama_admin; ?></title>

		<meta name="description" content="overview &amp; stats" />
		<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" /> -->

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
		<link rel="stylesheet" href="assets/css/w3.css" />
		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
 


		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- ace settings handler -->
		<script src="assets/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>
					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="dashboard.php?hal=menu_utama" class="navbar-brand">
						<small>
							<i class="fa fa-home"></i>
							Pengelompokkan Prestasi Siswa Metode Algoritma K-Means 
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								
								<span class="user-info" style="font-size: 20px;">
									<div style="margin-top: 8px; margin-right: 123px;"></div>
									<large><?php echo $nama_admin; ?></large>
								</span>
								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="keluar.php">
										<i class="ace-icon fa fa-user"></i>
										Keluar
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar responsive ace-save-state">
				<script type="text/javascript"> try{ace.settings.loadState('sidebar')}catch(e){} </script>
				<ul class="nav nav-list">
					<li class="active">
						<a href="dashboard.php?hal=menu_utama">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Menu Utama </span>
						</a>
						<b class="arrow"></b>
					<li class="">
						<a href="dashboard.php?hal=nilai_siswa">
							<i class="menu-icon fa fa-list-alt"></i>
							<span class="menu-text"> Data Siswa </span>
						</a>
						<b class="arrow"></b>
					</li>
					<!-- <li class="">
						<a href="dashboard.php?hal=cek_nilai">
							<i class="menu-icon fa fa-list-alt"></i>
							<span class="menu-text"> Cek Nilai </span>
						</a>
						<b class="arrow"></b>
					</li> -->
					<li class="">
						<a href="dashboard.php?hal=perhitungan_euclidean">
							<i class="menu-icon fa fa-calendar"></i>
							<span class="menu-text"> Euclidian</span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="dashboard.php?hal=perhitungan_manhattan">
							<i class="menu-icon fa fa-calendar"></i>
							<span class="menu-text"> Manhattan</span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="dashboard.php?hal=perhitungan_minkowski">
							<i class="menu-icon fa fa-calendar"></i>
							<span class="menu-text"> Minkowski</span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="dashboard.php?hal=grafik">
							<i class="menu-icon fa fa-list-alt"></i>
							<span class="menu-text"> Grafik Euclidian</span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="dashboard.php?hal=grafik_manhattan">
							<i class="menu-icon fa fa-list-alt"></i>
							<span class="menu-text"> Grafik Manhattan</span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="dashboard.php?hal=grafik_minkowski">
							<i class="menu-icon fa fa-list-alt"></i>
							<span class="menu-text"> Grafik Minkowski</span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="dashboard.php?hal=organisasi">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> Struktur Organisasi</span>
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="dashboard.php?hal=visi_misi">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> Visi Misi & Sejarah</span>
						</a>
						<b class="arrow"></b>
					</li>
				</ul><!-- /.nav-list -->
				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>

			<div class="main-content">
				<?php 
					$halaman = @$_GET['hal'];
					if ($halaman == 'nilai_siswa') {
						include "nilai_siswa.php";
					}else if ($halaman == "cek_nilai") {
						include "cek_nilai.php";
					}else if ($halaman == "grafik") {
						include "grafik_euclidean.php";
					}else if ($halaman == "grafik_manhattan") {
						include "grafik_manhattan.php";
					}else if ($halaman == "grafik_minkowski") {
						include "grafik_minkowski.php";
					}else if ($halaman == "perhitungan_euclidean") {
						include "perhitungan_euclidean.php";
					}else if ($halaman == "perhitungan_manhattan") {
						include "perhitungan_manhattan.php";
					}else if ($halaman == "perhitungan_minkowski") {
						include "perhitungan_minkowski.php";
					}else if($halaman == 'normalisasi'){
						include "normalisasi_euclidean.php";
					}else if($halaman == 'normalisasi_manhattan'){
						include "normalisasi_manhattan.php";
					}else if($halaman == 'normalisasi_minkowski'){
						include "normalisasi_minkowski.php";
					}else if($halaman == 'organisasi'){
						include "organisasi.php";
					}else if($halaman == 'visi_misi'){
						include "visi_misi.php";
					}else{
						include "menu_utama.php";
					}
				?>
			</div>
		</div>
	</body>
	<!-- <![endif]-->

	<!--[if IE]>
	<script src="assets/js/jquery-1.11.3.min.js"></script>
	<![endif]-->
	<script type="text/javascript">
		if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
	</script>
	<script src="assets/js/bootstrap.min.js"></script>

	<!-- page specific plugin scripts -->

	<!--[if lte IE 8]>
	  <script src="assets/js/excanvas.min.js"></script>
	<![endif]-->
	<script src="assets/js/jquery-ui.custom.min.js"></script>
	<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
	<script src="assets/js/jquery.easypiechart.min.js"></script>
	<script src="assets/js/jquery.sparkline.index.min.js"></script>
	<script src="assets/js/jquery.flot.min.js"></script>
	<script src="assets/js/jquery.flot.pie.min.js"></script>
	<script src="assets/js/jquery.flot.resize.min.js"></script>

	<!-- ace scripts -->
	<script src="assets/js/ace-elements.min.js"></script>
	<script src="assets/js/ace.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
	<script type="text/javascript">
		jQuery(function($) {
			$('#task-tab .dropdown-hover').on('mouseenter', function(e) {
				var offset = $(this).offset();
		
				var $w = $(window)
				if (offset.top > $w.scrollTop() + $w.innerHeight() - 100) 
					$(this).addClass('dropup');
				else $(this).removeClass('dropup');
			});
		});

		
		function openCity(cityName) {
		  var i;
		  var x = document.getElementsByClassName("city");
		  for (i = 0; i < x.length; i++) {
		    x[i].style.display = "none";  
		  }
		  document.getElementById(cityName).style.display = "block";  
		}

		$(document).ready(function() {
		    $('.datatablesku').DataTable();
		} );
	</script>
</html>
