<?php include_once "inc/sidebar.php";?>
<section id="content_wrapper">
	<section id="envio_mensagem">
		<form action="" method="post" enctype="multipart/form-data">
			<label>
				<span class="title">Digite uma mensagem</span>
				<textarea name="mensagem" class="msg"></textarea>
				<span class="counter"></span>
				<button class="send_message">Enviar</button>
			</label>
		</form>
	</section>

	<section id="content">
		<div class="content_tweets">
	<?php
		//pego as pessoas que estou seguindo
		$pega_follows = $pdo->prepare("SELECT * FROM `follows` WHERE `seguidor` = ?");
		$pega_follows->execute(array($logado->id));

		$ids_seguindo = array($logado->id);
		while($usr = $pega_follows->fetchObject()){
			$ids_seguindo[] = $usr->usuario;
		}
		$str_seguindo = implode(', ', $ids_seguindo);
		$twt = $pdo->prepare("SELECT * FROM `tweets` WHERE `user_id` IN ($str_seguindo) ORDER BY `id` DESC");
		$twt->execute();

		$tweets = $pdo->prepare("SELECT * FROM `tweets` WHERE `user_id` IN ($str_seguindo) ORDER BY `id` DESC LIMIT 1");
		$tweets->execute();
		$_SESSION['ids_carregados'] = array();

		while($tweet = $tweets->fetchObject()){
			$user_tweet = $pdo->prepare("SELECT * FROM `usuarios` WHERE `id` = ?");
			$user_tweet->execute(array($tweet->user_id));
			$user_dados = $user_tweet->fetchObject();

			$_SESSION['ids_carregados'][] = $tweet->id;
	?>
		<article class="tweet">
			<span class="nome">
				<a href="<?php echo BASE.'/'.$user_dados->nickname;?>"><?php echo $user_dados->nome;?></a> disse:
			</span>
			<p><?php echo $tweet->tweet;?></p>
			<span class="date"><?php echo date('d/m/Y H:i:s', strtotime($tweet->data));?></span>
		</article>
	<?php }?>
	</div>
	<?php
	if($twt->rowCount() > 1){
		echo '<a href="#" class="button load_more" id="tweets_home">Carregar Mais</a>';
	}
	?>
	</section>
</section>