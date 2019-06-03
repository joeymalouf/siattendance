<?php

    require_once("../session.php");
    require_once("../global_functions.php");
    require_once("../qrGenerator.php");

    function getSession($sessionID)
    {
        $mysqli = db_connection();
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
        printr(generateQR("https://turing.cs.olemiss.edu/~jmmalouf/SIAttendence/front/SISession/SISession.html?sessionID=2&func=getSession"));
    }

    function getAllSessions() {
        $mysqli = db_connection();
        $query_sessions = $mysqli->prepare("SELECT * FROM Session");
        $query_sessions->bind_param("i", $sessionID);
        $query_sessions->execute();
        $result_session = get_result($query_session);

        if (!$result_session) {
            $_SESSION["message"] = "Error! Could not get sessions.";
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
    if (isset($_POST['func']) && $_POST['func'] == 'getAllSessions') {
        getAllSessions();
    }
