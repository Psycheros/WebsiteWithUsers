<?php
	session_start();
	include_once ('logging.php');
	include_once ('../../connect.php');

?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Insecure Home Page </title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<nav class="navtop">
			<div>
				<h1>Website Title</h1>
				<a href="logout.php"><i class="fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		
		<?php
			$statement = $con->prepare('SELECT username FROM representatives WHERE username = ? AND agency_name = "ADMIN"');
			if($statement){
				$statement->bind_param('s',$_SESSION['username']);
				$statement->execute();
				$result = $statement->get_result();
				
				if($result->num_rows > 0){
					include 'modules/admin.php';
				}
				else{
					include 'modules/general_user.php';
				}
			}
		?>
	</body>

		
