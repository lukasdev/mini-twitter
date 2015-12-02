<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		include_once "../config.php";

		$nome = strip_tags(trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING)));
		$email = strip_tags(trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING)));
		$nickname = strip_tags(trim(filter_input(INPUT_POST, 'nickname', FILTER_SANITIZE_STRING)));
		$senha = strip_tags(trim(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING)));
		$descricao = strip_tags(trim(filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING)));

		$verifica_email = $pdo->prepare("SELECT `id` FROM `usuarios` WHERE `email` = ?");
		$verifica_email->execute(array($email));

		$verifica_nick = $pdo->prepare("SELECT `id` FROM `usuarios` WHERE `nickname` = ?");
		$verifica_nick->execute(array($nickname));
		if($_POST['acao'] == 'efetuar_cadastro'){
			if($verifica_email->rowCount() >= 1){
				echo 'email';
				die;
			}elseif($verifica_nick->rowCount() >= 1){
				echo 'nickname';
				die;
			}else{
				$cadastra = $pdo->prepare("INSERT INTO `usuarios` SET `nome` = ?, `nickname` = ?, `email` = ?, `senha`= ?, `descricao` = ?");
				$data_insert = [$nome, $nickname, $email, $senha, $descricao];
				if($cadastra->execute($data_insert)){
					echo 'ok';
				}else{
					echo 'no';
				}
			}
		}elseif($_POST['acao'] == 'editar_perfil'){
			$pega_logado = $pdo->prepare("SELECT * FROM `usuarios` WHERE `nickname` = ?");
			$pega_logado->execute(array($_SESSION['nickname']));
			$logado = $pega_logado->fetchObject();

			$verifica_email = $pdo->prepare("SELECT `id` FROM `usuarios` WHERE `email` = ? AND `email` != ?");
			$verifica_email->execute(array($email, $logado->email));

			$verifica_nick = $pdo->prepare("SELECT `id` FROM `usuarios` WHERE `nickname` = ? AND `nickname` != ?");
			$verifica_nick->execute(array($nickname, $logado->nickname));
			if($verifica_email->rowCount() >= 1){
				echo 'email';
				die;
			}elseif($verifica_nick->rowCount() >= 1){
				echo 'nickname';
				die;
			}else{
				if($nickname != $logado->nickname){
					$_SESSION['nickname'] = $nickname;
				}

				$update_perfil = $pdo->prepare("UPDATE `usuarios` SET `nome` = ?, `nickname` = ?, `email` = ?, `senha` = ?, `descricao` = ? WHERE `id` = ?");
				$data_upd = [$nome, $nickname, $email, $senha, $descricao, $logado->id];
				if($update_perfil->execute($data_upd)){
					echo 'ok';
					die;
				}else{
					echo 'no';
					die;
				}
			}
		}
	}
?>