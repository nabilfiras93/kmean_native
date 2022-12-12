<?php
	$bdd = new PDO('mysql:host=localhost;dbname=kmean','root','');
	if (!$bdd) {
		echo "Errot Connections : ".mysql_error();
	}
?>