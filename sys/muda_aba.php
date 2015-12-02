<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		include_once  "../config.php";
		$_SESSION['aba'] = $_POST['aba'];
	}
?>