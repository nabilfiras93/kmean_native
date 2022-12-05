<?php
	$bdd = new PDO('mysql:host=localhost;dbname=pengelompokan-siswa-normalisasi','root','');
	if (!$bdd) {
		echo "Errot Connections : ".mysql_error();
	}
?>