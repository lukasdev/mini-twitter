<aside id="sidebar">
<?php
	if($perfil == true){
		$dados = $dados_perfil;
		$link = BASE.'/'.$dados->nickname;
	}else{
		$dados = $logado;
		$link = BASE;
	}

	$foto = ($dados->foto == '') ? BASE.'/uploads/default.jpg' : BASE.'/uploads/'.$dados->foto;

	$contagem_seguindo = $pdo->prepare("SELECT `id` FROM `follows` WHERE `seguidor` = ?");
	$contagem_seguindo->execute(array($dados->id));
	$qtd_seguindo = $contagem_seguindo->rowCount();

	$contagem_seguidores = $pdo->prepare("SELECT `id` FROM `follows` WHERE `usuario` = ?");
	$contagem_seguidores->execute(array($dados->id));
	$qtd_seguidores = $contagem_seguidores->rowCount();

	$contagem_tweets = $pdo->prepare("SELECT `id` FROM `tweets` WHERE `user_id` = ?");
	$contagem_tweets->execute(array($dados->id));
	$qtd_tweets = $contagem_tweets->rowCount();

	//verifica se sigo de volta ou não
	if($perfil == true && $dados->id != $logado->id){
		$verifica_follow = $pdo->prepare("SELECT * FROM `follows` WHERE `seguidor` = ? AND `usuario` = ? ORDER BY `id` DESC");
		$verifica_follow->execute(array($logado->id, $dados->id));
		if($verifica_follow->rowCount() == 1){
			$texto = 'Desseguir';
		}else{
			$texto = 'Seguir';
		}
	}
?>
<div class="box_sidebar perfil">
	<div class="img_perfil">
		<img src="<?php echo $foto;?>" />
	</div>
	<div class="dados_user"> 
		<span class="nome_perfil"><a href="<?php echo $link;?>"><?php echo $dados->nome;?></a></span>
		<a href="#" class="nickname">@<?php echo $dados->nickname;?></a>
	</div>

	<div class="stats">
		<div class="box_stats">
			<span>Tweets</span>
			<p><?php echo $qtd_tweets;?></p>
		</div>
		<div class="box_stats">
			<span>Seguindo</span>
			<p><a href="<?php echo BASE.'/'.$dados->nickname.'/seguindo';?>"><?php echo $qtd_seguindo;?></a></p>
		</div>
		<div class="box_stats">
			<span>Seguidores</span>
			<p><a href="<?php echo BASE.'/'.$dados->nickname.'/seguidores';?>"><?php echo $qtd_seguidores;?></a></p>
		</div>
	</div>
	<?php if($perfil == true){?>
	<div class="descricao"><p><?php echo $dados->descricao;?></p></div>
	<?php }?>

	<?php if($perfil == true && $dados->id != $logado->id){?>
	<a href="#" class="button seguir side" data-user="<?php echo $dados->id;?>"><span class="icon-user"></span> <?php echo $texto;?></a>
	<?php }?>
</div>

<div class="box_sidebar">
	<h2>Trending Topics</h2>
	<ul>
	<?php
		$trending = $pdo->prepare("SELECT * FROM `trending` ORDER BY `mencoes` DESC LIMIT 5");
		$trending->execute();
		while($tag_top = $trending->fetchObject()){
			$tag = str_replace('#', '', $tag_top->hashtag);
	?>
		<li><a href="<?php echo BASE.'/hashtag/'.$tag;?>"><?php echo $tag_top->hashtag;?></a></li>
	<?php }?>
	</ul>
</div>
</aside>