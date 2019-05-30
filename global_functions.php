<?php
        function redirect_to($new_location)
        {
            header("Location: " . $new_location);
            exit;
        }
        function db_connection()
        {
            require_once("/home/jmmalouf/DBMalouf.php");
            $mysqli = new mysqli(DBHOST, USERNAME, PASSWORD, DBNAME);
            // Test if connection successful
            if ($mysqli->connect_errno) {
                die("Could not connect to server!<br />");
            }
            return $mysqli;
        }

        function new_header($name="SI Attendance", $urlLink="")
        {
            echo "<head>";
            echo "  <title>$name</title>";
            echo "  <link rel='stylesheet' href='css/bootstrap.min.css'>";
            echo "  <script src='js/bootstrap.min.js'></script>";
            echo " <script src='js/jquery-3.3.1.min.js'></script>";
            echo "</head>";

            echo "<body>";
            echo "<nav class='navbar navbar-default navbar-fixed-top bg-dark'>";
            echo "<ul class='nav'>";
            echo "<li class='name'>";
            echo "  <h1><a href='/~jmmalouf/".$urlLink."'><div class='text-center text-light'>".$name."</div></a></h1>";
            echo "</li>";
            echo "<li><pre>   </pre></li>";
            echo "<li><h1><a class='text-center text-light' href='/~jmmalouf/deli/readOrders.php'>Orders</a></h1><</li>";

            echo "<li><pre>   </pre></li>";
            echo "<li><h1><a class='text-center text-light' href='/~jmmalouf/deli/readRestaurant.php'>Restaurants</a></h1><</li>";

            echo "</ul>";
            echo "</nav>";
        }

        function new_footer($name="Default", $mysqli)
        {
            echo "<br /><br /><br />";
            echo "<h4><div class='text-center'><small>Copyright ".date("M Y").", ".$name."</small></div></h4>";
            echo "</body>";
            echo "</html>";
            $mysqli->close;
        }
