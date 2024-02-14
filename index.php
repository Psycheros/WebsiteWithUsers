<?php
	include 'logging.php';
	include '../../connect.php';
	
	session_start();
	if (isset($_SESSION['loggedin'])){
		header('Location: home.php');
		exit();
	}
	$post_username = filter_input(INPUT_POST, 'username');
	$post_password = filter_input(INPUT_POST, 'password');
	
	///I've left out username requirements
	//||preg_match('/^\S* (?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',post_username)
	if ( ((!isset($post_username)) || (empty($post_username))) == true ) {
		$flagm = "username not set";
	}
	// password requirements
	// preg_match('/^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W_])(?=\S{8,})\S*$/',$post_password)
	elseif ( ((!isset($post_password)) || (empty($post_password))) == true){
		$flagm = "password not set";
	}
	//if we do have all the information continue
	else{
		$statement = $con->prepare('SELECT password FROM users WHERE username =?');
		
		if($statement){
			$statement->bind_param('s',$post_username);
			$statement->execute();
			$statement->store_result();
			
			if ($statement->num_rows > 0) {
				$statement->bind_result($password);
				$statement->fetch();
				
				if (password_verify($post_password, $password)){
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['username'] = $post_username;
					header('Location:home.php');
					$statement->close();
					exit();
				}
				else{ $flagm = "wrong password"; }
			} else{ $flagm = "wrong username"; }
			
			$statement->close();
		}
		else { $flagm = "connection problem"; }
	}
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="Login">
			<h1> Login </h1>
			<form action="index.php" method = "post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" value="Login">
				<a href="register.php"> Register </a>
					<?php
						echo $flagm;
					?>
			</form>
		</div>
	</body>
</html>
