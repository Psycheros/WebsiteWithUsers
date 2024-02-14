<?php include_once '../../connect.php'; 
    
    //provide agencies
    ////to do, limit agencies to ones user represents
    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX); 
    $result = $con->query("SELECT agency_name FROM agencies;");
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
