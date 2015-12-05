<?php
	session_start();
	include_once "config.php";
	if(!isset($_SESSION['nickname'])){
		include_once "logar.php";
		die;
	}else{
		$pega_logado = $pdo->prepare("SELECT * FROM `usuarios` WHERE `nickname` = ?");
		$pega_logado->execute(array($_SESSION['nickname']));
		$logado = $pega_logado->fetchObject();

		if(isset($_GET['sair'])){
			unset($_SESSION['nickname']);
			session_destroy();
			header("Location: ".BASE);
		}
	}
	include_once "inc/functions.php";
	check_temp($logado);
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
	<head>
		<meta charset=UTF-8>
		<title>Mini Twitter</title>
		<!---<link href='//fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css' />-->
		<link href="<?php echo BASE;?>/css/style.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo BASE;?>/css/jcrop.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	<header id="header">
		<div class="center">
			<ul class="left">
				<li><a href="<?php echo BASE;?>">Início</a></li>
			</ul>
			 <div class="search">
			 	<span class="icon-search"></span>
			 	<form action="" method="get">
			 		<input type="search" name="s" />
			 	</form>
			 </div>
			<ul class="right">
				<li><a href="<?php echo BASE.'/?sair';?>">Sair</a></li>
				<li><a href="<?php echo BASE.'/minha-conta';?>">Minha Conta</a></li>
			</ul>
		</div>
	</header>
	<span class="base" id="<?php echo BASE;?>"></span>
	<span class="user_id" id="<?php echo $logado->id;?>"></span>