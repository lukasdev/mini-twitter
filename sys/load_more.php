<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		session_start();
		include_once "../config.php";
		$pega_logado = $pdo->prepare("SELECT * FROM `usuarios` WHERE `nickname` = ?");
		$pega_logado->execute(array($_SESSION['nickname']));
		$logado = $pega_logado->fetchObject();

		$tipo = $_POST['tipo'];
		$implode_ids = implode(', ', $_SESSION['ids_carregados']);
		$limite = 1;
		switch ($tipo) {
			case 'tweets_home':
			case 'tweets_timeline':
				if($_POST['user_id'] != ''){
					$user_id = $_POST['user_id'];
				}

				if($_POST['user_id'] == ''){
					$pega_follows = $pdo->prepare("SELECT * FROM `follows` WHERE `seguidor` = ?");
					$pega_follows->execute(array($logado->id));

					$ids_seguindo = array($logado->id);
					while($usr = $pega_follows->fetchObject()){
						$ids_seguindo[] = $usr->usuario;
					}
					$str_seguindo = implode(', ', $ids_seguindo);
				}
				$ultimo_id = count($_SESSION['ids_carregados'])-1;
				$ultimo_id = $_SESSION['ids_carregados'][$ultimo_id];

				if($_POST['user_id'] == ''){
					$tweets = $pdo->prepare("SELECT * FROM `tweets` WHERE `user_id` IN ($str_seguindo) 
						AND (`id` < $ultimo_id AND `id` NOT IN ($implode_ids)) ORDER BY `id` DESC LIMIT $limite");
					$tweets->execute();

					$twt = $pdo->prepare("SELECT * FROM `tweets` WHERE `user_id` IN ($str_seguindo)");
					$twt->execute();
				}else{
					$tweets = $pdo->prepare("SELECT * FROM `tweets` WHERE `user_id` = ?
						AND (`id` < $ultimo_id AND `id` NOT IN ($implode_ids)) ORDER BY `id` DESC LIMIT $limite");
					$tweets->execute(array($user_id));

					$twt = $pdo->prepare("SELECT * FROM `tweets` WHERE `user_id` = ?");
					$twt->execute(array($user_id));
				}

				
				$retorno = array('load_more' => 'sim', 'results' => array());

				
				if(count($_SESSION['ids_carregados'])+$limite >= $twt->rowCount()){
					$retorno['load_more'] = 'nao';
				}
				while($tweet = $tweets->fetchObject()){
					$user_tweet = $pdo->prepare("SELECT * FROM `usuarios` WHERE `id` = ?");
					$user_tweet->execute(array($tweet->user_id));
					$user_dados = $user_tweet->fetchObject();

					$_SESSION['ids_carregados'][] = $tweet->id;
					$retorno['results'][] = array(
						'nickname' => $user_dados->nickname,
						'nome' => $user_dados->nome, 
						'tweet' => $tweet->tweet, 
						'date' => date('d/m/Y H:i:s', strtotime($tweet->data)), 
					);
				}
				die(json_encode($retorno));
				break;
			case 'perfis_busca':
				$busca = strip_tags(trim($_POST['data_search']));
				$retorno = array('load_more' => 'sim', 'results' => array());

				$usrs = $pdo->prepare("SELECT * FROM `usuarios` WHERE `nome` LIKE '%$busca%'");
				$usrs->execute();
				$pega_result = $pdo->prepare("SELECT * FROM `usuarios` WHERE `nome` LIKE '%$busca%' 
					AND (`id` != ? AND `id` NOT IN ($implode_ids)) ORDER BY `id` DESC LIMIT $limite");

				$pega_result->execute(array($logado->id));
				while($user = $pega_result->fetchObject()){

					$foto = ($user->foto == '') ? BASE.'/uploads/default.jpg' : BASE.'/uploads/'.$user->foto;

					//verifica se sigo de volta ou não
					$verifica_follow = $pdo->prepare("SELECT * FROM `follows` WHERE `seguidor` = ? AND `usuario` = ? ORDER BY `id` DESC");
					$verifica_follow->execute(array($logado->id, $user->id));
					if($verifica_follow->rowCount() == 1){
						$texto = 'Desseguir';
					}else{
						$texto = 'Seguir';
					}
					$retorno['results'][] = array(
						'foto' => $foto,
						'id' => $user->id,
						'texto' => $texto,
						'nome' => $user->nome,
						'nickname' => $user->nickname,
						'descricao' => $user->descricao
					);
					$_SESSION['ids_carregados'][] = $user->id;
				}
				if(count($_SESSION['ids_carregados'])+$limite >= $usrs->rowCount()){
					$retorno['load_more'] = 'nao';
				}
				die(json_encode($retorno));
				break;
			case 'tweets_hashtag':
				$hashtag = strip_tags($_POST['hashtag']);
				$twt = $pdo->prepare("SELECT * FROM `tweets` WHERE `tweet` LIKE '%$hashtag%'");
				$twt->execute();

				$pega_mencoes = $pdo->prepare("SELECT * FROM `tweets` WHERE `tweet` LIKE '%$hashtag%' 
					AND `id` NOT IN ($implode_ids) ORDER BY `id` DESC LIMIT $limite");
				$pega_mencoes->execute();

				$retorno = array('load_more' => 'sim', 'results' => array());
				
				if(count($_SESSION['ids_carregados'])+$limite >= $twt->rowCount()){
					$retorno['load_more'] = 'nao';
				}
				while($tweet = $pega_mencoes->fetchObject()){

					$user_tweet = $pdo->prepare("SELECT * FROM `usuarios` WHERE `id` = ?");
					$user_tweet->execute(array($tweet->user_id));
					$user_dados = $user_tweet->fetchObject();

					$_SESSION['ids_carregados'][] = $tweet->id;
					$retorno['results'][] = array(
						'nickname' => $user_dados->nickname,
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