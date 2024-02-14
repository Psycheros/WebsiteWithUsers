<?php include_once '../../connect.php'; 

#if user is giving us data, insert it
if( isset($_POST['add_representative'])){
    $statement = $con->prepare('INSERT INTO representatives (username, agency_name) VALUES (?,?)');
    $statement->bind_param('ss',$_POST['username'],$_POST['agency_name']);
    $statement->execute();
}

?>
<div>
    <input class="submenu-toggle" type="checkbox" id = "add-representatives-drawer-toggle" name="editcase-drawer-toggle">
    <label for="add-representatives-drawer-toggle" id="editcase-drawer-toggle-label">Click Here to Add Representatives</label>
    <div class="drawer-submenu">
        <form action="" method="POST">
            <?php include 'segments/username_dropdown.php'; ?>
            <?php include 'segments/agency_dropdown.php'; ?>
            <input type="submit" name="add_representative" value="add_representative">
    </form>
    </div>
</div>
