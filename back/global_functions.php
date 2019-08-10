<?php
        function db_connection()
        {
                require_once("/home/jmmalouf/DBMalouf.php");
                $mysqli = new mysqli(DBHOST, USERNAME, PASSWORD, DBNAME);
                if ($mysqli->connect_errno){
                        die("Could not connect to database");
                }
                return $mysqli;
        }
        function get_result($Statement) {
                $RESULT = array();
                $Statement->store_result();
                for($i = 0; $i < $Statement->num_rows; $i++) {
                        $Metadata = $Statement->result_metadata();
                        $PARAMS = array();
                        while ($Field = $Metadata->fetch_field()) {
                                $PARAMS[] = &$RESULT[$i][$Field->name];
                        }
                        call_user_func_array(array($Statement, 'bind_result'), $PARAMS);
                        $Statement->fetch();
                }
                return $RESULT;
        }
?>