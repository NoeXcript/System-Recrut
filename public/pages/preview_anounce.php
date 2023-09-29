<?php 
	require_once '../../config/setup.php';
	require_once '../../config/header.php';

	if(!isset($_GET['id_anounce'])):
		header("location://localhost/recruta.com");	
	else:
		$id_anounce = base64_decode($con->real_escape_string($_GET['id_anounce']));
		$sql_anounce = "select * from tb_anounce where id='$id_anounce';";
		if(!$con->query($sql_anounce)):
			header("location://localhost/recruta.com/admin");
			//echo "Error ".$con->error;
		else:
			$sql_anounce = $con->query($sql_anounce)->fetch_assoc();
			
 ?>
 	<title>UnitelRecru - Anounce</title>
 	<link rel="stylesheet" type="text/css" href="../../public/css/style.css">
 	<script type="text/javascript" src="../js/recruta.js" defer></script>
</head>
<body>
	<div class="big-container">
		<header>
			<div class="container">
				<a class="logo" href=""><h1><p class="logo-mark">U<span class="logo-markR">R</span></p>Unitel<span class="R">Recru.</span></h1></a>
				<form class="search" autocomplete="off" style="visibility:hidden;">
					<label for="search"><span class="fa fa-search"></span></label>
					<input type="text" name="search-all" id="search" placeholder="Pesquisar...">
					
				</form>
				<nav class="menu-bars">
					<ul class="menu">
						<li><a href="../../">Página inicial</a></li>
						<li><a href="anounce.php" class="active">Anúncios</a></li>
						<li><a href="recruta.php">Candidatar</a></li>
						<li><a href="contact.php">Contacto</a></li>
						<li><a href="about.php" >Sobre</a></li>
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
				<div class="content">
						<h2 class="admin-title">
							Anúncio direcionado à <?php echo $sql_anounce['direcion']; ?>
						</h2>
						<div class="preview-body">
							<h2 class="title-preview" style="overflow-wrap: anywhere;">
								<?php echo $sql_anounce['title']; ?>
							</h2>
							<p class="preview-text" style="overflow-wrap:anywhere;">
								<?php echo $sql_anounce['subject'] ?>
							</p>
						</div>
					</div>
			</div>		
		</section>
		
 <?php 
	require_once '../../config/footer.php';
	endif;
endif;
 ?>