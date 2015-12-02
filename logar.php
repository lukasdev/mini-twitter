<!DOCTYPE HTML>
<html lang="pt-BR">
	<head>
		<meta charset=UTF-8>
		<title>Mini Twitter</title>
		<link href='//fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css' />
		<link href="<?php echo BASE;?>/css/style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>

		<section id="cadastrar">
			<a href="#" class="close">X</a>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua.</p>
			<div class="retorno_cadastro"></div>
			<form action="" method="post" enctype="multipart/form-data">
				<label>
					<span>Nome</span>
					<input type="text" name="nome" id="nome"/>
				</label>
				<label>
					<span>Email</span>
					<input type="text" name="email" id="email"/>
				</label>
				<label>
					<span>Nickname</span>
					<input type="text" name="nickname" id="nickname"/>
				</label>
				<label>
					<span>Senha</span>
					<input type="password" name="senha_cad" id="senha"/>
				</label>
				<label>
					<span>Descrição</span>
					<textarea name="descricao" id="descricao" class="desc_limit"></textarea>
					<span class="desccount"></span>
				</label>

				<input type="submit" value="Cadastrar" id="efetuar_cadastro" class="btn_submit"/>
			</form>
		</section>

		<section id="logar_box">
			<div class="retorno_log">
			</div>
			<form action="" method="post" enctype="multipart/form-data">
				<label>
					<span>Email ou Nickname</span>
					<input type="text" name="login" />
				</label>
				<label>
					<span>Senha</span>
					<input type="password" name="senha" />
				</label>

				<input type="submit" value="Logar" id="logar" class="btn_submit"/>
			</form>
			<div class="cadastre-se"><p>Não possui conta? <a href="#" class="cadastre_se cad_btn">Cadastre-se</a></p></div>
		</section>

		<script type="text/javascript" src="<?php echo BASE;?>/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo BASE;?>/js/functions.js"></script>
	</body>
</html>