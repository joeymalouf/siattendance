<?php

$id = $_GET['sessionid'];
echo $id;
$url = "https://turing.cs.olemiss.edu/~jlucas/test/SIAttendance/#/attendance/" . $id;
header("Location: " . $url);
die();
