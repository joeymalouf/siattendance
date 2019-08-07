<?php

    require_once("/home/jlucas/public_html/test/SIAttendance/session.php");
    require_once("/home/jlucas/public_html/test/SIAttendance/global_functions.php");

    function createUser($uid, $fname, $lname, $id)
    {
        $mysqli = db_connection();

        $query_user_exists = $mysqli->prepare("SELECT * FROM User WHERE username = ?");
        $query_user_exists->bind_param("s", $uid);
        $query_user_exists->execute();
        $result_user_exists = get_result($query_user_exists);
        if ($result_user_exists) {
            print_r("Error! User account already exists");
            exit;
        }
        
        $query_add_user = $mysqli->prepare("INSERT INTO User (username, fname, lname, id, admin, mentor, leader) VALUES (?,?,?,?,?,?,?)");
        $priv = 0;
        $query_add_user->bind_param("sssiiii", $uid, $fname, $lname, $id, $priv, $priv, $priv);
        $result_add_user = $query_add_user->execute();

        if (!$result_add_user) {
            print_r($result_add_user);
            exit;
        }
        print_r($result_add_user);
        exit;
    }

    if (isset($_POST['func']) && $_POST['func'] == 'createUser') {
        if (isset($_SERVER['uid']) && isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['id'])) {
            createUser($_SERVER['uid'], $_POST['fname'], $_POST['lname'], $_POST['id']);
        }
    } else {
        print_r(json_encode("Bad input"));
    }

?>