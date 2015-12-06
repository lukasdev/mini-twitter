<?php
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	include_once "../config.php";
	$logado_id = $_GET['user_id'];
	$time = (isset($_GET['timestamp']) && $_GET['timestamp'] != 'undefined') ? $_GET['timestamp'] : time();
	$t = 0;
	$pega_follows = $pdo->prepare("SELECT * FROM `follows` WHERE `seguidor` = ?");
	$pega_follows->execute(array($logado_id));

	$ids_seguindo = array();
	while($usr = $pega_follows->fetchObject()){
		$ids_seguindo[] = $usr->usuario;
	}
	$str_seguindo = implode(', ', $ids_seguindo);

	while($t <= 30){
		$tweets = $pdo->prepare("SELECT * FROM `tweets` WHERE `user_id` IN ($str_seguindo) 
			AND `timestamp` >= ? ORDER BY `id` DESC");
		$tweets->execute(array($time));
		if($tweets->rowCount() >= 1){
			$retorno = array('timestamp' => time()+1, 'results' => array());
			while($tweet = $tweets->fetchObject()){
				$user_tweet = $pdo->prepare("SELECT * FROM `usuarios` WHERE `id` = ?");
				$user_tweet->execute(array($tweet->user_id));
				$user_dados = $user_tweet->fetchObject();

				$retorno['results'][] = array(
					'nome' => $user_dados->nome, 
					'tweet' => $tweet->tweet, 
					'date' => date('d/m/Y H:i:s', strtotime($tweet->data)), 
				);
			}
			die(json_encode($retorno));
			break;
		}else{
			sleep(1);
			$t++;

			if($t >= 30){
				die(json_encode(array('timestamp' => time(), 'results' => '')));
				break;
			}
			continue;
		}
	}
}
?>