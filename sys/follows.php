<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		include_once "../config.php";

		$pega_logado = $pdo->prepare("SELECT * FROM `usuarios` WHERE `nickname` = ?");
		$pega_logado->execute(array($_SESSION['nickname']));
		$logado = $pega_logado->fetchObject();

		$follow_unfollow = (int)$_POST['follow_unfollow'];

		$verifica = $pdo->prepare("SELECT `id` FROM `follows` WHERE `seguidor` = ? AND `usuario` = ?");
		$verifica->execute(array($logado->id, $follow_unfollow));
		if($verifica->rowCount() == 1){
			$registro = $verifica->fetchObject();
			
			$apagar = $pdo->prepare("DELETE FROM `follows` WHERE `id` = ?");
			if($apagar->execute(array($registro->id))){
				echo 'ok';
			}else{
				echo 'no';
			}
		}else{
			$seguir = $pdo->prepare("INSERT INTO `follows` SET `seguidor` = ?, `usuario` = ?");
			if($seguir->execute(array($logado->id, $follow_unfollow))){
				echo 'ok';
			}else{
				echo 'no';
			}
		}
	}
?>