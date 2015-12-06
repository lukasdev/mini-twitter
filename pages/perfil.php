<?php include_once "inc/sidebar.php";?>
<section id="content_wrapper">
<?php
	$permitidas = ['seguindo', 'seguidores'];
	if(isset($explode[1]) && in_array($explode[1], $permitidas)){
		include_once 'pages/'.$explode[1].'.php';
	}else{
?>
	<h1 class="title-page">Timeline</h1>

	<section id="content">
		<div class="content_tweets">
	<?php
		$twt = $pdo->prepare("SELECT * FROM `tweets` WHERE `user_id` = ? ORDER BY `id` DESC");
		$twt->execute(array($dados_perfil->id));
		$_SESSION['ids_carregados'] = array();

		$pega_mencoes = $pdo->prepare("SELECT * FROM `tweets` WHERE `user_id` = ? ORDER BY `id` DESC LIMIT 1");
		$pega_mencoes->execute(array($dados_perfil->id));
		while($tweet = $pega_mencoes->fetchObject()){
			$_SESSION['ids_carregados'][] = $tweet->id
	?>
		<article class="tweet">
			<span class="nome"><a href="<?php echo BASE.'/'.$dados_perfil->nickname;?>"><?php echo $dados_perfil->nome;?></a> disse:</span>
			<p><?php echo $tweet->tweet;?></p>
			<span class="date"><?php echo date('d/m/Y H:i:s', strtotime($tweet->data));?></span>
		</article>
	<?php }?>
		</div>
		<?php
		if($twt->rowCount() > 1){
			echo '<a href="#" class="button load_more" id="tweets_timeline" data-id="'.$dados_perfil->id.'">Carregar Mais</a>';
		}
		?>
	</section>
<?php }?>
</section>