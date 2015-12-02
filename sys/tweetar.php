<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		include_once "../config.php";
		$pega_logado = $pdo->prepare("SELECT * FROM `usuarios` WHERE `nickname` = ?");
		$pega_logado->execute(array($_SESSION['nickname']));
		$logado = $pega_logado->fetchObject();

		$tweet = strip_tags($_POST['tweet']);
		$tweet_sem_link = $tweet;

		$tweet = preg_replace('/\B#([\d\w_]+)/i', '<a href="'.BASE.'/hashtag/$1">$0</a>', $tweet);
		$retorno = array();
		$retorno['user_id'] = $logado->id;
		$retorno['nome'] = $logado->nome;
		$retorno['tweet'] = $tweet;
		$retorno['date'] = date('d/m/Y H:i:s');

		//codigo para mensoes de hashtags
		$palavras_tweet = explode(' ', $tweet_sem_link);
		$hashtags = array();
		foreach($palavras_tweet as $in => $palavra){
			if(preg_match('/^#+[a-z0-9_]/i', $palavra)){
				$hashtags[] = $palavra;
			}
		}
		$contagem_hashtags = count($hashtags);
		$n_tags = 0;
		if($contagem_hashtags >= 1){
			foreach($hashtags as $ind => $tag){
				$verifica_tag = $pdo->prepare("SELECT * FROM `trending` WHERE `hashtag` = ?");
				$verifica_tag->execute(array($tag));

				if($verifica_tag->rowCount() == 1){
					$tag_trending = $verifica_tag->fetchObject();

					$novo_valor = $tag_trending->mencoes+1;
					$update_mencoes = $pdo->prepare("UPDATE `trending` SET `mencoes` = ? WHERE `id` = ?");
					if($update_mencoes->execute(array($novo_valor, $tag_trending->id))){
						$n_tags += 1;
					}
				}else{
					$insert_tag = $pdo->prepare("INSERT INTO `trending` SET `hashtag` = ?, `mencoes` = 1");
					if($insert_tag->execute(array($tag))){
						$n_tags += 1;
					}
				}
			}
		}

		if($contagem_hashtags == $n_tags){
			$insert = $pdo->prepare("INSERT INTO `tweets` SET `user_id` = ?, `tweet` = ?, `data` = ?");
			$dados = array($retorno['user_id'], $retorno['tweet'], date('Y-m-d H:i:s'));
			if($insert->execute($dados)){
				$retorno['status'] = 'ok';
			}else{
				$retorno['status'] = 'no';
			}
		}

		die(json_encode($retorno));
	}
?>