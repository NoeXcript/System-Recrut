<?php 
	require_once 'config/setup.php';
	require_once 'config/header.php';

		if(isset($_GET['id_anounce']) or isset($_POST['id_anounce'])):
			if(isset($_GET['id_anounce'])):
			 	$id =  base64_decode($con->real_escape_string($_GET['id_anounce']));
			 endif;
 				$sinal = 0;
 			if(isset($_POST['enter'])):
 				$error = "";
 				$id_anounce = $_POST['id_anounce'];
 				$id = $id_anounce;
 				if(isset($_POST['id_anounce'])):
 					if(isCampo($_POST['passblock']) === false):
 						$error = "Código inválido";
 					else:
 						$passblock = md5($_POST['passblock']);
 					endif;

 					if(empty($error) and (isset($error))):
 						$sql = "select * from tb_anounce where direcion='Candidato' and id='$id_anounce'";
 						$result =  $con->query($sql);
 						if($result->num_rows===1):
 							$email = $result->fetch_assoc();
 							$email_valido = $email["email"];
 							$sql = "select * from tb_candidato where anounce_code='$passblock' and email='$email_valido';";
 							$result = $con->query($sql);
 							if($result->num_rows>=1):
 								$id = base64_encode($id_anounce);
 								header("location://localhost/recruta.com/public/pages/preview_anounce.php?id_anounce=$id");
 							else:
 								$error = 'Código inválido '.$con->error;
 							endif;
 						else:
 							header("location://localhost/recruta.com/");
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
 		else:
 			$sinal = 1;
 		endif;
 		if(isset($_POST['search'])):
 				$key = base64_encode($_POST['search']);
 				header("location://localhost/recruta.com/public/pages/client_result_search.php?key='$key'");
 		endif;
		
	
 ?>
 	<title>UnitelRecru</title>
 	<link rel="stylesheet" type="text/css" href="public/css/style.css">
 	<script type="text/javascript" defer src="public/js/recruta.js"></script>
</head>
<body>
	<div class="big-container">
		<header>
			<div class="container">
				<a class="logo" href="//localhost/recruta.com"><h1><p class="logo-mark">U<span class="logo-markR">R</span></p>Unitel<span class="R">Recru.</span></h1></a>
				<form class="search" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
					<label for="search"><span class="fa fa-search"></span></label>
					<input type="text"  style="font-size : 1.1rem;" name="search" id="search" placeholder="Pesquisar anúncios">
				</form>
				<nav class="menu-bars">
					<ul class="menu">
						<li><a href="//localhost/recruta.com" class="active">Página inicial</a></li>
						<li><a href="public/pages/anounce.php">Anúncios</a></li>
						<li><a href="//localhost/recruta.com/public/pages/recruta.php">Candidatar</a></li>
						<li><a href="//localhost/recruta.com/public/pages/contact.php">Contacto</a></li>
						<li><a href="//localhost/recruta.com/public/pages/about.php">Sobre</a></li>
						<li><a href="//localhost/recruta.com/public/pages/help.php">Ajuda</a></li>
						<li class="login"><a href="//localhost/recruta.com/public/pages/login.php"><span class="fa fa-user-circle"></span></a>
						</li>
					</ul>
				</nav>
			</div>
		</header>
		<section>
										
			<div class="container-sliders">
						<div class="slide fade">
							<div class="slide-title">
								Há sempre um lugar para cada angolano.
							</div>
							<div class="slide-text">
								Em média, a Unitel S.A anualmente realizar candidatura em todo território nacional.
							</div>
						</div>
						<div class="slide fade">
							<div class="slide-title">
								UnitelRecru.
							</div>
							<div class="slide-text">
								Plataforma Web, que ofereça a facilidade de qualquer cidadão angolano à uma candidatura para Empresa Unitel S.A sem deslocar do teu local. 
							</div>
						</div>
						<div class="slide fade">
							<div class="slide-title">
								UnitelRecru. Facilidade na em um click
							</div>
							<div class="slide-text">
									Se antes estava tão fácil candidar-se na Unitel e agora com um plataforma web?
							</div>
						</div>
						<div class="slide fade">
							<div class="slide-title">
							Unitel S.A
							</div>
							<div class="slide-text">
								Serviço online, ao seu dispor. UnitelRecru.
							</div>
						</div>
					</div>
			<div class="container">
				<?php 
					$sql = "select * from tb_anounce where direcion<>'Mensagem';";
					$result = $con->query($sql);

					if($result->num_rows>=1):
				?>
				
				<?php if(isset($sinal) and $sinal === 0):?> 	
						<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="container-code form-login" style="display: flex; z-index: 200; background: rgba(0, 0, 0, .9);">
							<div class="code-body" style="margin-top: -40rem;">
								<h4 class="code-title" style="font-size: 1.2rem; font-weight: normal; text-align: center;">Digite o teu código de acesso à anúncio direcionado a ti.</h4>
								<div class="input" style="width: 100%; display: flex; flex-direction: column; align-items:center; justify-content: center; margin: .8rem auto;">
									<input type="password" name="passblock" placeholder="Digite o código" style="width: 60%; font-size: 1.2rem; padding: .4rem 1rem; border-radius: var(--radius); border: 1px solid rgba(0, 0, 0, .4); color: var(--second-color); text-align: center;" value="<?php echo $pass_error ?? ""; ?>">
									<input type="hidden" name="id_anounce" value="<?php echo $id ?? ""; ?>">
								</div>
								<div class="btns" style="justify-content: center;">
									<input type="submit" name="enter" value="Ver anúncio" class="btn">
									<a href="//localhost/recruta.com/ "class="btn">Cancelar</a>
								</div>
								<?php if(!empty($error) and isset($error)):?>
								<div class="input error" style="margin-top: 1rem;">
									<p class="error-error" style="color: red; display:flex; align-items: center; font-size: 1.2rem; font-weight:bold;" ><?php echo $error; ?> <span class="fa fa-times" style="margin-left: .9rem;"></span></p>
								</div>
								<?php endif;?>
							</div>
						</form>
				<?php endif;?>
		
				
				<div class="anounces">
						<div class="empresa">
	<?php
						$sql = "select * from tb_anounce where direcion='Empresa' order by date_anounce desc limit 3;";
						$result = $con->query($sql);

						if($result->num_rows>=1):
	?>
							<h1 class="main-title">Últimos anúncios relativo a empresa</h1>
							<div class="anounces-empresa">
	<?php
								while($empresa = $result->fetch_assoc()):
	?>
									<div class="anounce-empresa">
										<h2 class="title"><?php echo $empresa['title'];?></h2>
										<p class="text" style="overflow-wrap: anywhere;">
	<?php
									if(strlen($empresa["subject"])>180):
										$count = 0;
										for(;$count<180; $count++):
											echo $empresa["subject"][$count];
										endfor;
									else:
										echo $empresa["subject"];
									endif;
	?>
									</p>
								<?php if(strlen($empresa["subject"])>180):?>
											<a class="btn btn-read-more" href="//localhost/recruta.com/public/pages/preview_anounce.php?id_anounce=<?php echo base64_encode($empresa['id']);?>">Ver mais &raquo;</a>
								<?php endif;?>
								</div>
					<?php endwhile;?>
							</div>
						<?php endif;?>
						</div>
	
						<div class="candidatos">
	<?php
						$sql = "select * from tb_anounce where direcion='Candidato' order by date_anounce desc limit 3;";
						$result = $con->query($sql);

						if($result->num_rows>=1):
	?>
							<h1 class="main-title">Últimos anúncios relativo á canditura</h1>
							
							<div class="anounces-candidato">
	<?php
							while($candidato = $result->fetch_assoc()):
	?>
								<div class="anounce-candidato">
									<h2 class="title">Sr.<?php echo $candidato['title'];?></h2>
									<p class="text" style="overflow-wrap: anywhere;">
	<?php
								if(strlen($candidato["subject"])>180):
									$count = 0;
									for(;$count<180; $count++):
										echo $candidato["subject"][$count];
									endfor;
								else:
									echo $candidato["subject"];
								endif;
	?>
									</p>
	<?php
									if(strlen($candidato["subject"])>180):
	?>
									<a class="btn btn-read-more" href="//localhost/recruta.com/?id_anounce=<?php echo base64_encode($candidato['id']);?>">Ver mais &raquo;</a>
									<?php
									endif;
								?>
								</div>
	<?php
							endwhile;
								
	?>
							</div>
	<?php
							endif;	
	?>
						</div>

					<a href="//localhost/recruta.com/public/pages/anounce.php" class="btn plus-cand-anounce">Mais Anúncios </a>		
				</div>				
				<?php else: ?>
					<div class="content">
						<h2 class="admin-title">
							Sem anúnicios postado
						</h2>
					</div>
				<?php endif; ?>
			</div>
			
		</section>

		
 <?php 
	require_once 'config/footer.php';
	
 ?>