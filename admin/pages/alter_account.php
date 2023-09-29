

<?php 
	require_once '../../config/setup.php';
	require_once '../../config/header.php';
	if((!isset($_SESSION['email']) or empty($_SESSION['email'])) and (!isset($_SESSION['pass']) or empty($_SESSION['pass']))):
		close_session();
	else:
		$id = 0;
		$email = $_SESSION['email'];
		$pass = $_SESSION['pass'];
		$sql ="select * from tb_admin where email='$email' and password='$pass'";
		$name = $con->query($sql)->fetch_assoc();
		if(Account_Exists($con,$sql)!==true):
			close_session();
		else:
			if(isset($_GET['id_admin'])):
			 	$id = base64_decode($con->real_escape_string($_GET['id_admin']));
			endif;
 			$sinal = 0;
 			if(isset($_POST['enter'])):
 				$error = "";
 				$id_admin = $_POST['id_admin'];
 				$id = $id_admin;
 				if($_POST['id_admin']):
 					if(isCampo($_POST['passblock']) === false):
 						$error = "Senha inválida";
 					else:
 						$passblock = md5($_POST['passblock']);
 					endif;

 					if(empty($error) and (isset($error))):
 						if(isEqualPass($pass,$passblock)):
 							$sql = "select * from tb_admin where id='$id_admin' and email='$email' and password='$passblock'";
 							$datos = $con->query($sql)->fetch_assoc();
 							$sinal = 1;
 						else:
 							$error = 'Senha inválida';
 						endif;
 					else:
 					 	if(!empty($error) and isset($error)):
 					 		$pass_error = $_POST['passblock'];
 					 	endif;
 					 endif;
 							
 				
 				else:
 					//close_session();
 					echo "Sem Id";
 				endif;
 			else:
 				$sinal = 0 ;
 			endif;




 			if(isset($_POST["actualizar"])):
 				$sinal = 1;
		 		$errors = array();
				
				if(!isWord($_POST['name'])){
					
					$errors[] = "Nome inválido<br>";
				}if(!isEmail($_POST['email'])){
					
					$errors[] = "Email inválido<br>";
				}if(isCampo($_POST['pass']) and isCampo($_POST["passconfirm"])){
					if(!isEqualPass($_POST['pass'],$_POST['passconfirm'])){
						$errors[] = "A senha digitadas são diferentes";
						
					}
				}else{

					 $errors[] = "Senha inválida<br>";
				}


				if(empty($errors) and isset($errors)){
					$name = $_POST['name'];
					$email = $_POST['email'];
					$pass = $_POST['pass'];
					$id_admin = $_POST['id_admin'];
					$sql = "update  tb_admin set name='$name', email='$email',  password='$pass' where id='$id_admin';";
					if($con->query($sql)===true){
						$_SESSION['email'] = $email;
						$_SESSION['pass'] = $pass;
						header("location://localhost/recruta.com/admin/pages/perfil_admin.php");
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
 	<title>UnitelRecru - admin - Alterar o admin</title>
 		<link rel="stylesheet" type="text/css" href="../../public/css/style.css">
 		<script type="text/javascript" defer src="../../public/js/recruta.js"></script>
</head>
<body>
	<div class="big-container">
		
		
	<header>
			<div class="container">
				<a class="logo" href="//localhost/recruta.com/admin"><h1><p class="logo-mark">U<span class="logo-markR">R</span></p>Unitel<span class="R">Recru.</span>Admin</h1></a>
				<form class="search" autocomplete="off">
					<label for="search"><span class="fa fa-search"></span></label>
					<input type="text" name="search-all" id="search" placeholder="Pesquisar...">
					
				</form>
				<nav class="menu-bars">
					<ul class="menu">
						<li><a href="//localhost/recruta.com/admin">Página inicial</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/to_anounce.php">Anúnciar</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/anounces.php">Anúncios</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/candidato.php">Candidatos</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/message.php">Mensagens</a></li>
						<li class="login logout" class="active"><span class="fa fa-power-off"></span>
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

							if(isset($sinal) and $sinal === 0):

					 ?>
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="container-code form-login" style="display: flex; z-index: 200; background: rgba(0, 0, 0, .8);">
						<div class="code-body" style="margin-top: -8rem;">
							<h4 class="code-title" style="font-size: 1.2rem; font-weight: normal; text-align: center;">Para  de alterar a conta do admin tens de inserir a tua senha anterior</h4>
							<div class="input" style="width: 100%; display: flex; flex-direction: column; align-items:center; justify-content: center; margin: .8rem auto;">
								<input type="password" name="passblock" placeholder="Digite a senha" style="width: 60%; font-size: 1.2rem; padding: .4rem 1rem; border-radius: var(--radius); border: 1px solid rgba(0, 0, 0, .4); color: var(--second-color); text-align: center;" value="<?php echo $pass_error ?? ""; ?>">
								<input type="hidden" name="id_admin" value="<?php echo $id ?? ""; ?>">
							</div>
							<div class="btns">
								<input type="submit" name="enter" value="Entrar" class="btn">
								<a href="//localhost/recruta.com/admin "class="btn">Cancelar</a>
							</div>
							<?php 
									if(!empty($error) and isset($error)):

							 ?>
							<div class="input error">
								<p class="error-error"><?php echo $error; ?> <span class="fa fa-times"></span></p>
							</div>
							<?php 
									endif;

							 ?>
						</div>
					</form>
					<?php 
						endif;
					 ?>
		
					<h1 class="admin-title">Alterar conta do administrador</h1>
					<form class="form-login" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">

						<div class="input">
							<label for="adminemail">Alterar nome do administrador</label>
							<input type="text" name="name" id="adminemail" placeholder="Digite teu nme" value="<?php echo $datos['name'] ?? $name_error ?? ""; ?>">
						</div>
						<div class="input">
							<label for="adminemail">Alterar o e-mail do administrador</label>
							<input type="text" name="email" id="adminemail" placeholder="Digite teu e-mail" value="<?php echo $datos['email']??  $email_error ?? ""; ?>">
						</div>
						<div class="input">
							<label for="adminpass">Alterar a senha do administrador</label>
							<input type="password" name="pass" id="adminpass" placeholder="Digite tua nova senha" value="<?php echo$pass_error ?? ""; ?>">
						</div>
						<div class="input">
							<label for="adminpassconfirm">Senha de confirmação</label>
							<input type="password" name="passconfirm" id="adminpass" placeholder="Digite nova senha de confirmação" value="<?php echo  $passconfirm_error ?? ""; ?>">
							<input type="hidden" name="id_admin" value="<?php echo $id_admin ?? ""; ?>">
						</div>
									
						<div class="btns">
							<button type="submit" name="actualizar" class="btn">Actualizar</button>
							<a href="//localhost/recruta.com/admin" class="btn">Cancelar</a>
						</div>
						 <?php 
						 		if(isset($errors) and !empty($errors)):

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