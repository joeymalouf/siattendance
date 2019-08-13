<?php

    require_once("/home/jlucas/public_html/test/SIAttendance/back/session.php");
    require_once("/home/jlucas/public_html/test/SIAttendance/back/global_functions.php");

    function createUser($uid, $fname, $lname, $id, $email)
    {
        $mysqli = db_connection();

        $query_user_exists = $mysqli->prepare("SELECT * FROM User WHERE username = ?");
        $query_user_exists->bind_param("s", $uid);
        $query_user_exists->execute();
        $result_user_exists = get_result($query_user_exists);
        if ($result_user_exists) {
            http_response_code(409);
            print_r("Error! User account already exists");
            exit;
        }
        
        $query_add_user = $mysqli->prepare("INSERT INTO User (username, fname, lname, id, admin, mentor, leader, email) VALUES (?,?,?,?,?,?,?,?)");
        $priv = 0;
        $query_add_user->bind_param("sssiiiis", $uid, $fname, $lname, $id, $priv, $priv, $priv, $email);
        $result_add_user = $query_add_user->execute();

        if (!$result_add_user) {
            http_response_code(500);
            print_r("Error! User was unable to be created for an unknown reason.");
            exit;
        }
        http_response_code(200);
        exit;
    }

    if (isset($_POST['func']) && $_POST['func'] == 'createUser') {
        if (isset($_SERVER['uid']) && isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['id']) && isset($_POST['email'])) {
            createUser($_SERVER['uid'], $_POST['fname'], $_POST['lname'], $_POST['id'], $_POST['email']);
        }
    } else {
        print_r(json_encode("Bad input"));
    }

?>