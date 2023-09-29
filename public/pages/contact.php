<?php 
	require_once '../../config/setup.php';
	require_once '../../config/header.php';

	if(isset($_POST['enviar'])){

		$error = array();
		$sucess = "";
		if(!isEmail($_POST['contact_email'])){
			$error[] = "Email inválido <br>";
		}
		if(!isWord($_POST['contact_name'])){
			$error[] = "Nome inválido <br>";
		}
		if(!isWord($_POST['contact_subject'])){
			$error[] = "Mensagem inválida <br>";
		}
		if(!isWord($_POST['contact_telefone']) or !isPhone($_POST["contact_telefone"])){
			$error[] = "Contacto telefonico inválido <br>";
		}

		if(empty($error) and isset($error)){
			$name = $_POST['contact_name'];
			$email = $_POST['contact_email'];
			$message = $_POST['contact_subject'];
			$telefone = $_POST['contact_telefone'];
			$sql = "select * from tb_message where name='$name' and email='$email' and subject='$message' and phone='$telefone';";
			if ($con->query($sql)->num_rows>=1):
				$error [] = "Está mensagem já existem no sistema<br>";
				$name_error = $_POST['contact_subject'];
				$email_error = $_POST['contact_email'];
				$message_error = $_POST['contact_subject']; 
				$telefone_error = $_POST['contact_telefone']; 
			else:
				$sql = "insert into tb_message values (null, '$name','$email','$message','$telefone',0, NOW())";
				if($con->query($sql)):
					//$sucess = "Menagem enviada";
					
					header("location://localhost/recruta.com/public/pages/contact.php");
				else:
					$error [] = "Uns dos dados que está a tentar enviar já está no sistema<br>";
					$name_error = $_POST['contact_name'];
					$email_error = $_POST['contact_email'];
					$message_error = $_POST['contact_subject']; 
					$telefone_error = $_POST['contact_telefone']; 
				endif;
			endif;
		}else if(!empty($error) and isset($error)){
		 	$name_error = $_POST['contact_name'];
			$email_error = $_POST['contact_email'];
			$message_error = $_POST['contact_subject']; 
			$telefone_error = $_POST['contact_telefone']; 
		}
	}
	

 ?>
 	<title>UnitelRecru - Contacto</title>
 	<link rel="stylesheet" type="text/css" href="../../public/css/style.css">
 	<script type="text/javascript" src="../js/recruta.js" defer></script>
</head>
<body>
	<div class="big-container">
		
		<header>
			<div class="container">
				<a class="logo" href=""><h1><p class="logo-mark">U<span class="logo-markR">R</span></p>Unitel<span class="R">Recru.</span></h1></a>
				<form class="search" autocomplete="off" style="visibility: hidden;">
					<label for="search"><span class="fa fa-search"></span></label>
					<input type="text" name="search-all" id="search" placeholder="Pesquisar...">
					
				</form>
				<nav class="menu-bars">
					<ul class="menu">
						<li><a href="../../">Página inicial</a></li>
						<li><a href="anounce.php">Anúncios</a></li>
						<li><a href="recruta.php">Candidatar</a></li>
						<li><a href="contact.php" class="active">Contacto</a></li>
						<li><a href="about.php">Sobre</a></li>
						<li><a href="help.php">Ajuda</a></li>
						<li class="login">

							<a href="//localhost/recruta.com/public/pages/login.php"><span class="fa fa-user-circle"></span></a>
						</li>
					</ul>
				</nav>
			</div>
		</header>
		<section>
			<div class="container">
				<div class="content about">
					<div class="contact-body">
						<div class="recruta-info">
							<h1 class="title">Endereço da <span>UnitelRecru.</span></h1>
							<div class="info">
								<span class="fas fa-at"></span>
								<p>unitelrecru@gmail.com</p>
							</div>
							<div class="info">
								<span class="fas fa-phone phone"></span>
								<p>(+244) 937613303</p>
							</div>
							<div class="info">
								<span class="fas fa-flag"></span>
								<p>Angola-Luanda</p>
							</div>
							<div class="info">
								<span class="fas fa-map-marker-alt"></span>
								<p>Av.Fidel de Castro.</p>
							</div>
							<div class="info">
								<span class="fab fa-facebook"></span>
								<span class="fab fa-instagram"></span>
								<span class="fab fa-twitter"></span>
								<span class="fab fa-linkedin"></span>
							</div>
						</div>	
						<form class="form-contact form-login" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
							<h2 class="title">Fale connosco</h2>
							<div class="inputs">
								<div class="input">
									<label for="contact_name">Nome </label>
									<input required  autofocus value="<?php echo $name_error ?? ""; ?>"type="text" name="contact_name" id='contact_name' placeholder="Digite teu nome">
								</div>
								<div class="input">
									<label for="email">E-mail</label>
									<input required  autofocus value="<?php echo $email_error ?? ""; ?>"type="email" name="contact_email" placeholder="Digite teu email">
								</div>
								<div class="input">
									<label for="telefone">Telefone</label>
									<input required  autofocus value="<?php echo $telefone_error ?? ""; ?>"type="text" name="contact_telefone" placeholder="Digite teu contacto telefonico">
								</div>
								<div class="input">
									<label for="subject">Assunto</label>
									<textarea id="subject" name="contact_subject" required  autofocus value="Ola" placeholder="Digite o assunto"></textarea>
									
								</div>
								<div class="btns">
									<button  type='submit' class="btn" name="enviar">Enviar</button>
									<a class="btn" href="//localhost/recruta.com">Cancelar</a>
								</div>
								<?php 
									if(isset($_POST['enviar'])):
								 ?>
								<div class="input error">
								<?php 
									if(!empty($error)):
										foreach ($error as $erro):
										
								?>
											<p class="error-error"><?php echo $erro; ?><span class="fa fa-times"></span></p>
								<?php 
										endforeach;
									else: 
										if(isset($sucess) and !empty($sucess)):

								?>
											<p class="error-success"><?php echo $sucess ?><span class="fa fa-check"></span></p>

								<?php 
										endif;
									endif;
								endif;

								?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
		
	
 <?php 
	require_once '../../config/footer.php';
	
 ?>
 