

<?php 
	require_once '../../config/setup.php';
	require_once '../../config/header.php';


	if(isset($_POST['create'])):
		$errors = array();
		if(!isWord($_POST['name'])){
			
			$errors[] = "Nome inválido<br>";
		}if(!isEmail($_POST['email'])){
			
			$errors[] = "Email inválido<br>";
		}if(isCampo($_POST['pass']) and isCampo($_POST["passconfirm"])){
			if(!isEqualPass($_POST['pass'],$_POST['passconfirm'])){
				$errors[] = "A senha digitadas sao diferentes";
				
			}
		}else{

			 $errors[] = "Senha inválida<br>";
		}


		if(empty($errors) and isset($errors)){
			$name = $_POST['name'];
			$email = $_POST['email'];
			$pass = md5($_POST['pass']);
			$sql = "INSERT INTO tb_admin value (null,'$name','$email','$pass');";
			if($con->query($sql)===true){
				$_SESSION['email'] = $email;
				$_SESSION['pass'] = $pass;
				header("location://localhost/recruta.com/public/pages/start_session.php");
			}else{
				echo $errors [] = "Error no login ".$con->error;
			}
		}else if(!empty($errors) and isset($errors)){
			$name_error = $_POST['name'];
			$email_error = $_POST['email'];
			$pass_error = $_POST['pass'];
			$passconfirm_error = $_POST['passconfirm'];
		}
	endif;
 ?>
 	<title>UnitelRecru</title>
 	<link rel="stylesheet" type="text/css" href="../css/style.css">
 	<script type="text/javascript" src="../js/recruta.js" defer></script>
</head>
<body>
	<div class="big-container">
	
		<header>
			<div class="container">
				<a class="logo" href="//localhost/recruta.com"><h1><p class="logo-mark">U<span class="logo-markR">R</span></p>Unitel<span class="R">Recru.</span></h1></a>
				<form class="search" autocomplete="off" action="<?php echo htmlentities($_POST['PHP_SELF']);?>" method='post'>
					<label for="search"><span class="fa fa-search"></span></label>
					<input typ be="text" name="search-all" id="search" placeholder="Pesquisar...">
					<div class="screen-result">
						 <ul class="list">
						 	<li><a href=""> <div class="icon"><img src="public/img/ola.png" class=""></div>Ola</a></li>
						 	<li><a href="">Ola</a></li>
						 	<li><a href="">Ola</a></li>
						 	<li><a href="">Ola</a></li>
						 </ul>
					</div>
				</form>
				<nav class="menu-bars">
					<ul class="menu">
						<li><a href="//localhost/recruta.com">Página inicial</a></li>
						<li><a href="public/pages/anounce.php">Anúncios</a></li>
						<li><a href="//localhost/recruta.com/public/pages/recruta.php">Candidatar</a></li>
						<li><a href="//localhost/recruta.com/public/pages/contact.php">Contacto</a></li>
						<li><a href="//localhost/recruta.com/public/pages/about.php">Sobre</a></li>
						<li><a href="//localhost/recruta.com/public/pages/help.php">Ajuda</a></li>
						<li class="login"><a  class="active" href="//localhost/recruta.com/public/pages/login.php"><span class="fa fa-user-circle"></span></a>
						</li>
					</ul>
				</nav>
			</div>
		</header>
		<section>
			<div class="container">
				<div class="content" style="min-height: 600px;">
					<h1 class="admin-title">Criar conta para admin</h1>
				<?php 

					$sql  = "select * from tb_admin";

					if(Account_Exists($con,$sql)===true):
					?>
						<h2 class="admin-title" style=" font-size: 1.3rem; border-bottom: unset; text-align: center;">
							Já existem uma conta para administrador
						</h2>
					<?php 
					else:


					 ?>

					<form class="form-login" autocomplete="off" action="<?php echo(htmlentities($_SERVER['PHP_SELF']))?>" method='POST'>

						<div class="input">
							<label for="adminemail">Nome do administrador</label>
							<input  required type="text" name="name" id="adminemail" placeholder="Digite teu nome" value="<?php echo $name_error ?? ""; ?>" >
						</div>
						<div class="input">
							<label for="adminemail">E-mail do administrador</label>
							<input  required type="text" name="email" id="adminemail" placeholder="Digite teu e-mail" value="<?php echo $email_error ?? ""; ?>">
						</div>
						<div class="input">
							<label for="adminpass">Senha do administrador</label>
							<input  required type="password" name="pass" id="adminpass" placeholder="Digite tua senha" value="<?php echo $pass_error ?? ""; ?>">
						</div>
						<div class="input">
							<label for="passconfirm">Senha de confirmação</label>
							<input  required type="password" name="passconfirm" id="passconfirm" placeholder="Digite senha de confirmação" value="<?php echo $passconfirm_error ?? ""; ?>">
						</div>
										
						<div class="btns">
							<button  required type="submit" name="create" class="btn">Criar conta</button>
							<a  href="//localhost/recruta.com" class="btn">Cancelar</a>
						</div>
						<?php 

							if(isset($errors)):

						 ?>
						<div class="input error">
						<?php 
							if(!empty($errors)):
									foreach ($errors as $erro):
						?>
								<p class="error-error"><?php echo $erro; ?><span class="fa fa-times"></span></p>
						<?php 
								endforeach;
								else:

						?>
								<p class="error-success">Conta criada com sucesso, já podes iniciar sessão<span class="fa fa-check"></span></p>
						<?php 
							endif;

						 ?>
						</div>
						<?php 
							endif;

						 ?>
					</form>
					<?php 

						endif;

					 ?>
				</div>
			</div>
		</section>
 <?php 
 	unset($_POST['create']);
	require_once '../../config/footer.php';
	
 ?>