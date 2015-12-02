<h1 class="title-page seg">Seguidores</h1>

<?php 
	$nickname = strip_tags($explode[0]);
	$pega_id = $pdo->prepare("SELECT `id` FROM `usuarios` WHERE `nickname` = ?");
	$pega_id->execute(array($nickname));
	$id_user = $pega_id->fetchObject();

	$pega_follows = $pdo->prepare("SELECT * FROM `follows` WHERE `usuario` = ? ORDER BY `id` DESC");
	$pega_follows->execute(array($id_user->id));
	while($follow = $pega_follows->fetchObject()){
		$pega_user_followed = $pdo->prepare("SELECT * FROM `usuarios` WHERE `id` = ?");
		$pega_user_followed->execute(array($follow->seguidor));
		$user = $pega_user_followed->fetchObject();

		$foto = ($user->foto == '') ? BASE.'/uploads/default.jpg' : BASE.'/uploads/'.$user->foto;

		//verifica se sigo de volta ou não
		$verifica_follow = $pdo->prepare("SELECT * FROM `follows` WHERE `seguidor` = ? AND `usuario` = ? ORDER BY `id` DESC");
		$verifica_follow->execute(array($logado->id, $user->id));
		if($verifica_follow->rowCount() == 1){
			$texto = 'Desseguir';
		}else{
			$texto = 'Seguir';
		}
?>
<div class="box_perfil">
	<div class="img"><img src="<?php echo $foto;?>" /></div>
	<div class="fix">
	<?php if($user->id != $logado->id){?>
	<a href="#" class="button seguir" data-user="<?php echo $user->id;?>"><span class="icon-user"></span> <?php echo $texto;?></a>
	<?php }?>
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