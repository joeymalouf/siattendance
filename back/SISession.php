<?php

    require_once("/home/jlucas/public_html/test/SIAttendance/session.php");
    require_once("/home/jlucas/public_html/test/SIAttendance/global_functions.php");

    function getSession($sessionID)
    {
        $mysqli = db_connection();
        date_default_timezone_set('America/Chicago');
        $query_session = $mysqli->prepare("SELECT * FROM Session WHERE sessionid = ?");
        $query_session->bind_param("i", $sessionID);
        $query_session->execute();
        $result_session = get_result($query_session);

        if (!$result_session) {
            $_SESSION["message"] = "Error! Session could not be found.";
            header("Location: ../front/index.php");
            exit;
        }

        print_r(json_encode($result_session));
    	
    }

    function getAllSessions() {
        $mysqli = db_connection();
        $query_sessions = $mysqli->prepare("SELECT * FROM Session");
        $query_sessions->bind_param("i", $sessionID);
        $query_sessions->execute();
        $result_sessions = get_result($query_sessions);

        if (!$result_sessions) {
            $_SESSION["message"] = "Error! Could not get sessions.";
            header("Location: ../front/index.php");
            exit;
        }
        print_r(json_encode($result_sessions));

    }

    function getCurrentSessions() {
        $mysqli = db_connection();
        date_default_timezone_set('America/Chicago');
        $Date = date("Y-m-d h:i");
        $Date = strtotime('-1 hour', strtotime($Date));
        $Date = date("Y-m-d h:i", $Date);
        $query_sessions = $mysqli->prepare("SELECT * FROM Session WHERE date_time > ?");
        $query_sessions->bind_param("s", $Date);
        $query_sessions->execute();
        $result_sessions = get_result($query_sessions);

        if (!$result_sessions) {
            $_SESSION["message"] = "Error! Could not get sessions.";
            header("Location: ../front/index.php");
            exit;
        }
        print_r(json_encode($result_sessions));

    }

    function getSessionAttendance($sessionID)
    {
        $mysqli = db_connection();
        $query_session = $mysqli->prepare("SELECT DISTINCT fname, lname, id FROM Attendance NATURAL JOIN User WHERE sessionid = ?");
        $query_session->bind_param("i", $sessionID);
        $query_session->execute();
        $result_session = get_result($query_session);

        if (!$result_session) {
            $_SESSION["message"] = "Error! Session attendance could not be found.";
            header("Location: ../front/index.php");
            exit;
        }

        print_r(json_encode($result_session));
    }

    if (isset($_POST['func']) && $_POST['func'] == 'getSession') {
        if (isset($_POST['sessionID'])) {
            getSession($_POST['sessionID']);
        }
    }
    if (isset($_POST['func']) && $_POST['func'] == 'getSessionAttendance') {
        if (isset($_POST['sessionID'])) {
            getSessionAttendance($_POST['sessionID']);
        }
    }
    if (isset($_POST['func']) && $_POST['func'] == 'getAllSessions') {
        getAllSessions();
    }
	if (isset($_POST['func']) && $_POST['func'] == 'getCurrentSessions') {
        getCurrentSessions();
    }
?>
