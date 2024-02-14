<?php include_once '../../connect.php'; 
    
    //provide agencies
    ////to do, limit agencies to ones user represents
    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX); 
    $statement = $con->prepare("SELECT agency_name FROM representatives WHERE username = ?");
    $statement->bind_param('s',$_SESSION['username']);
    $statement->execute();
    $result = $statement->get_result();

    $row = $result->fetch_assoc();

    echo '<datalist id="agency_name">';
    do{
        foreach ( $row as $item){
            echo '<option value="' . $item . '">' . $item . '</option>';
	}
    } while($row = $result->fetch_assoc());
    echo '</datalist>';
mysqli_report(MYSQLI_REPORT_ALL);

?>
<input list="agency_name" type="text" name="agency_name" placeholder="agency_name" required>
