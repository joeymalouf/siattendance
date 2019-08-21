<?php

require_once("/home/jlucas/public_html/test/SIAttendance/back/session.php");
require_once("/home/jlucas/public_html/test/SIAttendance/back/global_functions.php");

function getRole($uid)
{

    $mysqli = db_connection();

    $query_role = $mysqli->prepare("SELECT * FROM User WHERE username = ?");
    $query_role->bind_param("s", $uid);
    $query_role->execute();
    $result_user_leader = get_result($query_role);

    if ($result_user_leader) {
        if ($result_user_leader[0]['admin'] == 1) {
            print_r('admin');
        } elseif ($result_user_leader[0]['mentor'] == 1) {
            print_r('mentor');
        } elseif ($result_user_leader[0]['leader'] == 1) {
            print_r('leader');
        } else {
            print_r('student');
        }
    } else {
        print_r('student');
    }
}

function userExists()
{
    $mysqli = db_connection();

    $query_user = $mysqli->prepare("SELECT * FROM User WHERE username = ?");
    $query_user->bind_param("s", $uid);
    $query_user->execute();
    $result_user = get_result($query_user);

    if ($result_user) {
        return true;
    } else {
        return false;
    }
}
if (isset($_SERVER['uid'])) {
    if (isset($_POST['func']) && $_POST['func'] == 'getRole') {
        getRole($_SERVER['uid']);
    }
}
