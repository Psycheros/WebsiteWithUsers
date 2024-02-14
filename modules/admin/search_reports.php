<!--search !-->
<form action="" method="POST"> 
    <input type="text" name="cause_number" placeholder="cause number" required>
    <input type="submit" name="search_reports" value="search reports">
</form>

<?php include_once '../../connect.php'; 
//if they clicked search, do that
if( isset($_POST['search_reports'])){
    $statement = $con->prepare('SELECT * FROM reports WHERE cause_number = ?');
    $statement->bind_param('s',$_POST['cause_number']);
    $statement->execute();
    $result = $statement->get_result();

    $row = $result->fetch_assoc();

    echo "Search Results";
    foreach ($row as $key => $value){
	echo $key." : ";
    }
    
    echo '<div><input class="submenu-toggle" type="checkbox" id = "toggle-submenu" name="addcase-toggle-submenu" checked/>';
    echo '<div class="drawer-submenu">';
       
    do{
echo '<form action="" method="POST">';
	$i = 0;
        $string = "";
        foreach ( $row as $item){
		if($i == 0){
                    $string .= '<input type="text" name="username" placeholder="username" value="'.$item.'" readonly required>';
                }
                elseif($i == 1){
                    $string .= '<input type="text" name="agency_name" value="'.$item.'"required>';
                }
                elseif($i == 2){
                    $string .= '<input type="text" name="cause_number" value="'.$item.'" required>';
                }
                elseif($i == 3){
                    $string .= '<input type ="number" name="hours_performed" placeholder="hours_performed" value="'.$item.'" required>';
                }
                elseif($i == 4){
                    $string .= '<input type ="date" name="date_performed" placeholder="date_performed" value="'.$item.'">';
		}
		$i = $i + 1;
	}
	
	$string .= '<input type="submit" name="edit_report" value="edit_report"> </form>';
	echo $string;
	echo "<hr/>";
    } while($row = $result->fetch_assoc());
}
elseif( isset($_POST['edit_report']) ){
    $statement = $con->prepare('SELECT * FROM reports WHERE (cause_number = ?)');
	$statement->bind_param('s', $_POST['cause_number']);
	$statement->execute(); //executes the SQL with the value filled in
	$statement->store_result(); //stores results in the statement variable
	if ($statement->num_rows > 0){
		echo "success";
		$statement = $con->prepare('UPDATE reports SET username = ?, agency_name = ?, cause_number = ?, hours_performed = ?, date_performed = ? WHERE (cause_number = ?) AND (date_performed = ?)');
		$statement->bind_param('sssisss',$_SESSION['username'],$_POST['agency_name'], $_POST['cause_number'], $_POST['hours_performed'], $_POST['date_performed'], $_POST['cause_number'], $_POST['date_performed']);
		$statement->execute();
	}
}
?>
	</div>
</div>

