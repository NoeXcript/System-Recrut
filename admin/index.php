<?php 
	require_once '../config/setup.php';
	require_once '../config/header.php';


	if((!isset($_SESSION['email']) or empty($_SESSION['email'])) and (!isset($_SESSION['pass']) or empty($_SESSION['pass']))):
		close_session();
	else:
		$email = $_SESSION['email'];
		$pass = $_SESSION['pass'];
		
		$sql ="select * from tb_admin where email='$email' and password='$pass'";
		if(!Account_Exists($con,$sql) === true):
			close_session();
		else:
			if(isset($_GET['id_admin'])):
			 	$id = base64_decode($con->real_escape_string($_GET['id_admin']));
				$sinal = 0;
 				$sucess = "";
				
			endif;
 			if(isset($_POST['enter'])):
 				$error = "";
 				$id_admin = $_POST['id_admin'];
 				$sinal = 0;
 				$id = $id_admin;
 				if($_POST['id_admin']):
 					if(isCampo($_POST['passblock']) === false):
 						$error = "Senha inválida";
 					else:
 						$passblock = md5($_POST['passblock']);
 					endif;

 					if(empty($error) and (isset($error))):
 						if(isEqualPass($pass,$passblock)):
 							$sql = "delete from tb_admin where id='$id_admin' and email='$email' and password='$passblock'";
 							if($con->query($sql)){
 								$sucess = "A conta do administrador foi eliminar, terminará a sessão.";
 								$sinal = 1;
 								$con->query("alter table tb_admin AUTO_INCREMENT = 1;");
 								$sql = "select * from tb_admin where id='$id_admin' and email='$email' and password='$passblock'";
 							}else{
 								$error ="Error to detele ".$con->error;	
 							}
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
 			endif;


 			if(isset($_GET['id_admin_quit'])):
 				close_session();
 			endif;
		$name = $con->query($sql)->fetch_assoc();

 ?>
 	<title>UnitelRecru <?php echo $name["name"]; ?></title>
 	<link rel="stylesheet" type="text/css" href="../public/css/style.css">
 	<script type="text/javascript" defer src="../js/recruta.js"></script>
</head>
<body>
	<div class="big-container">
		<header>
			<div class="container">
				<a class="logo" href="//localhost/recruta.com/admin"><h1><p class="logo-mark">U<span class="logo-markR">R</span></p>Unitel<span class="R">Recru.</span>Admin</h1></a>
				<form class="search" autocomplete="off" style="visibility: hidden;">
					<label for="search"><span class="fa fa-search"></span></label>
					<input typ be="text" name="search-all" id="search" placeholder="Pesquisar...">
					
				</form>
				<nav class="menu-bars">
					<ul class="menu">
						<li><a href="//localhost/recruta.com/admin" class="active">Página inicial</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/to_anounce.php">Anúnciar</a></li>
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
				<div class="content" style="min-height: 600px;">
			<?php 

					if(isset($sinal) and $sinal === 0):

					 ?>
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="container-code form-login" style="display: flex; z-index: 200; background: rgba(0, 0, 0, .8);">
						<div class="code-body" style="margin-top: -8rem;">
							<h4 class="code-title" style="font-size: 1.3rem; font-weight: normal; text-align: center;">Para eliminar  a conta do admin tens de digitar a senha</h4>
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
						if(isset($sucess) and !empty($sucess)):

					 ?>
						<div class="container-code form-login" style="display: flex; z-index: 200; background: rgba(0, 0, 0, .8);">
							<div class="code-body" style="margin-top: -8rem;">
								<h4 class="code-title" style="font-size: 1.3rem; font-weight: normal; text-align: center;">
											<?php echo $sucess;?>
								 	
								 </h4>
								<div class="btns" style="justify-content: center; align-items:center; margin-top:1rem;">
									<a href="//localhost/recruta.com/admin "class="btn" style="padding: .4rem 2rem; align-self:center;">Ok!</a>
								</div>
							</div>
						</div>
					<?php 
						endif;
					 ?>

					<h2 class="admin-title">Nossas estatística anual</h2>
					<div class="info-statics">
						<div class="static static-admin">
							<h5 class="static-title">
								Nossos candidatos admitidos
							</h5>

							<div class="box-static">
									80%	
							</div>
						</div>
						<div class="static static-recuse">
							
							<h5 class="static-title">
								Nossos candidatos recusados
							</h5>
							<div class="box-static">
								20%
							</div>
						</div>
						<div class="static static-message-accept">
							<h5 class="static-title">
								Nossas mensagens aceitados
							</h5>
							<div class="box-static">
								60%
							</div>
						</div>
						<div class="static static-message-recuse">
							<h5 class="static-title">
								Nossas mensagesn recusadas
							</h5>	
							<div class="box-static">
								40%
							</div>
						</div>
					</div>
				</div>

			</div>		
		</section>
		
 <?php 
	require_once '../config/footer.php';
	endif;
endif;
 ?>