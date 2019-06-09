<?php

    require_once("/home/jlucas/public_html/test/SIAttendance/session.php");
    require_once("/home/jlucas/public_html/test/SIAttendance/global_functions.php");

    function createAttendance($uid, $sessionid) {
        $mysqli = db_connection();

        $query_attendance_exists = $mysqli->prepare("SELECT * FROM Attendance WHERE username = ? AND sessionid = ?");
        $query_attendance_exists->bind_param("si", $uid, $sessionid);
        $query_attendance_exists->execute();
        $result_attendance_exists = get_result($query_attendance_exists);
        if ($result_attendance_exists) {
            print_r(json_encode("Error! User attendance already exists"));
            header("Location: ../");
            exit;
        }
        
        $query_add_attendance = $mysqli->prepare("INSERT INTO Attendance (username, sessionid) VALUES (?,?)");
        $query_add_attendance->bind_param("si", $uid, $sessionid);
        $result_add_attendance = $query_add_attendance->execute();

        if (!$result_add_attendance) {
            print_r(json_encode($result_add_attendance));
            header("Location: ../");
            exit;
        }
        print_r(json_encode($result_add_attendance));
        exit;
    }

    if (isset($_POST['func']) && $_POST['func'] == 'createAttendance') {
        if (isset($_SERVER['uid']) && isset($_POST['sessionID'])) {
            
		    createAttendance($_SERVER['uid'], $_POST['sessionID']);
        }
    }
?>
