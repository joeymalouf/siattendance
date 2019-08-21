<?php

require_once("/home/jlucas/public_html/test/SIAttendance/back/session.php");
require_once("/home/jlucas/public_html/test/SIAttendance/back/global_functions.php");

function isAdmin($uid)
{

    $mysqli = db_connection();

    $query_user_leader = $mysqli->prepare("SELECT * FROM User WHERE username = ?");
    $query_user_leader->bind_param("s", $uid);
    $query_user_leader->execute();
    $result_user_leader = get_result($query_user_leader);

    if ($result_user_leader && $result_user_leader['admin'] == 1) {
        return true;
    }

    return false;
}

function allUsers()
{
    $mysqli = db_connection();

    $query_users = $mysqli->prepare("SELECT * FROM User");
    $query_users->execute();
    $result_users = get_result($query_users);
    if (!$result_users) {
        http_response_code(500);
        exit;
    }

    print_r(json_encode($result_users));
}

if (isset($_SERVER['uid'])) {
    if (isAdmin($_SERVER['uid'])) {
        if (isset($_POST['func'])) {
            if ($_POST['func'] == 'allUsers') {
                allUsers();
            }
        } else {
            http_response_code(400);
            print_r("Incorrect payload");
        }
    } else {
        http_response_code(403);
        print_r("User does not have permission to access admin utilities.");
    }
} else {
    http_response_code("401");
    print_r("User is not logged in.");
}
