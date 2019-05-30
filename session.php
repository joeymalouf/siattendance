<?php
    $username = "jmmalouf";

    session_start();

    function message() {
        if (isset($_SESSION["message"])) {

                $output = "<div class='row'>";
                $output .= "<div role='alert' class='data-alert'>";
                $output .= htmlentities($_SESSION["message"]);
                $output .= "</div>";
                $output .= "</div>";

                // clear message after use
                $_SESSION["message"] = null;

                return $output;
        }
        else {
                return null;
        }
    }

?>