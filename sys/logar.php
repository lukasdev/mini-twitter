<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		session_start();
		include_once "../config.php";

		if($_POST['login'] != '' && $_POST['senha'] != ''){
			$login = strip_tags(trim(filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING)));
			$senha = strip_tags(trim(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING)));

			$verifica = $pdo->prepare("SELECT * FROM `usuarios` WHERE (`email` = ? OR `nickname` = ?) AND `senha` = ?");
			$verifica->execute(array($login, $login, $senha));
			if($verifica->rowCount() == 1){
				$logado = $verifica->fetchObject();
				$_SESSION['nickname'] = $logado->nickname;
				
				sleep(1);
				if(isset($_SESSION['nickname'])){
					echo 'ok';
				}else{
					echo 'no';
				}
			}else{
				echo 'no';
			}
		}else{
			echo 'no';
		}
	}
?>