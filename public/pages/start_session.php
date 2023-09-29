

<?php 
	require_once '../../config/setup.php';
	require_once '../../config/header.php';


	if((!isset($_SESSION['email']) or empty($_SESSION['email'])) and (!isset($_SESSION['pass']) or empty($_SESSION['pass']))):
		close_session();
	else:
		$email = $_SESSION['email'];
		$pass = $_SESSION['pass'];
		$sql = "select * from tb_admin where email='$email' and password='$pass'";
		if(!Account_Exists($con,$sql)===true):
			close_session();
		else:
 ?>
		 	<title>UnitelRecru  - Iniciar Sessão</title>
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
							<h1 class="admin-title">Inicio de sessão com administrador</h1>
							<div class="form-login " style="justify-content: center; align-items: center;">
								<div class="btns" style="justify-content: center; align-items:center; margin-top: 10rem;">
									<a href="//localhost/recruta.com/admin" class="btn" style="padding: .4rem 1rem; font-size: 2rem; margin-right: 4rem;">Continuar</a>
									<a  href="//localhost/recruta.com" class="btn" style="padding: .4rem 1rem; font-size: 2rem;">Voltar</a>
								</div>
							</div>
						</div>
					</div>
				</section>
					
 <?php 
			require_once '../../config/footer.php';
 		endif;
	endif;
	
 ?>