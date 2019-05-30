<?php
   function queryProfessors($selectedValue) {
        require_once("session.php");
    	require_once("global_functions.php");
    	$mysqli = db_connection();
	$query_professors = "SELECT name FROM Professor WHERE courseID = '".$selectedValue."'";
        $result_professors = $mysqli->query($query_professors);
        if ($result_professors && $result_professors->num_rows > 0) {
            while ($row = $result_professors->fetch_assoc()) {
                echo "<option value='".$row['name']."'>".$row['name']."</option>";
            }
        }
        else {
            echo 'bad';
        }
    }
    if (isset($_POST['courseID'])) {
	queryProfessors($_POST['courseID']);		
   }
?>
