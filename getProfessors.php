<?php
   function queryProfessors($selectedValue) {
        require_once("session.php");
    	require_once("global_functions.php");
    	$mysqli = db_connection();
	$query_professors = "SELECT professor FROM Class WHERE course = '".$selectedValue."'";
        $result_professors = $mysqli->query($query_professors);
        if ($result_professors && $result_professors->num_rows > 0) {
            while ($row = $result_professors->fetch_assoc()) {
                echo "<option value='".$row['professor']."'>".$row['professor']."</option>";
            }
        }
        else {
            echo 'bad';
        }
    }
    if (isset($_POST['course'])) {
	queryProfessors($_POST['course']);		
   }
?>
