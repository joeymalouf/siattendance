<?php

    require_once("/home/jlucas/public_html/test/SIAttendance/back/session.php");
    require_once("/home/jlucas/public_html/test/SIAttendance/back/global_functions.php");

    function isLeader($uid) {

        $mysqli = db_connection();

        $query_user_leader = $mysqli->prepare("SELECT * FROM User WHERE username = ?");
        $query_user_leader->bind_param("s", $uid);
        $query_user_leader->execute();
        $result_user_leader = get_result($query_user_leader);

        if ($result_user_leader && $result_user_leader['leader'] == 1 || $result_user_leader['mentor'] == 1 || $result_user_leader['admin'] == 1) {
            return true;
        }

        return false;
    }
    function leaderSessions($uid)
    {
        $mysqli = db_connection();
        
        $query_leader_sessions = $mysqli->prepare("SELECT * FROM Leader NATURAL JOIN Session WHERE username = ?");
        $query_leader_sessions->bind_param("s", $uid);
        $query_leader_sessions->execute();
        $result_leader_sessions = get_result($query_leader_sessions);
        if (!$result_leader_sessions) {
            http_response_code(500);
            exit;
        }
        
        print_r(json_encode($result_leader_sessions));
       
    }

    if (isset($_SERVER['uid'])){
        if(isLeader($_SERVER['uid'])) {
            if (isset($_POST['func']) && $_POST['func'] == 'leaderSessions') {
                leaderSessions($_SERVER['uid']);
            }
        }
        else {
            http_response_code(403); //forbidden
        }
    }

?>