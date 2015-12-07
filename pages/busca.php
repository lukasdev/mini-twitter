<?php include_once "inc/sidebar.php";?>
<section id="content_wrapper">
	<section id="content">
	<h1 class="title-page seg">Busca</h1>
	<div class="content_perfis">
	<?php 
		$busca = strip_tags(trim($_GET['s']));
		$usrs = $pdo->prepare("SELECT * FROM `usuarios` WHERE `nome` LIKE '%$busca%'");
		$usrs->execute();

		$pega_result = $pdo->prepare("SELECT * FROM `usuarios` WHERE `nome` LIKE '%$busca%' AND `id` != ? ORDER BY `id` DESC LIMIT 1");
		$pega_result->execute(array($logado->id));
		$_SESSION['ids_carregados'] = array();

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

			$_SESSION['ids_carregados'][] = $user->id;
	?>
	<div class="box_perfil">
		<div class="img"><img src="<?php echo $foto;?>" /></div>
		<div class="fix">
			<a href="#" class="button seguir" data-user="<?php echo $user->id;?>"><span class="icon-user"></span> <?php echo $texto;?></a>
		</div>
			
		<span class="perfil_nick">
			<span><a href="<?php echo BASE.'/'.$user->nickname;?>"><?php echo $user->nome;?></a></span>
			<p><a href="<?php echo BASE.'/'.$user->nickname;?>">@<?php echo $user->nickname;?></a></p>
		</span>
		<div class="desc">
			<p><?php echo $user->descricao;?></p>
		</div>
	</div>
	<?php }?>
	</div>
	<?php
	if($usrs->rowCount() > 1){
		echo '<a href="#" class="button load_more" id="perfis_busca" data-search="'.$busca.'">Carregar Mais</a>';
	}
	?>
	</section>
</section>