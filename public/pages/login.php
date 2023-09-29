

<?php 
	require_once '../../config/setup.php';
	require_once '../../config/header.php';

	if(isset($_POST['login'])){

		$error = "";

		if(!isEmail($_POST['email'])){
			$error = "Email inválido <br>";
		}
		if(!isCampo($_POST['pass'])){
			$error = "Senha inválida <br>";
		}

		if(empty($error) and isset($error)){
			$email = $_POST['email'];
			$pass = md5($_POST['pass']);

			$sql = "select * from tb_admin where email='$email' and password='$pass';";

			if(Account_Exists($con,$sql) === true){
				$_SESSION['email'] = $email;
				$_SESSION['pass'] = $pass;
				header("location://localhost/recruta.com/admin");
			}else{
				$error = "Senha ou email está incorrecto <br>";
				$pass_error = $_POST['pass'];
				$email_error = $_POST['email'];
			}
		}else if(!empty($error) and isset($error)){
		  
		  	$pass_error = $_POST['pass'];
			$email_error = $_POST['email'];
		}
		unset($_POST['login']);
	}
	

 ?>
 	<title>UnitelRecru</title>
 	<link rel="stylesheet" type="text/css" href="../css/style.css">
 	<script type="text/javascript" defer src="../js/recruta.js"></script>
</head>
<body>
	<div class="big-container">
	
		<header>
			<div class="container">
				<a class="logo" href="//localhost/recruta.com"><h1><p class="logo-mark">U<span class="logo-markR">R</span></p>Unitel<span class="R">Recru.</span></h1></a>
				<form class="search" autocomplete="off" style="visibility: hidden;">
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
						<li><a href="//localhost/recruta.com/public/pages/anounce.php">Anúncios</a></li>
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
				<div class="content" style="min-height:600px;">
					<h1 class="admin-title">Iniciar sessão como admin</h1>
					<form class="form-login" autocomplete="off" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
					<?php 

							if(isset($error) and !empty($error)):

					?>
							<div class="input error">
								<p><?php echo $error; ?><span class="fa fa-times"></span></p>
							</div>
					<?php 
							endif;
					?>
						<div class="input">
							<label for="adminemail">E-mail do administrador</label>
							<input required type="email" name="email" id="adminemail" placeholder="Digite teu e-mail" value="<?php echo $email_error ?? "" ; ?>">
						</div> 
						<div class="input">
							<label for="adminpass">Senha do administrador</label>
							<input required type="password" name="pass" id="adminpass" placeholder="Digite tua senha" value="<?php echo $pass_error ?? ""; ?>">
						</div>
					<?php 

						$sql = "select * from tb_admin;";
						if(!Account_Exists($con,$sql)===true):

					?>
						<div class="input">
							<a class="link" href="//localhost/recruta.com/public/pages/new_account.php">Criar nova conta.</a>
						</div>
					<?php 
							endif;
					?>
						<div class="btns">
							<button type="submit" name="login" class="btn">Log in</button>
							<a href="//localhost/recruta.com" class="btn">Cancelar</a>
						</div>
					</form>
				</div>
			</div>
		</section>
 <?php 
 unset($_POST['login']);
	require_once '../../config/footer.php';
	
 ?>