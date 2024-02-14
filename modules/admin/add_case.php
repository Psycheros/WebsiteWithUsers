<?php 
    include_once '../../connect.php';
    //if they're giving us information
    if( isset($_POST['add_case'])){	
        #insert it
        $statement = $con->prepare('INSERT INTO cases(cause_number, first_name, last_name, total_hours,hours_served, due_date, notes) VALUES (?,?,?,?,?,?,?)');
	$statement->bind_param('sssiiss',$_POST['cause_number'],$_POST['first_name'],$_POST['last_name'],$_POST['total_hours'],$_POST['hours_served'], $_POST['due_date'],$_POST['notes']);
	$statement->execute();
    }
?>

<!--div limits checkbox to its siblings !-->
<div>
        <!--drawer handle!-->
	<input class="submenu-toggle" type="checkbox" id = "addcase-toggle-submenu" name="addcase-toggle-submenu"/>
	<label for="addcase-toggle-submenu" id="addcase-toggle-submenu-label">Click Here to Add Case</label>
	<!--drawer-->
        <div class="drawer-submenu">
		
                <!--information to be given!-->
		<form action="" method="POST">
			<input type="text" name="cause_number" placeholder="cause_number" required>
			<input type="text" name="first_name" placeholder="first_name" required>
			<input type="text" name="last_name" placeholder="last_name" required>
			<input type ="number" name="total_hours" placeholder="total_hours" required>
			<input type ="number" name="hours_served" placeholder="hours_served">
                        <label for="due_date"> Due Date </label>
			<input type ="date" name="due_date" id="due_date" required>
			<input type ="text" name="notes" placeholder="notes" required>
			<input type="submit" name="add_case" value="add_case">
		</form>
	</div>
</div>
