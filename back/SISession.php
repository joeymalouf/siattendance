<?php

    require_once("/home/jlucas/public_html/test/SIAttendance/session.php");
    require_once("/home/jlucas/public_html/test/SIAttendance/global_functions.php");

    function createSession($course, $professor, $type, $date_time)
    {
        $mysqli = db_connection();

        $query_session_exists = $mysqli->prepare("SELECT * FROM Session WHERE course = ? AND professor = ? AND type = ? AND date_time = ?");
        $date_time = strtotime($date_time);
        $date_time = date('Y-m-d H:i:s', $date_time);
        $query_session_exists->bind_param("ssss", $course, $professor, $type, $date_time);
        $query_session_exists->execute();
        $result_session_exists = get_result($query_session_exists);

        if ($result_session_exists) {
            print_r("Session exists");
            exit;
        }

        $query_add_session = $mysqli->prepare("INSERT INTO Session (course, professor, type, date_time) VALUES (?,?,?,?)");
        $query_add_session->bind_param('ssss', $course, $professor, $type, $date_time);
        $execute = $query_add_session->execute();
        if ($execute) {
            print_r("Session has been added");
            exit;
        } else {
            print_r("Error, session could not be added.");
            exit;
        }
    }

    function getAllCourses()
    {
        $mysqli = db_connection();

        $query_courses = $mysql->prepare("SELECT * FROM course");
        $query_courses->execute();
        $result_courses = get_result($query_courses);

        if ($result_courses) {
            print_r(json_encode($result_courses));
        } else {
            print_r("Error. Could not get courses");
        }
    }

    function getCourseProfessors($course)
    {
        $mysqli = db_connection();

        $query_professors = $mysqli->prepare("SELECT professor FROM Class WHERE course = ?");
        $query_professors = $mysqli->bind_param("s", $course);
        $query_professors->execute();
        $result_professors = get_result($query_professors);

        if ($result_professors) {
            print_r(json_encode($result_professors));
        } else {
            print_r('Error. Could not get professors');
        }
    }

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

    function getAllSessions()
    {
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

    function getCurrentSessions()
    {
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
    elseif (isset($_POST['func']) && $_POST['func'] == 'getSessionAttendance') {
        if (isset($_POST['sessionID'])) {
            getSessionAttendance($_POST['sessionID']);
        }
    } 
    elseif (isset($_POST['func']) && $_POST['func'] == 'getAllSessions') {
        getAllSessions();
    } 
    elseif (isset($_POST['func']) && $_POST['func'] == 'getCurrentSessions') {
        getCurrentSessions();
    } 
    elseif (isset($_POST['func']) && $_POST['func'] == 'createSession') {
        if (isset($_POST['course']) && isset($_POST['professor']) && isset($_POST['type']) && isset($_POST['date_time'])) {
            createSession($_POST['course'], $_POST['professor'], $_POST['type'], $_POST['date_time']);
        } 
        else {
            print_r("Error, bad data");
        }
    } 
    elseif (isset($_POST['func']) && $_POST['func'] == 'getCourses') {
        getAllCourses();
    } 
    elseif (isset($_POST['func']) && $_POST['func'] == 'getCourseProfessors') {
        if (isset($_POST['course'])) {
            getCourseProfessors($_POST['course']);
        }
        else {
            print_r("Error, bad data");
        }
    } 
    else {
        print_r("error");
    }
