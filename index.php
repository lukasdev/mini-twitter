<?php include_once "inc/header.php";?>
	<div id="wrapper">
			<?php
				$url = (isset($_GET['url'])) ? $_GET['url'] : 'home';
				$explode = explode('/', $url);

				$verifica_user = $pdo->prepare("SELECT * FROM `usuarios` WHERE `nickname` = :nickname");
				$verifica_user->bindValue(':nickname', strip_tags($explode[0]), PDO::PARAM_STR);
				$verifica_user->execute();

				$nao_permitidas = ['perfil', 'seguindo', 'seguidores', 'busca'];
				$perfil = false;
				if(isset($_GET['s'])){
					include_once "pages/busca.php";
				}elseif($verifica_user->rowCount() == 1){
					$perfil = true;
					$dados_perfil = $verifica_user->fetchObject();

					include_once "pages/perfil.php";
				}elseif(file_exists('pages/'.$explode[0].'.php') && !in_array($explode[0], $nao_permitidas)){
					include_once 'pages/'.$explode[0].'.php';
				}else{
					echo 'Pagina não existente <a href="'.BASE.'">Voltar</a>';
				}
			?>
	</div>
<?php include_once "inc/footer.php";?>