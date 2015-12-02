<?php
	session_start();
	date_default_timezone_set("America/Sao_Paulo");

	define('BASE', 'http://localhost/videoaulas/mini-twitter');

	$pdo = new PDO('mysql:host=localhost;dbname=mini_twitter', 'root','');
	$pdo->exec("set names utf8");
?>