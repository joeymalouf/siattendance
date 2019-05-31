<?php
    require_once("session.php");
?>
<html>
<?php
        require_once("global_functions.php");
        $mysqli = db_connection();
?>

<head>
    <Title>SI</Title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container">
        <div class="row">
            <?php
            if (($output = message()) !== null) {
                echo $output;
            }
         ?>
        </div>

        <?php
            if(isset($_GET['submit'])) {
                $_POST['submit'] = $_GET['submit'];
                $_POST['Sessionid'] = $_GET['Sessionid'];
            }
            if (isset($_POST['submit'])) {
                if (isset($_POST['Sessionid']) && $_POST['Course'] !== '') {
                    $query_session_exists = $mysqli->prepare("SELECT * FROM Session WHERE sessionid = ?");
                    $query_session_exists->bind_param("i", $_POST['Sessionid']);
                    $query_session_exists->execute();
                    $result_session_exists = get_result($query_session_exists);

                    if (!$result_session_exists) {
                        $_SESSION["message"] = "Error! Could not add attendance. Session does not exist.";
                        header("Location: createAttendance.php");
                        exit;
                    }

                    $query_add_attendance = $mysqli->prepare("INSERT INTO Attendance (username, sessionid) VALUES (?,?)");

                    $query_add_attendance->bind_param('si', $username, $result_session_exists[0]['sessionid']);
                    $execute = $query_add_attendance->execute();
                    if ($execute) {
                        $_SESSION['message'] = "Attendance has been added.";
                        header("Location: createAttendance.php");
                        exit;
                    } else {
                        $_SESSION["message"] = "Server error! Could not add attendance. Try again later.";
                        header("Location: createAttendance.php");
                        exit;
                    }
                } else {
                    $_SESSION["message"] = "Select a session.";
                    header("Location: createAttendance.php");
                    exit;
                }
            }
        ?>
        <form method='post' action='createAttendance.php'>
            <div class='form-group'>
                <label for="session">Session</label>
                <select id='session' name='Sessionid' class='form-control'>
                    <option></option>
                    <?php
                        $query_sessions = "SELECT * FROM Session";
                        $result_sessions = $mysqli->query($query_sessions);
                        if ($result_sessions && $result_sessions->num_rows > 0) {
                            while ($row = $result_sessions->fetch_assoc()) {
                                echo "<option value='".$row['sessionid']."'>".$row['date_time']." ".$row['course']." ".$row['professor']." ".$row['type']."</option>";
                            }
                        } else {
                            echo "No sessions found";
                        }
                    ?>
                </select>

            </div>
                <div class='form-group'>
                    <input type='submit' name='submit' class='btn btn-primary' />
                </div>
        </form>
    </div>


</body>

</html>