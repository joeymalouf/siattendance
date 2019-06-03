<?php

    require_once("../session.php");
    require_once("../global_functions.php");

    function getSession($sessionID) {

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
    }
    if (isset($_POST['func']) && $_POST['func'] == 'getSession') {
        if (isset($_POST['sessionID'])) {
            getSession($_POST['sessionID']);
       }
    }
?>
