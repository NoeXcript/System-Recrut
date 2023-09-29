<?php 
	require_once '../../config/setup.php';
	require_once '../../config/header.php';
	if((!isset($_SESSION['email']) or empty($_SESSION['email'])) and (!isset($_SESSION['pass']) or empty($_SESSION['pass']))):
		close_session();
	else:
		$email = $_SESSION['email'];
		$pass = $_SESSION['pass'];
		
		$sql ="select * from tb_admin where email='$email' and password='$pass'";
		if(!Account_Exists($con,$sql) === true):
			close_session();
		else:
			if(isset($_POST["pub"])):
				$errors = array();
				$direcion = $_POST['category'];
				  
				if(!isWord($_POST['anounce_title'])):
					$errors [] = $direcion." digitado inválido <br>";
				endif;

				if(!isWord($_POST["anounce_message"])):
					$errors [] = "Mensagem inválida<br>";
				endif;

				if(empty($errors) and isset($errors)):
					$direcion = $_POST['category'];
					$title = $_POST['anounce_title'];
					$subject = $_POST['anounce_message'];
					switch(strtolower($direcion)):
						case 'mensagem':
							$sql_mensagem = "select * from tb_message where name='$title';";
							$result = $con->query($sql_mensagem);
							if($result->num_rows >= 1):
								$sql_datos  = $con->query($sql_mensagem)->fetch_assoc();
								$email_ = $sql_datos['email'];
								$sql_ = "select * from tb_anounce where direcion='$direcion' and title='$title' and subject='$subject' and email='$email_'";
								if($con->query($sql_)->num_rows>=1):
									$errors[] = 'Este anúncio já está disponivel no site<br>';
										$direcion_error = $_POST['category'];
										$title_error = $_POST['anounce_title'];
										$subject_error = $_POST['anounce_message'];
								else:
									$sql_ = "insert into tb_anounce values (null, '$direcion','$title','$subject','$email_',NOW())";
									if($con->query($sql_)):
										header("location://localhost/recruta.com/admin/pages/anounces.php");
										
									else:
										echo 'Error '.$con->error;
									endif;
								endif;

							else:
								$errors[] = " Não foi encontrado ".$title. " nas listas de mensagem";
								$direcion_error = $_POST['category'];
								$title_error = $_POST['anounce_title'];
								$subject_error = $_POST['anounce_message'];
							endif;
						break;
						case 'candidato':
							$sql_candidato = "select * from tb_candidato where name='$title'";
							$result = $con->query($sql_candidato);
							if($result->num_rows >=1 ):
								$sql_datos  = $result->fetch_assoc();
								$email_= $sql_datos['email'];
								$sql_= "select * from tb_anounce where direcion='$direcion' and title='$title' and subject='$subject' and email='$email_'";
									if($con->query($sql_)->num_rows>=1):
										$errors[] = 'Este anúncio já está disponivel no site<br>';
											$direcion_error = $_POST['category'];
											$title_error = $_POST['anounce_title'];
											$subject_error = $_POST['anounce_message'];
									else:
										$sql_= "insert into tb_anounce values (null, '$direcion','$title','$subject','$email_',NOW())";
										if($con->query($sql_)):
											header("location://localhost/recruta.com/admin/pages/anounces.php");
												
										else:
											echo 'Error '.$con->error;
										endif;
									endif;
							else:
								$errors[] = " Não foi encontrado ".$title. ' nas listas de candidato';
									$direcion_error = $_POST['category'];
									$title_error = $_POST['anounce_title'];
									$subject_error = $_POST['anounce_message'];
							endif;
						break;
						case 'empresa':
								$sql_= "select * from tb_anounce where direcion='$direcion' and title='$title' and subject='$subject';";
								if($con->query($sql_)->num_rows>=1):
									$errors[] = 'Este anúncio já está disponivel no site<br>';
									$direcion_error = $_POST['category'];
									$title_error = $_POST['anounce_title'];
									$subject_error = $_POST['anounce_message'];
								else:
									$sql_ = "insert into tb_anounce values (null, '$direcion','$title','$subject',null,NOW())";
									if($con->query($sql_)):
											header("location://localhost/recruta.com/admin/pages/anounces.php");
										
									else:
										echo 'Error '.$con->error;
									endif;
								endif;
										
						break;
					endswitch;
			else:
				if(!empty($errors) and isset($errors)):
					$direcion_error = $_POST['category'];
					$title_error = $_POST['anounce_title'];
					$subject_error = $_POST['anounce_message'];
				endif;
			endif;
		endif;



		if(isset($_POST["act"])):
			$errors = array();
			$direcion = $_POST['category'];
			$id_act = $_POST["id_alter"];
			if(!isWord($_POST['anounce_title'])):
				$errors [] = $direcion." digitado inválido <br>";
			endif;

			if(!isWord($_POST["anounce_message"])):
				$errors [] = "Mensagem inválida<br>";
			endif;

			if(empty($errors) and isset($errors)):
				$direcion = $_POST['category'];
				$title = $_POST['anounce_title'];
				$subject = $_POST['anounce_message'];
				switch(strtolower($direcion)):
					case 'mensagem':
						$sql_mensagem = "select * from tb_message where name='$title';";
						$result = $con->query($sql_mensagem);
						if($result->num_rows >= 1):
							$sql_datos  = $con->query($sql_mensagem)->fetch_assoc();
							$email_ = $sql_datos['email'];
							$sql_ = "select * from tb_anounce where direcion='$direcion' and title='$title' and subject='$subject' and email='$email_'";
							if($con->query($sql_)->num_rows>=1):
								$errors[] = 'Este anúncio já está disponivel no site<br>';
									$direcion_error = $_POST['category'];
									$title_error = $_POST['anounce_title'];
									$subject_error = $_POST['anounce_message'];
									$id_alter = $id_act;
							else:
								$sql_ = "update tb_anounce set direcion ='$direcion', title='$title',subject='$subject', date_anounce=NOW(), email='$emal_' where id='$id_act'";
								if($con->query($sql_)):
									header("location://localhost/recruta.com/admin/pages/anounces.php");
									$id_alter = $id_act;
									
								else:
									echo 'Error '.$con->error;
								endif;
							endif;

						else:
							$errors[] = " Não foi encontrado ".$title. ' nas listas de mensagem ';
							$direcion_error = $_POST['category'];
							$title_error = $_POST['anounce_title'];
							$subject_error = $_POST['anounce_message'];
							$id_alter = $id_act;
						endif;
					break;
					case 'candidato':
						$sql_candidato = "select * from tb_candidato where name='$title';";
						$result = $con->query($sql_candidato);
						if($result->num_rows >= 1):
							$sql_datos  = $con->query($sql_candidato)->fetch_assoc();
							$email_= $sql_datos['email'];
							$sql_= "select * from tb_anounce where direcion='$direcion' and title='$title' and subject='$subject' and email='$email_'";
								if($con->query($sql_)->num_rows>=1):
									$errors[] = 'Este anúncio já está disponivel no site<br>';
										$direcion_error = $_POST['category'];
										$title_error = $_POST['anounce_title'];
										$subject_error = $_POST['anounce_message'];
										$id_alter = $id_act;
								else:
									$sql_ = "update tb_anounce set direcion ='$direcion', title='$title',subject='$subject', date_anounce=NOW(), email='$email_' where id='$id_act'";
									if($con->query($sql_)):
										header("location://localhost/recruta.com/admin/pages/anounces.php");
											
									else:
										echo 'Error '.$con->error;
									endif;
								endif;
						else:
							$errors[] = " Não foi encontrado ".$title. ' nas listas de candidato';
							$direcion_error = $_POST['category'];
							$title_error = $_POST['anounce_title'];
							$subject_error = $_POST['anounce_message'];
							$id_alter = $id_act;
							$id_alter = $id_act;
						endif;
					break;
					case 'empresa':
							$sql_= "select * from tb_anounce where direcion='$direcion' and title='$title' and subject='$subject';";
							if($con->query($sql_)->num_rows>=1):
								$errors[] = 'Este anúncio já está disponivel no site<br>';
								$direcion_error = $_POST['category'];
								$title_error = $_POST['anounce_title'];
								$subject_error = $_POST['anounce_message'];
								$id_alter = $id_act;
							else:
								$sql_ = "update tb_anounce set direcion ='$direcion', title='$title',subject='$subject', date_anounce=NOW() where id='$id_act'";
								if($con->query($sql_)):
										header("location://localhost/recruta.com/admin/pages/anounces.php");
									
								else:
									echo 'Error '.$con->error;
								endif;
							endif;
									
					break;
				endswitch;
		else:
			if(!empty($errors) and isset($errors)):
				$direcion_error = $_POST['category'];
				$title_error = $_POST['anounce_title'];
				$subject_error = $_POST['anounce_message'];
				$id_alter = $id_act;
			endif;
		endif;
	endif;	


	if(isset($_POST["resp"])):
		$errors = array();
		$direcion = $_POST['category'];
		$id_ans = $_POST["id_answer"];
		if(!isWord($_POST['anounce_title'])):
			$errors [] = $direcion." digitado inválido <br>";
		endif;
		
		if(!isWord($_POST["anounce_message"])):
			$errors [] = "Mensagem inválida<br>";
		endif;
		if($direcion!=="Mensagem"):
			$errors[] = "Direcção inserida inválida";
		endif;

		if(empty($errors) and isset($errors)):
			$direcion = $_POST['category'];
			$title = $_POST['anounce_title'];
			$subject = $_POST['anounce_message'];		
			
			$sql_mensagem = "select * from tb_message where name='$title';";
			$result = $con->query($sql_mensagem);
			
			if($result->num_rows >= 1):
				$sql_datos  = $con->query($sql_mensagem)->fetch_assoc();
				$email_ = $sql_datos['email'];
				$sql_ = "select * from tb_anounce where direcion='$direcion' and title='$title' and subject='$subject' and email='$email_'";
				if($con->query($sql_)->num_rows>=1):
					$errors[] = 'Este anúncio já está disponivel no site<br>';
					$direcion_error = $_POST['category'];
					$title_error = $_POST['anounce_title'];
					$subject_error = $_POST['anounce_message'];
					$id_answer = $id_ans;
				else:
					$sql_ = "insert into tb_anounce values (null,'$direcion','$title','$subject','$email_',NOW())";
					if($con->query($sql_)):
						header("location://localhost/recruta.com/admin/pages/anounces.php");
							$id_answer = $id_ans;
					else:
						echo 'Error '.$con->error;
					endif;
				endif;
			else:
				$errors[] = " Não foi encontrado ".$title. ' nas listas de mensagem ';
				$direcion_error = $_POST['category'];
				$title_error = $_POST['anounce_title'];
				$subject_error = $_POST['anounce_message'];
				$id_answer = $id_ans;
			endif;		
		else:
			if(!empty($errors) and isset($errors)):
				$direcion_error = $_POST['category'];
				$title_error = $_POST['anounce_title'];
				$subject_error = $_POST['anounce_message'];
				$id_answer = $id_ans;
			endif;
		endif;
	endif;	


	if(isset($_GET['id_anounce'])):
		$id_anounce = base64_decode($con->real_escape_string($_GET["id_anounce"]));
		$sql_datos = "select * from tb_anounce where id='$id_anounce'";
		if(!$con->query($sql_datos)===true):
			header('location://localhost/recruta.com/admin');
		else:
			$datos = $con->query($sql_datos)->fetch_assoc();
		endif;
	endif;

	if(isset($_GET['id_anounce_answer'])):
		$id_anounce_answer = base64_decode($con->real_escape_string($_GET["id_anounce_answer"]));
		$sql_datos_answer = "select * from tb_message where id='$id_anounce_answer'";
		if(!$con->query($sql_datos_answer)===true):
			header('location://localhost/recruta.com/admin');
		else:
			$datos_answer = $con->query($sql_datos_answer)->fetch_assoc();
		endif;
	endif;
		$name = $con->query($sql)->fetch_assoc();

 ?>
 	<title>UnitelRecru - admin - anunciar</title>
 	<link rel="stylesheet" type="text/css" href="../../public/css/style.css">
 	<script type="text/javascript" defer src="../../public/js/recruta.js"></script>
</head>
<body>
	<div class="big-container">
	
		<header>
			<div class="container">
				<a class="logo" href="//localhost/recruta.com/admin"><h1><p class="logo-mark">U<span class="logo-markR">R</span></p>Unitel<span class="R">Recru.</span>Admin</h1></a>
				<form class="search" autocomplete="off" style="visibility: hidden;">
					<label for="search"><span class="fa fa-search"></span></label>
					<input type="text" name="search-all" id="search" placeholder="Pesquisar...">
					
				</form>
				<nav class="menu-bars">
					<ul class="menu">
						<li><a href="//localhost/recruta.com/admin">Página inicial</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/to_anounce.php" class="active">Anúnciar</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/anounces.php">Anúncios</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/candidato.php">Candidatos</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/message.php">Mensagens</a></li>
						<li class="login logout"><span class="fa fa-power-off"></span>
							<div class="logout-container">
									<a href="//localhost/recruta.com/admin/pages/perfil_admin.php" class="logout">Perfil do admin</a>
								<a href="//localhost/recruta.com/admin/pages/alter_account.php?id_admin=<?php echo base64_encode($name['id']);?>" 
									class="logout">Alterar o admin</a>
								<a href="//localhost/recruta.com/admin?id_admin=<?php echo base64_encode($name['id']);?>"class="logout">Eliminar o admin</a>
								<a href="//localhost/recruta.com/admin?id_admin_quit=<?php echo base64_encode($name['id']);?>" class="logout">Sair do admin</a>
							</div>
							
						</li>
					</ul>
				</nav>
			</div>
		</header>
		<section>
			<div class="container">
				<div class="content">

					<?php 
					if(isset($_POST["id_alter"]) or isset($_GET['id_anounce'])): ?>
						<h2 class="admin-title">
								Informações para actualizar.
								
						</h2>
					<?php
						else:
							if(isset($_POST['id_answer']) or isset($_GET['id_anounce_answer'])):
					?>
						<h2 class="admin-title">
							Informações para anunciar à  <?php echo $datos_answer['name'] ?? $title_error ?? " "; ?>.
						</h2>
					<?php 
						else:
					?>
						<h2 class="admin-title">
								Informações para anunciar.
						</h2>
					<?php
							endif;
						endif;
					?>			
					
					<form class="form-anunciar form-login" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
						<div class="input">
							<?php 
								if(isset($_POST['id_answer']) or isset($_GET['id_anounce_answer'])):

							 ?>
							<label for="anounce_category">Direcionado para</label>
							<select name="category" id="category" required autofocus>
								
								<option value="Mensagem">Mensagem</option>
							</select>
						<?php else: ?>
							<label for="anounce_category">Direcionado para</label>
							<select name="category" id="category" required autofocus>
								<option value="Empresa">Empresa</option>
								<option value="Candidato">Candidato</option>
								<option value="Mensagem">Mensagem</option>
							</select>
						<?php endif; ?>
						</div>
						<div class="input">
							<?php 
								if(isset($_POST['id_answer']) or isset($_GET['id_anounce_answer'])):

							 ?>
							<label for="anounce_title">Nome do distinatário</label>
							<input required type="text" name="anounce_title" id="anounce_title" placeholder="Titulo do anúncio" required value="<?php echo $datos_answer['name'] ??  $title_error ?? ""; ?>">
						<?php else: ?>
							<label for="anounce_title">Titulo do anúncio</label>
							<input required type="text" name="anounce_title" id="anounce_title" placeholder="Titulo do anúncio" required value="<?php echo $title_error ?? $datos['title'] ?? ""; ?>">
						<?php endif; ?>

						</div>
						<div class="input">
							<?php 
								if(isset($_POST['id_answer']) or isset($_GET['id_anounce_answer'])):
							 ?>
							<label for="anounce_message">Mensagem</label>
							<textarea  required autofocus id="anounce_message" name="anounce_message" placeholder="Mensagem para <?php echo $datos_answer['name'] ?>" ><?php echo $subject_error ?? $datos['subject'] ?? "" ?></textarea>
							<input type="hidden" name="id_answer" value="<?php echo $datos_answer["id"]  ??""; ?>">
							<?php else: ?>
							<label for="anounce_message">Mensagem</label>
							<textarea  required autofocus id="anounce_message" name="anounce_message" placeholder="Mensagem para anúncio" ><?php echo $subject_error ?? $datos['subject'] ?? "" ?></textarea>
							<?php 
								if(isset($_POST['id_answer']) or isset($_GET['id_anounce_answer'])):

							 ?>
							<input type="text" name="id_alter" value="<?php echo $datos["id"] ?? $id_alter ?? ""; ?>">
							<?php endif; endif; ?>
						</div>
						<div class="btns">
							<?php if(isset($_POST["id_alter"]) or isset($_GET['id_anounce'])):
									
								?>
							<button type="submit" name="act" class="btn btn-admin">Actualizar</button>
							<?php
									else:
										if(isset($_POST['id_answer']) or isset($_GET['id_anounce_answer'])):
							?>
						
								<button type="submit" name="resp" class="btn btn-admin">Enviar</button>
							<?php
								else:
							?>
								<button type="submit" name="pub" class="btn btn-admin">Publicar</button>
							
							<?php
									endif;
								endif;
							?>
							<a class="btn btn-admin" href="//localhost/recruta.com/admin">Cancelar</a>
						</div>
						<?php 
								if(!empty($errors) and isset($errors)):
						 ?>
							<div class="input error">
								<?php 

										foreach($errors as $error):
								 ?>
								 		<p class="error-error"><?php echo $error; ?><span class="fa fa-times"></span></p>
								 <?php 

								 	endforeach;
								  ?>
							</div>
						<?php 
							endif;
						 ?>
					</form>
				</div>
			</div>			
		</section>
 <?php 
	require_once '../../config/footer.php';
	endif;
endif;
 ?>