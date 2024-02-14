<?php include_once '../../connect.php'; 
    
    //if we've been given information, insert it
    if( isset($_POST['add_report'])){
    $statement = $con->prepare('INSERT INTO reports (username, agency_name, cause_number, hours_performed, date_performed) VALUES (?,?,?,?,?)');
    $statement->bind_param('sssis',$_SESSION['username'],$_POST['agency_name'],$_POST['cause_number'],$_POST['hours_performed'],$_POST['date_performed']);
    $statement->execute();
    }


?>

<div>
    <input class="submenu-toggle" type="checkbox" id = "editcase-drawer-toggle" name="editcase-drawer-toggle">
    <label for="editcase-drawer-toggle" id="editcase-drawer-toggle-label">Click Here to Add Report</label>
    <div class="drawer-submenu">
        <form action="" method="POST">
            <?php include 'segments/agency_dropdown.php'; ?>
            <input type="text" name="cause_number" placeholder="cause_number" required>
            <input type ="number" name="hours_performed" placeholder="hours_performed" required>
            <label for="date_performed">Date Performed </label>
            <input type="date" name="date_performed" id="date_performed" required>
            <input type="submit" name="add_report" value="add_report">
        </form>
    </div>
</div>
