<?php
	include ('../../connect.php');
	include ('logging.php');
	
	$post_username = filter_input(INPUT_POST, 'username');
	$post_password = filter_input(INPUT_POST, 'password');
	$post_email = filter_input(INPUT_POST, 'email');
	
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
	
	/* //email not currently required
	elif ((!isset($post_email) || empty($post_email) || $postemail = false){
        $flagm = "email not set or invalid"
	}
	*/
	else{
		$statement = $con->prepare('SELECT password FROM users WHERE username = ?');
		if($statement){
			$statement->bind_param('s',$post_username);
			$statement->execute();
			$statement->store_result();
			
			if($statement->num_rows > 0){
				$flagm = "username already exists";
			}
			else{
				$statement = $con->prepare('INSERT INTO users (username,password) VALUE (?, ?)');
				
				if($statement){
					$password = password_hash($post_password, PASSWORD_DEFAULT);
					$uniquid = uniqid();
					$statement -> bind_param('ss',$post_username,$password);
					
					$statement->execute();
					$flagm = "You have successfully registered!";
				}
			}
		$statement->close();
		}
	}
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>register</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="register">
			<h1>Register</h1>
			<p> <?php echo $flagm; ?> </p>
			<form action="register.php" method="post" autocomplete="off">
				<label for="username">
					<i class="fas fa-user"> </i>
				</label>
				<input type="text" name="username" placeholder="username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="password" id="password" required>
				
				<input type="submit" value="Register">
				</form>
			<a href="./"> home </a>
		</div>
	</body>
</html>
