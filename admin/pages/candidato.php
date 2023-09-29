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
			if(isset($_GET['id_aprovar'])):
				$id_aprovado = base64_decode($con->real_escape_string($_GET['id_aprovar']));
				$sql = "update tb_candidato set status=1 where id='$id_aprovado'";
				if($con->query($sql)):
					header('location://localhost/recruta.com/admin/pages/candidato.php');
				else:
					header('location://localhost/recruta.com/admin');
				endif;
			endif;
			if(isset($_GET['id_reprovar'])):
				$id_reprovar = base64_decode($con->real_escape_string($_GET['id_reprovar']));
				$sql = "update tb_candidato set status=2 where id='$id_reprovar'";
				if($con->query($sql)):
					header('location://localhost/recruta.com/admin/pages/candidato.php');
				else:
					header('location://localhost/recruta.com/admin');
				endif;
			endif;
			if(isset($_GET['id_delete'])):
				$id_delete = base64_decode($con->real_escape_string($_GET['id_delete']));
				echo $id_delete;
				$sql = "delete  from tb_candidato where id='$id_delete'";
				if($con->query($sql)):
					header('location://localhost/recruta.com/admin/pages/candidato.php');
				else:
					header('location://localhost/recruta.com/admin');
				endif;
			endif;
			$name = $con->query($sql)->fetch_assoc();

		if(isset($_GET["key"])):
 			$key_search = base64_decode($con->real_escape_string($_GET["key"]));
 			$key_search = trim($key_search);
 		endif;
 		
 		if(isset($_POST['search'])):
 			$key = base64_encode($_POST['search']);
 			header("location://localhost/recruta.com/admin/pages/candidato.php?key='$key'");
 		endif;
 ?>
 	<title>UnitelRecru-admin-candidatos</title>
 	<link rel="stylesheet" type="text/css" href="../../public/css/style.css">
 	<script type="text/javascript" defer src="../../public/js/recruta.js"></script>
</head>
<body>
	<div class="big-container">
	
		<header>
			<div class="container">
				<a class="logo" href="//localhost/recruta.com/admin"><h1><p class="logo-mark">U<span class="logo-markR">R</span></p>Unitel<span class="R">Recru.</span>Admin</h1></a>
				<form class="search" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
					<label for="search"><span class="fa fa-search"></span></label>
					<input type="text" name="search" id="search" placeholder="pesquisar candidato">
					
				</form>
				<nav class="menu-bars">
					<ul class="menu">
						<li><a href="//localhost/recruta.com/admin">Página inicial</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/to_anounce.php">Anúnciar</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/anounces.php">Anúncios</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/candidato.php" class="active">Candidatos</a></li>
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
						$sql = "select * from tb_candidato where  name like '%$key_search%' or telefone like '%$key_search%' or email like '%$key_search%' or ib_number like '%$key_search%' or job like '%$key_search%' or status like '%$key_search%' order by name asc;";
						$result = $con->query($sql);
						if($result->num_rows===0):
					?>
							<h2 class="admin-title" style="font-size: 1.3rem;">
							Canditura encontrado relaciona pesquisa de <i style="color: var(--second-color); border-bottom: 1px solid var(--second-color); font-size: 1.6rem"><?php echo $key_search; ?></i>
						</h2>
							<h2 class="admin-title" style=" font-size: 1.2rem; border-bottom: unset; text-align: center;">
								
								Nenhuma conditura foi encontrada  na relaciona pesquisa de  <i style="color: var(--second-color); border-bottom: 1px solid var(--second-color); font-size: 1.6rem"><?php echo $key_search; ?></i>
						</h2>
					<?php 
						else:
					 ?>
					 
						<?php 
							if($result->num_rows > 1):

						 ?>
						<h2 class="admin-title" style="font-size: 1.3rem;">
							Candituras encontrado relaciona pesquisa de <i style="color: var(--second-color); border-bottom: 1px solid var(--second-color); font-size: 1.6rem"><?php echo $key_search; ?></i>
						</h2>
						 <?php 
						 	else:
						  ?>
							<h2 class="admin-title" style="font-size: 1.3rem;">
							Canditura encontrado relaciona pesquisa de <i style="color: var(--second-color); border-bottom: 1px solid var(--second-color); font-size: 1.6rem"><?php echo $key_search; ?></i>
							</h2>
						  <?php 
						  	endif;
						   ?>
					
					<div class="table-container">
						
						<table class="table message-table">
							<thead>
								<tr>
									<th width="200px">Nome completo</th>
									<th>Telefone</th>
									<th>E-mail</th>
									<th>Número do BI</th>
									<th>Área da candidatura</th>
									<th>Estado</th>
									<th colspan="3">Acção</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									while($reg = $result->fetch_assoc()):
								 ?>
								<tr>
									<td><?php echo $reg["name"];?></td>
									<td>+244<?php echo $reg["telefone"];?></td>
									<td><?php echo $reg["email"];?></td>
									<td><?php echo $reg["ib_number"];?></td>
									<td>
										<?php echo $reg["job"]; ?>
									</td>
									<td>
										<?php 
												if($reg["status"]==0):
													echo "Arquivado";
												else:
													if($reg["status"]==1):
														echo "Aprovado";
													else:
														echo "Reprovado";
													endif;
												endif;
										 ?>
									</td>
									<?php 

											if($reg["status"]==0):

									 ?>
									<td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/candidato.php?id_aprovar=<?php echo base64_encode($reg["id"]);?>">Aprovar</a>
									</td>
									
									 <td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/candidato.php?id_reprovar=<?php echo base64_encode($reg["id"]);?>">Reprovar</a>
									</td>
									<?php 
										else:
											if($reg["status"]==2):	
									 ?>
									 <td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/candidato.php?id_aprovar=<?php echo base64_encode($reg["id"]);?>">Aprovar</a>
									</td>
									<?php 
										else: 
									 ?>
									  <td>
											<a class="btn"  href="//localhost/recruta.com/admin/pages/candidato.php?id_reprovar=<?php echo base64_encode($reg["id"]);?>">Reprovar</a>
									</td>
									<?php 
											endif;
										endif;
									 ?>

									<td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/candidato.php?id_delete=<?php echo base64_encode($reg["id"]); ?>">Eliminar</a>
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
						$sql = "select * from tb_candidato order by name asc;";
						$result = $con->query($sql);
						if($result->num_rows===0):
					?>
						<h2 class="admin-title">
					 		Candidatos inscrito
					 	</h2>
							<h2 class="admin-title" style=" font-size: 1.3rem; border-bottom: unset; text-align: center;">
								Nenhum candidato inscrito
						</h2>
					<?php 
						else:
					 ?>
					 	<h2 class="admin-title">
					 		Candidatos inscrito
					 	</h2>
					<div class="table-container">
						
						<table class="table message-table">
							<thead>
								<tr>
									<th width="200px">Nome completo</th>
									<th>Telefone</th>
									<th>E-mail</th>
									<th>Número do BI</th>
									<th>Área da candidatura</th>
									<th>Estado</th>
									<th colspan="3">Acção</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									while($reg =$result->fetch_assoc()):
								 ?>
								<tr>
									<td><?php echo $reg["name"];?></td>
									<td>+244<?php echo $reg["telefone"];?></td>
									<td><?php echo $reg["email"];?></td>
									<td><?php echo $reg["ib_number"];?></td>
									<td>
										<?php echo $reg["job"]; ?>
									</td>
									<td>
										<?php 
												if($reg["status"]==0):
													echo "Arquivado";
												else:
													if($reg["status"]==1):
														echo "Aprovado";
													else:
														echo "Reprovado";
													endif;
												endif;
										 ?>
									</td>
									<?php 

											if($reg["status"]==0):

									 ?>
									<td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/candidato.php?id_aprovar=<?php echo base64_encode($reg["id"]);?>">Aprovar</a>
									</td>
									
									 <td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/candidato.php?id_reprovar=<?php echo base64_encode($reg["id"]);?>">Reprovar</a>
									</td>
									<?php 
										else:
											if($reg["status"]==2):	
									 ?>
									 <td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/candidato.php?id_aprovar=<?php echo base64_encode($reg["id"]);?>">Aprovar</a>
									</td>
									<?php 
										else: 
									 ?>
									  <td>
											<a class="btn"  href="//localhost/recruta.com/admin/pages/candidato.php?id_reprovar=<?php echo base64_encode($reg["id"]);?>">Reprovar</a>
									</td>
									<?php 
											endif;
										endif;
									 ?>

									<td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/candidato.php?id_delete=<?php echo base64_encode($reg["id"]); ?>">Eliminar</a>
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
							
		</section>
		
 <?php 
	require_once '../../config/footer.php';
	endif;
endif;
 ?>