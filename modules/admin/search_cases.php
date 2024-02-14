<!--search !-->
<form action="" method="POST"> 
    <input type="text" name="cause_number" placeholder="cause number" required>
    <input type="submit" name="search_cases" value="search cases">
</form>

<?php include_once '../../connect.php'; 
//if they clicked search, do that
if( isset($_POST['search_cases'])){
    $statement = $con->prepare('SELECT * FROM cases WHERE cause_number = ?');
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
       echo '<form action="" method="POST">';
    do{
	$i = 0;
        $string = "";
        foreach ( $row as $item){
		if($i == 0){
                    $string .= '<input type="text" name="cause_number" placeholder="cause_number" value="'.$item.'" readonly="yes" required>';
                }
                elseif($i == 1){
                    $string .= '<input type="text" name="first_name" placeholder="first_name" value="'.$item.'" required>';
                }
                elseif($i == 2){
                    $string .= '<input type="text" name="last_name" placeholder="last_name" value="'.$item.'" required>';
                }
                elseif($i == 3){
                    $string .= '<input type="number" name="total_hours" placeholder="total_hours" value="'.$item.'" required>';
                }
                elseif($i == 4){
                    $string .= '<input type="number" name="hours_served" placeholder="served_hours" value="'.$item.'" required>';
                }
                elseif($i == 5){
			$string .= '<label for="due_date"> Due Date </label><input type="date" name="due_date" id="due_date" value="'.$item.'"required>';
                }
                elseif($i == 6){
                    $string .= '<input type="text" name="notes" placeholder="notes" value="'.$item.'" required>';
		}
		$i = $i + 1;
	}
	$string .= '<input type="submit" name="edit_case" value="edit case"> </form>';
	echo $string;
	echo "<hr/>";
    } while($row = $result->fetch_assoc());
}
elseif( isset($_POST['edit_case']) ){
    $statement = $con->prepare('SELECT * FROM cases WHERE (cause_number = ?)');
	$statement->bind_param('s', $_POST['cause_number']);
	$statement->execute(); //executes the SQL with the value filled in
	$statement->store_result(); //stores results in the statement variable
	if ($statement->num_rows > 0){
		echo "success";
		if($statement = $con->prepare('UPDATE cases SET cause_number = ?, first_name = ?, last_name = ?, total_hours = ?, hours_served = ?, due_date = ?, notes = ? WHERE (cause_number = ?)')){
		$statement->bind_param('sssiisss',$_POST['cause_number'],$_POST['first_name'], $_POST['last_name'], $_POST['total_hours'], $_POST['hours_served'], $_POST['due_date'], $_POST['notes'], $_POST['cause_number']);
		$statement->execute();
		}
		else {
			echo "failedhmm";
		}
	}
}
?>
	</div>
</div>

