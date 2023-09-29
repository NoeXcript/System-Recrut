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
			if(!isset($_GET['id_message'])):
				header("location://localhost/recruta.com/admin");
				
			else:
				$id_message = base64_decode($con->real_escape_string($_GET['id_message']));
				$sql_message = "select * from tb_message where id='$id_message';";
				if(!$con->query($sql_message)):
					header("location://localhost/recruta.com/admin");
					//echo "Error ".$con->error;
				else:
					$message = $con->query($sql_message)->fetch_assoc();
					$name = $con->query($sql)->fetch_assoc();

 ?>
 	<title>UnitelRecru - <?php echo $message['name']; ?></title>
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
					<input typ be="text" name="search-all" id="search" placeholder="Pesquisar...">
					
				</form>
				<nav class="menu-bars">
					<ul class="menu">
						<li><a href="//localhost/recruta.com/admin">Página inicial</a></li>
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
				<div class="content">
					<h2 class="admin-title">
						Mensagem enviado por <?php echo $message['name']; ?>
					</h2>
					<div class="preview-header">
						<p> <?php echo $message['name']; ?></p>
						<p>+244 <?php echo $message['phone']; ?></p>
						<p><?php echo $message['email']; ?></p>
						<?php 
								if($message['status']==1):
						 ?>
						 		<p class="status green">
						 			Aprovado
						 		</p>
						 <?php 

						 		else:
						  ?>
						  	<p class="status red">
						 			Não aprovado
						 	</p>
						 	<?php 

						 		endif;
						 	 ?>
					</div>
					<div class="preview-body">
						<h2 class="title-preview">
							Corpo da mensagem.
						</h2>
						<p class="preview-text">
							<?php echo $message['subject']; ?>
						</p>
					</div>
				</div>

			</div>		
		</section>
		
 <?php 	
				require_once '../../config/footer.php';
			endif;
		endif;
	endif;
endif;
 ?>