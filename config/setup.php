<?php 
	function createTable($con, $sql){
		if(!$con->query($sql))
			echo 'Fail to create table '.$con->error.'<br>';
	}
	function createDB($con,$sql){
		if($con->query($sql))
			$con->select_db('db_system_recruta');
		else
			echo 'Fail to create database '.$con->error.'<br>';		
	}
	
	function isCampo (string $nome):bool{
			if(!empty($nome) and strlen($nome)>=4):
				return true;
			else:
				return false;
			endif;

	}
	function isEmail(string $email):bool{
		$email = filter_var($email,FILTER_SANITIZE_EMAIL);
		return (isCampo($email) === true) and (!filter_var($email,FILTER_VALIDATE_EMAIL) === false);
	}
	function isEqualPass(string $first_pass, string $second_pass):bool{
		return ($first_pass===$second_pass);
	}

	function isWord(string $word):bool{
		$word = trim($word);
		$word = filter_var($word,FILTER_SANITIZE_STRING);
		return isCampo($word);
	}
	
	function Account_Exists($con, $sql):bool{
		$result = $con->query($sql);
		return ($result->num_rows === 1);
	}

	function limparWord(string $word):string{
		$word = stripslashes($word);
		$word = htmlentities($word);
	}

	function close_session(){
		session_unset();
		session_destroy();
		header("location://localhost/recruta.com");
	}

	function make_code($con):string{
		$code = base64_encode(rand(1000,10000));
		$new_code="";

		$x = 0; 
		for(;$x<strlen($code);$x++){
			if($code[$x]==="=") continue;
			$new_code .=$code[$x];
		}
		if(check_code($new_code, $con)===true):
			make_code($con);
		else:
			return $new_code;
		endif;
	}

	function check_code(string $code, mysqli $con):bool{

			$code = md5($code); 
			$sql = "select * from tb_candidato where anounce_code='$code'";
			$result = $con->query($sql);
			if($result->num_rows>=1):
				return true;
			else:
				return false;
			endif;
	}

	function isPhone(string $number):bool{
		$num = false;
		$count=0;
		if(strlen($number)===13 and strpos($number,'+')===0):
			$count = 1;
		
			for(;$count<strlen($number); $count++):
				if(!is_numeric($number[$count])===1):
					$num = false;
					break;
				else:
					$num = true;
				endif;
			endfor;
		else:
			if(strlen($number)===9):
				for(;$count<strlen($number); $count++):
					if(!is_numeric($number[$count])===1):
						$num = false;
						break;
					else:
						$num = true;
					endif;
				endfor;
			endif;
		endif;

		return $num;

	}
	function isNome(string $nome):bool{
		$n = false;

		$count = 0;
		for(;$count<strlen($nome);$count++){
			if(is_numeric($nome[$count])):
				$n =  false;
				break;
			else:
				$n = true;
			endif;
		}

		return $n;
	}


	function isBI(string $bi):bool{
		$b = false;
		if(strlen($bi)===14):
			
			$count=0;
			$letra = 0;
			for(;$count<strlen($bi);$count++):
				if(!is_numeric($bi[$count])):
					$letra++;
				endif;
			endfor;
			if($letra===2):
				$b = true;
			endif;
		endif;
		return $b;
	}


	$con = new mysqli('localhost','root','');
	
	if($con->connect_error):
		die('Error to connect to mysql server '.$con->connect_error);
	else:

			$sql = 'create database if not exists db_system_recruta;';
			createDB($con,$sql);
		
			$sql = 'create table if not exists tb_admin('.
					'id int not null auto_increment primary key,'.
					'name varchar(255) not null,'.
					'email varchar(255) not null,'.
					'password varchar(255) not null);';
			createTable($con,$sql);
			
			$sql = 'create table if not exists tb_candidato('.
					'id int not null auto_increment primary key,'.
					'name varchar(255) not null,'.
					'telefone varchar(255) not null unique,'.
					'email varchar(255) not null unique,'.
					'ib_number varchar(255) not null unique,'.
					'job varchar(255) not null,'.
					'status int default 0,'.
					'anounce_code varchar(255) not null)';
			createTable($con,$sql);
		

			$sql = 'create table if not exists tb_message('.
					'id int not null auto_increment primary key,'.
					'name varchar(255) not null,'.
					'email varchar(255) not null,'.
					'subject text not null,'.
					'phone varchar(20) not null,'.
					'status  int default 0,'.
					'date_anounce datetime not null,'.
					'unique (name,email,phone));';
			
			createTable($con,$sql);

			$sql = 'create table if not exists tb_anounce('.
					'id int not null auto_increment primary key,'.
					'direcion varchar(25) not null,'.
					'title varchar(255) not null,'.
					'subject text not null,'.
					'email varchar(255),'.
					'date_anounce datetime not null)';
			
			createTable($con,$sql);
	endif;

	session_start();
 ?>