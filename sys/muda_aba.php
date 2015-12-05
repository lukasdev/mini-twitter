<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		session_start();
		include_once  "../config.php";
		$_SESSION['aba'] = $_POST['aba'];
	}
?>