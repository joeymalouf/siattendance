<?php
    require_once("session.php");
        require_once("global_functions.php");
        $mysqli = db_connection();
	print_r($mysqli);
$input = '2018-02-22T22:22';

$date_time = strtotime($input);
$dt = date('Y-m-d H:i:s', $date_time);
print_r($dt."\n");                    
$c = "Chem 106";
$p = "ONeal";
$t = "Lecture Review";
$query = $mysqli->prepare("INSERT INTO Session (course, professor, type, date_time) VALUES (?,?,?,?)");
$query->bind_param("ssss", $c, $p, $t, $dt);
print_r($query);
$test = $query->execute();
print_r($query);
$results = get_result($query);
?>
