<?php include_once '../../connect.php'; 
    ###to do, only admins can see everything
    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX); #I'm aware i'm referencing everything
    
    $result = $con->query("SELECT username FROM users;");
    $row = $result->fetch_assoc();

    echo '<datalist id="usernames">';
    do{
        foreach ( $row as $item){
		echo '<option value="' . $item . '">' . $item . '</option>';
	}
    } while($row = $result->fetch_assoc());

    echo '</datalist>';
    mysqli_report(MYSQLI_REPORT_ALL);
?>
<input type="text" list="usernames" placeholder="usernames" name="username" required/>
