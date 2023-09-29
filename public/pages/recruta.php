<?php 
	require_once '../../config/setup.php';
	require_once '../../config/header.php';

	
	if(isset($_POST['cad'])):
		$errors = array();
		if(!isEmail($_POST['email'])):
			$errors [] = "Email inválido";
		endif;
		if(!isWord($_POST['full_name']) or !isNome($_POST["full_name"])):
			$errors [] = "Nome inválido";
		endif;
		if(!isWord($_POST['bi_number']) or !isBI($_POST['bi_number'])):
			$errors [] = "Numero de bilhete de identidade inválido";
		endif;
		if(!isWord($_POST['phone']) or !isPhone($_POST['phone'])):
			$errors [] = "Contacto Telefónico inválido";
		endif;
		if(!isWord($_POST['function'])):
			$errors [] = "Área de trabalho inválido";
		endif;

		if(empty($errors) and isset($errors)):
			$name = $_POST['full_name'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$bi = strtoupper($_POST['bi_number']);
			$job = $_POST['function'];

			$sql_check = "select * from tb_candidato where name='$name' and telefone='$phone' and email='$email' and ib_number='$bi'";
			$result_check = $con->query($sql_check);

			if($result_check->num_rows>=1):
				$errors [] = "A Empresa Unitel já possui está canditura inscrito";
				$name_error  = $_POST["full_name"];
				$email_error  = $_POST["email"];
				$bi_error  = $_POST["bi_number"];
				$job_error  = $_POST["function"];
				$phone_error  = $_POST["phone"];
			else:
				$code = make_code($con);
				$code_in = md5($code);
				$sql = "insert into tb_candidato values (null,'$name','$phone','$email','$bi','$job',0,'$code_in')";

				if($con->query($sql)):
					$sinal = 1;
				else:
					$errors [] = "Uns dos dados inserido  já foi usado, tente outro<br>";
					$name_error  = $_POST["full_name"];
					$email_error  = $_POST["email"];
					$bi_error  = $_POST["bi_number"];
					$job_error  = $_POST["function"];
					$phone_error  = $_POST["phone"];
				endif;
			endif;
		else:
			if(!empty($errors) and isset($errors)):
				$name_error  = $_POST["full_name"];
				$email_error  = $_POST["email"];
				$bi_error  = $_POST["bi_number"];
				$job_error  = $_POST["function"];
				$phone_error  = $_POST["phone"];
			endif;
		endif;
	endif;




 ?>
 	<title>UnitelRecru - Recrutamento</title>
 	<link rel="stylesheet" type="text/css" href="../../public/css/style.css">
 	<script type="text/javascript" src="../js/recruta.js" defer></script>
</head>
<body>
	<div class="big-container">
		<header>
			<div class="container">
				<a class="logo" href=""><h1><p class="logo-mark">U<span class="logo-markR">R</span></p>Unitel<span class="R">Recru.</span></h1></a>
				<form class="search" autocomplete="off" style="visibility: hidden;">
					<label for="search"><span class="fa fa-search"></span></label>
					<input type="text" name="search-all" id="search" placeholder="Pesquisar...">
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
						<li><a href="../../">Página inicial</a></li>
						<li><a href="anounce.php">Anúncios</a></li>
						<li><a href="recruta.php" class="active">Candidatar</a></li>
						<li><a href="contact.php">Contacto</a></li>
						<li><a href="about.php">Sobre</a></li>
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
					<h2 class="content-title">Informações do candidato</h2>
					<?php 
							if(isset($sinal) and $sinal==1):
					 ?>
						<div class="container-code">
							<div class="code-body">
								<h4 class="code-title">Código de acesso para teu anúnico</h4>
								<p class="code"><?php echo $code; ?></p>
								<a href="//localhost/recruta.com/public/pages/recruta.php" class="btn-code">OK</a>
							</div>
						</div>
						<?php 
							endif;
						 ?>
					<form class="recruta-dados" autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
							<div class="input">
								<label for="full_name">Nome completo </label> 
								<input type="text" name="full_name" placeholder="Digite teu nome" id="full_name" autofocus required value="<?php echo $name_error ?? ""; ?>">
							</div>
							<div class="input">
								<label for="phone">Telefone </label> 
								<input type="text" name="phone" placeholder="(+244)" id="phone" autofocus required minlength="9" 
								maxlength="14" value="<?php echo $phone_error ?? ""; ?>">
							</div>
							<div class="input">
								<label for="email">E-mail </label> 
								<input type="email" name="email" placeholder="Digite teu e-mail" id="email" autofocus required value="<?php echo $email_error ?? ""; ?>">
							</div>
							<div class="input">
								<label for="bi_namber">Número do BI </label> 
								<input type="text" name="bi_number" placeholder="Digite teu Nº do BI " id="bi_namber" autofocus required maxlength="14" value="<?php echo $bi_error ?? ""; ?>">
							</div>
							<div class="input">
								<label for="function">Área a candidatar </label> 
								     <select name="function" id="function" required>
                                           <option value="Limpeza">Limpeza</option>
                                           <option value="Recepecionista">Recepcionista</option>
                                           <option value="Area de Recurso humanno">Área de Recurso humano</option>
                                           <option value="Segurança">Segurança</option>
                                           <option value="Tecnico para TI">Técnico para TI</option>
                                           <option value="Tecnico de Electronico">Técnico de Electronico</option>
                                   </select>
							</div>
							<div class="btns">
								<button  type='submit' class="btn" name="cad">Enviar</button>
								<a  href="//localhost/recruta.com" class="btn">Cancelar</a>
							</div>
					</form>
					<?php 

							if(isset($errors) and !empty($errors)):
					 ?>
					<div class="form-login" style="width: 100%">
						<div class="input error" style="width: 60%;">
							<?php 
									foreach($errors as $error):
							 ?>
							<p class="error-error"><?php echo $error; ?><span class="fa fa-times"></span></p>
							<?php 
									endforeach;
							 ?>
						</div>
					</div>
					<?php 
						endif;
					 ?>
				</div>
			</div>
		</section>
 <?php 
	require_once '../../config/footer.php';
	
 ?>