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
			
			if(isset($_GET['id_anounce'])):
				$id_delete = base64_decode($con->real_escape_string($_GET['id_anounce']));
				echo $id_delete;
				$sql = "delete  from tb_anounce where id='$id_delete'";
				if($con->query($sql)):
					header('location://localhost/recruta.com/admin/pages/anounces.php');
				else:
					header('location://localhost/recruta.com/admin');
				endif;
			endif;
		if(isset($_GET["key"])):
 			$key_search = base64_decode($con->real_escape_string($_GET["key"]));
 			$key_search = trim($key_search);
 		endif;
 		
 		if(isset($_POST['search'])):
 			$key = base64_encode($_POST['search']);
 			header("location://localhost/recruta.com/admin/pages/anounces.php?key='$key'");
 		endif;
			$name = $con->query($sql)->fetch_assoc();
		
 ?>
 	<title>UnitelRecru - admin - anúncios </title>
 	<link rel="stylesheet" type="text/css" href="../../public/css/style.css">
 	<script type="text/javascript" defer src="../../public/js/recruta.js"></script>
</head>
<body>
	<div class="big-container">
	
		<header>
			<div class="container">
				<a class="logo" href="//localhost/recruta.com/admin"><h1><p class="logo-mark">U<span class="logo-markR">R</span></p>Unitel<span class="R">Recru.</span>Admin</h1></a>
				<form class="search" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
					<label for="search"><span class="fa fa-search"></span></label>
					<input type="text" name="search" style="font-size: 1.1rem" id="search" placeholder="Pesquisar anúncios">
					
				</form>
				<nav class="menu-bars">
					<ul class="menu">
						<li><a href="//localhost/recruta.com/admin">Página inicial</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/to_anounce.php">Anúnciar</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/anounces.php" class="active">Anúncios</a></li>
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
					if(isset($key_search)):

						$sql  = "select * from tb_anounce where direcion like '%$key_search%' or title like '%key_search%' or subject like '$key_search' or email like '$key_search' order by date_anounce desc;";
						$result = $con->query($sql);
						if($result->num_rows ===0):
					?>
						
							
						
						<h2 class="admin-title" style=" font-size: 1.3rem; border-bottom: unset; text-align: center;">
								
								Não foi encontrado nenhum anúncio relaciona pesquisa de  <i style="color: var(--second-color); border-bottom: 1px solid var(--second-color); font-size: 1.6rem"><?php echo $key_search; ?></i>
						</h2>
						
					<?php 
						else:
					 ?>
					<h2 class="admin-title" style="font-size: 1.3rem;">
						Anúncio encontrado relaciona pesquisa de <i style="color: var(--second-color); border-bottom: 1px solid var(--second-color); font-size: 1.6rem"><?php echo $key_search; ?></i>
						</h2>
					<div class="table-container">
						<table class="table anuncios-table">
							<thead>
								<tr>
									<th width="200px">
									Título do anúncio
									</th>
									<th>Direcionado</th>
									<th>Mensagem</th>
									<th colspan="3">Acção</th>
								</tr>
							</thead>
							
							<tbody>
								<?php 

									while($reg = $result->fetch_assoc()):

								 ?>
								<tr>
									<td> <?php echo $reg['title'] ?></td>
									<td><?php echo $reg['direcion'] ?></td>
									<td>
										
										<?php
										 $count=0;
										  if(strlen($reg['subject']) > 20):
										 		for($count=0; $count<20; $count++){
										 			echo $reg["subject"][$count]; 
										 		}
										 else:
										 	 echo $reg['subject'];
										 endif;
										 ?> 
									</td>
									<td>
										<a class="btn" href="//localhost/recruta.com/admin/pages/to_anounce.php?id_anounce=<?php echo base64_encode($reg["id"]);?>">Alterar</a>
									</td>
									<td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/preview_anounce.php?id_anounce=<?php echo base64_encode($reg["id"]);?>">Visualizar</a>
									</td>
									<td>
										<a class="btn" href="//localhost/recruta.com/admin/pages/anounces.php?id_anounce=<?php echo base64_encode($reg["id"]);?>">Eliminar</a>
									</td>
								</tr>
								<?php 
									endwhile;

								 ?>
							</tbody>
						</table>
					</div>
					<?php 
					endif;
				else:
					 ?>


					<?php 
						$sql  = "select * from tb_anounce order by date_anounce desc;";
						$result = $con->query($sql);
						if($result->num_rows===0):
					?>
						<h2 class="admin-title">
							Anúncios postados
						</h2>
						<h2 class="admin-title" style=" font-size: 1.3rem; border-bottom: unset; text-align: center;">
								Nenhum anúncio postado
						</h2>
					<?php 
						else:
					 ?>
					<h2 class="admin-title">
							Anúncios postados
					</h2>
					<div class="table-container">
						<table class="table anuncios-table">
							<thead>
								<tr>
									<th width="200px">
									Título do anúncio
									</th>
									<th>Direcionado</th>
									<th>Mensagem</th>
									<th colspan="3">Acção</th>
								</tr>
							</thead>
							
							<tbody>
								<?php 

									while($reg = $result->fetch_assoc()):

								 ?>
								<tr>
									<td> <?php echo $reg['title'] ?></td>
									<td><?php echo $reg['direcion'] ?></td>
									<td>
										
										<?php
										 $count=0;
										  if(strlen($reg['subject']) > 20):
										 		for($count=0; $count<20; $count++){
										 			echo $reg["subject"][$count]; 
										 		}
										 else:
										 	 echo $reg['subject'];
										 endif;
										 ?> 
									</td>
									<td>
										<a class="btn" href="//localhost/recruta.com/admin/pages/to_anounce.php?id_anounce=<?php echo base64_encode($reg["id"]);?>">Alterar</a>
									</td>
									<td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/preview_anounce.php?id_anounce=<?php echo base64_encode($reg["id"]);?>">Visualizar</a>
									</td>
									<td>
										<a class="btn" href="//localhost/recruta.com/admin/pages/anounces.php?id_anounce=<?php echo base64_encode($reg["id"]);?>">Eliminar</a>
									</td>
								</tr>
								<?php 
									endwhile;

								 ?>
							</tbody>
						</table>
					</div>
					<?php 
					endif;
				endif;
					 ?>
				</div>
			</div>		
		</section>
		
 <?php 
	require_once '../../config/footer.php';
	endif;
endif;
 ?>