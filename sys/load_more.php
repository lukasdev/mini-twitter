<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		include_once "../config.php";
		$pega_logado = $pdo->prepare("SELECT * FROM `usuarios` WHERE `nickname` = ?");
		$pega_logado->execute(array($_SESSION['nickname']));
		$logado = $pega_logado->fetchObject();

		$tipo = $_POST['tipo'];
		$implode_ids = implode(', ', $_SESSION['ids_carregados']);

		switch ($tipo) {
			case 'tweets_home':
				$pega_follows = $pdo->prepare("SELECT * FROM `follows` WHERE `seguidor` = ?");
				$pega_follows->execute(array($logado->id));

				$ids_seguindo = array($logado->id);
				while($usr = $pega_follows->fetchObject()){
					$ids_seguindo[] = $usr->usuario;
				}
				$str_seguindo = implode(', ', $ids_seguindo);
				$ultimo_id = count($_SESSION['ids_carregados'])-1;;
				$ultimo_id = $_SESSION['ids_carregados'][$ultimo_id];

				$tweets = $pdo->prepare("SELECT * FROM `tweets` WHERE `user_id` IN ($str_seguindo) 
					AND (`id` < $ultimo_id AND `id` NOT IN ($implode_ids)) ORDER BY `id` DESC LIMIT 1");
				$tweets->execute();

				$retorno = array();
				while($tweet = $tweets->fetchObject()){
					$user_tweet = $pdo->prepare("SELECT * FROM `usuarios` WHERE `id` = ?");
					$user_tweet->execute(array($tweet->user_id));
					$user_dados = $user_tweet->fetchObject();

					$_SESSION['ids_carregados'][] = $tweet->id;
					$retorno[] = array(
						'nome' => $user_dados->nome, 
						'tweet' => $tweet->tweet, 
						'date' => date('d/m/Y H:i:s', strtotime($tweet->data)), 
					);
				}
				die(json_encode($retorno));
				break;
		}
	}
?>