<?php include_once "inc/sidebar.php";?>
<section id="content_wrapper">
	<?php
		$hashtag = '#'.$explode[1];
	?>
	<h1 class="title-page">Menções a <?php echo $hashtag;?></h1>

	<section id="content">
	<?php
		$pega_mencoes = $pdo->prepare("SELECT * FROM `tweets` WHERE `tweet` LIKE '%$hashtag%' ORDER BY `id` DESC");
		$pega_mencoes->execute();
		while($tweet = $pega_mencoes->fetchObject()){

			$user_tweet = $pdo->prepare("SELECT * FROM `usuarios` WHERE `id` = ?");
			$user_tweet->execute(array($tweet->user_id));
			$user_dados = $user_tweet->fetchObject();
	?>
		<article class="tweet">
			<span class="nome">
				<a href="<?php echo BASE.'/'.$user_dados->nickname;?>"><?php echo $user_dados->nome;?></a> disse:
			</span>
			<p><?php echo $tweet->tweet;?></p>
			<span class="date"><?php echo date('d/m/Y H:i:s', strtotime($tweet->data));?></span>
		</article>
	<?php }?>
	</section>
</section>