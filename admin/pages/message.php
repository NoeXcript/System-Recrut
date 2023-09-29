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
			if(isset($_GET['id_message_aprovado'])):
				$id_aprovado = base64_decode($con->real_escape_string($_GET['id_message_aprovado']));
				echo $id_aprovado;
				$sql = "update tb_message set status=1 where id='$id_aprovado'";
				if($con->query($sql)):
					header('location://localhost/recruta.com/admin/pages/message.php');
				else:
					header('location://localhost/recruta.com/admin');
				endif;
			endif;
			if(isset($_GET['id_message_delete'])):
				$id_delete = base64_decode($con->real_escape_string($_GET['id_message_delete']));
				echo $id_delete;
				$sql = "delete  from tb_message where id='$id_delete'";
				if($con->query($sql)):
					header('location://localhost/recruta.com/admin/pages/message.php');
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
 			header("location://localhost/recruta.com/admin/pages/message.php?key='$key'");
 		endif;
			$name = $con->query($sql)->fetch_assoc();

 ?>
 	<title>UnitelRecru - Admin - Messagens </title>
 	<link rel="stylesheet" type="text/css" href="../../public/css/style.css">
 	<script type="text/javascript" defer src="../../public/js/recruta.js"></script>
</head>
<body>
	<div class="big-container">
	
		<header>
			<div class="container">
				<a class="logo" href="//localhost/recruta.com/admin"><h1><p class="logo-mark">U<span class="logo-markR">R</span></p>Unitel<span class="R">Recru.</span>Admin</h1></a>
				<form class="search" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<label for="search"><span class="fa fa-search"></span></label>
					<input type="text" name="search" id="search" placeholder="pesquisar message..">
				</form>
				<nav class="menu-bars">
					<ul class="menu">
						<li><a href="//localhost/recruta.com/admin">Página inicial</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/to_anounce.php">Anúnciar</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/anounces.php">Anúncios</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/candidato.php">Candidatos</a></li>
						<li><a href="//localhost/recruta.com/admin/pages/message.php" class="active">Mensagens</a></li>
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
						$sql  = "select * from tb_message where name like '%$key_search%' or email like '%$key_search%' or subject like '%$key_search%' or phone like '%$key_search%' or status like '%$key_search%' order by date_anounce desc";
						$result = $con->query($sql);
						if($result->num_rows===0):
					?>
						<h2 class="admin-title" >
						Mensagens encontrado relaciona pesquisa de <i style="color: var(--second-color); border-bottom: 1px solid var(--second-color); font-size: 1.5rem"><?php echo $key_search; ?></i>
						</h2>
					
						<h2 class="admin-title" style=" font-size: 1.2rem; border-bottom: unset; text-align: center;">
								
								Nenhum mensagem foi encontrada  na relaciona pesquisa de  <i style="color: var(--second-color); border-bottom: 1px solid var(--second-color); font-size: 1.6rem"><?php echo $key_search; ?></i>
						</h2>
						
						
					<?php 
						else:
					 ?>
					
						<h2 class="admin-title" style="font-size: 1.4rem;">
						Mensagem encontrado relaciona pesquisa de <i style="color: var(--second-color); border-bottom: 1px solid var(--second-color); font-size: 1.6rem"><?php echo $key_search; ?></i>
					</h2>
					</h2>
					<div class="table-container">
						
						<table class="table message-table">
							<thead>
								<tr>
									<th width="200px">Nome</th>
									<th>Telefone</th>
									<th>E-mail</th>
									<th>Mensagem</th>
									<th>Estado</th>
									<th colspan="4">Acção</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									while($reg =$result->fetch_assoc()):
								 ?>
								<tr>
									<td><?php echo $reg["name"];?></td>
									<td>+244<?php echo $reg["phone"];?></td>
									<td><?php echo $reg["email"];?></td>
									<td>

										<?php
										 $count=0;
										  if(strlen($reg['subject']) > 30):
										 		for($count=0; $count<30; $count++){
										 			echo $reg["subject"][$count]; 
										 		}
										 else:
										 	 echo $reg['subject'];
										 endif;
										 ?> 
									</td>
									<td>
										<?php 
												echo $reg["status"]== 1 ? "Aprovado" : "Null";
										 ?>
									</td>
									<?php 

											if($reg["status"]==0):

									 ?>
									<td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/message.php?id_message_aprovado=<?php echo base64_encode($reg["id"]);?>">Aprovar</a>
									</td>
									<?php 

										endif;
									 ?>
									<td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/to_anounce.php?id_anounce_answer=<?php echo base64_encode($reg["id"]); ?>">Responder</a>
									</td>
									<td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/message.php?id_message_delete=<?php echo base64_encode($reg["id"]); ?>">Eliminar</a>
									</td>
									<td>
										<a class="btn" href="//localhost/recruta.com/admin/pages/preview_message.php?id_message=<?php echo base64_encode($reg["id"]); ?>">Visualizar</a>
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
						$sql  = "select * from tb_message order by date_anounce asc;";
						$result = $con->query($sql);
						if($result->num_rows===0):
					?>	
						<h2 class="admin-title">
							Mensagens recebidas.
						</h2>
							<h2 class="admin-title" style=" font-size: 1.3rem; border-bottom: unset; text-align: center;">
								Nenhum mensagem recebida
						</h2>
					<?php 
						else:
					 ?>
					 <h2 class="admin-title">
						Mensagens recebidas.
					</h2>
					<div class="table-container">
						
						<table class="table message-table">
							<thead>
								<tr>
									<th width="200px">Nome</th>
									<th>Telefone</th>
									<th>E-mail</th>
									<th>Mensagem</th>
									<th>Estado</th>
									<th colspan="4">Acção</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									while($reg =$result->fetch_assoc()):
								 ?>
								<tr>
									<td><?php echo $reg["name"];?></td>
									<td>+244<?php echo $reg["phone"];?></td>
									<td><?php echo $reg["email"];?></td>
									<td>

										<?php
										 $count=0;
										  if(strlen($reg['subject']) > 30):
										 		for($count=0; $count<30; $count++){
										 			echo $reg["subject"][$count]; 
										 		}
										 else:
										 	 echo $reg['subject'];
										 endif;
										 ?> 
									</td>
									<td>
										<?php 
												echo $reg["status"]== 1 ? "Aprovado" : "Null";
										 ?>
									</td>
									<?php 

											if($reg["status"]==0):

									 ?>
									<td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/message.php?id_message_aprovado=<?php echo base64_encode($reg["id"]);?>">Aprovar</a>
									</td>
									<?php 

										endif;
									 ?>
									<td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/to_anounce.php?id_anounce_answer=<?php echo base64_encode($reg["id"]); ?>">Responder</a>
									</td>
									<td>
										<a class="btn"  href="//localhost/recruta.com/admin/pages/message.php?id_message_delete=<?php echo base64_encode($reg["id"]); ?>">Eliminar</a>
									</td>
									<td>
										<a class="btn" href="//localhost/recruta.com/admin/pages/preview_message.php?id_message=<?php echo base64_encode($reg["id"]); ?>">Visualizar</a>
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