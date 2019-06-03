<?php

    require_once("session.php");
    require_once("global_functions.php");
    $mysqli = db_connection();

    function queryProfessors($selectedValue)
    {
        $mysqli = db_connection();
        $query_professors = "SELECT professor FROM Class WHERE course = '".$selectedValue."'";
        $result_professors = $mysqli->query($query_professors);
        if ($result_professors && $result_professors->num_rows > 0) {
            while ($row = $result_professors->fetch_assoc()) {
                echo "<option value='".$row['professor']."'>".$row['professor']."</option>";
            }
        } else {
            echo 'bad';
        }
        }
        if (isset($_POST['course'])) {
        queryProfessors($_POST['course']);
    }

    function getSession($sessionID) {
        $query_session = $mysqli->prepare("SELECT * FROM Session WHERE sessionid = ?");
        $query_session->bind_param("i", $sessionID);
        $query_session->execute();
        $result_session = get_result($query_session);

        if (!$result_session) {
            $_SESSION["message"] = "Error! Session could not be found.";
            header("Location: ../front/index.php");
            exit;
        }
        return $result_session;
    }

    if (isset($_POST['func']) && $_POST['func'] == 'getSession') {
        if (isset($_POST['sessionID'])) {
            getSession($_POST['sessionID']);
       }
    }
