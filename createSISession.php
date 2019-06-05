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
    <script>
        $(document).ready(function() {
            $('#course').change(function() {
                var inputValue = $(this).val();
                console.log(inputValue)
                $.post('getProfessors.php', {
                    course: inputValue
                }, function(html) {
                    $("#professor").html(html)
                });
            });
        });
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
            if (isset($_POST['submit'])) {
                if (isset($_POST['Course']) && $_POST['Course'] !== ''
                    && isset($_POST['Professor']) && $_POST['Professor'] !== ''
                    && isset($_POST['Type']) && $_POST['Type'] !== ''
                    && isset($_POST['Date_time'])) {
                    $query_session_exists = $mysqli->prepare("SELECT * FROM Session WHERE course = ? AND professor = ? AND type = ? AND date_time = ?");
                    $date_time = strtotime($_POST['Date_time']);
		    $dt = date('Y-m-d H:i:s', $date_time);
		    $query_session_exists->bind_param("ssss", $_POST['Course'], $_POST['Professor'], $_POST['Type'], $dt);
                    $query_session_exists->execute();
                    $result_session_exists = get_result($query_session_exists);

                    if ($result_session_exists) {
                        $_SESSION["message"] = "Error! Could not add the session. One with the same data already exists";
                        header("Location: createSISession.php");
                        exit;
                    }


                    $query_add_session = $mysqli->prepare("INSERT INTO Session (course, professor, type, date_time) VALUES (?,?,?,?)");
                    $query_add_session->bind_param('ssss', $_POST['Course'], $_POST['Professor'], $_POST['Type'], $dt);
                    $execute = $query_add_session->execute();
                    if ($execute) {
                        $_SESSION['message'] = "Session has been added.".$dt." aa ".$_POST['Date_time'];
                        header("Location: createSISession.php");
                        exit;
                    } else {
                        $_SESSION["message"] = "Server error! Could not add session. Try again later.";
                        header("Location: createSISession.php");
                        exit;
                    }
                } else {
                    $_SESSION["message"] = "Enter correct info.";
                    header("Location: createSISession.php");
                    exit;
                }
            }
        ?>
        <form method='post' action='createSISession.php'>
            <div class='form-group'>
                <label for="course">Course</label>
                <select id='course' name='Course' class='form-control'>
                    <option></option>
                    <?php
                        $query_courses = "SELECT course FROM Course";
                        $result_courses = $mysqli->query($query_courses);
                        if ($result_courses && $result_courses->num_rows > 0) {
                            while ($row = $result_courses->fetch_assoc()) {
                                echo "<option value='".$row['course']."'>".$row['course']."</option>";
                            }
                        } else {
                echo "No courses found";
            }
                    ?>
                </select>
            </div>

            <div class='form-group'>
                <label for="professor">Professor</label>
                <select id='professor' name='Professor' class='form-control'>
                    <option></option>
                </select>
            </div>
            <div class='form-group'>
                <label for="type">Type</label>
                <select id='type' name='Type' class='form-control'>
                    <option value="Lecture Review">Lecture Review</option>
                    <option value="Exam Review">Exam Review</option>
                </select>
            </div>
            <div class='form-group'>
                <label for="date_time">Date Time</label>
                <input id='date_time' type='datetime-local' name='Date_time' class='form-control'>
            </div>

            <div class='form-group'>
                <input type='submit' name='submit' class='btn btn-primary' />
            </div>
        </form>
    </div>


</body>

</html>
