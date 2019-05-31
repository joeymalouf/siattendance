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
	<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>    
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script>
            $(document).ready(function(){
            $('#course').change(function(){
                var inputValue = $(this).val();
		console.log(inputValue)
                $.post('getProfessors.php', { courseID : inputValue }, function(html){
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
                if (isset($_POST['Username']) && $_POST['Username'] !== ''
                    && isset($_POST['Fname']) && $_POST['Fname'] !== ''
                    && isset($_POST['Lname']) && $_POST['Lname'] !== ''
                    && isset($_POST['Mi'])
                    && isset($_POST['Id'])
                    && isset($_POST['Email']) && $_POST['Email'] !== '') {
                    $query_user_exists = "SELECT username FROM User WHERE username = ".$_POST['Username'];

                    $result_user_exists = $mysqli->query($query_user_exists);
                    if ($result_user_exists) {
                        $_SESSION["message"] = "Error! Could not add ".$_POST["Username"].". User already exists";
                        header("Location: createUser.php");
                        exit;
                    }
                    $admin = 0;
                    $mentor = 0;
                    $leader = 0;
                    if (isset($_POST['Admin'])) {
                        $admin = 1;
                    }
                    if (isset($_POST['Mentor'])) {
                        $mentor = 1;
                    }
                    if (isset($_POST['Leader'])) {
                        $leader = 1;
                    }


                    $query_add_user = "INSERT INTO User (username, FName, LName, MI, id, admin, mentor, leader, email) VALUES ('".$_POST['Username']."', '".$_POST['Fname']."', '".$_POST['Lname']."', '".$_POST['Mi']."', '".$_POST['Id']."', '".$admin."', '".$mentor."', '".$leader."', '".$_POST['Email']."')";
                    $result_add_user = $mysqli->query($query_add_user);
                    if ($result_add_user) {
                        $_SESSION['message'] = $_POST['Username']." has been added.";
                        header("Location: createUser.php");
                        exit;
                    } else {
                        $_SESSION["message"] = "Error! Could not add ".$_POST["Username"]."---".$query_add_user;
                        header("Location: createUser.php");
                        exit;
                    }
                } else {
                    $_SESSION["message"] = "Enter correct info";
                    header("Location: createUser.php");
                    exit;
                }
            }
        ?>
        <form method='post' action='createSession.php'>
            <div class='form-group'>
                <label for="course">Course</label>
                <select id='course' name='Course' class='form-control'>
                    <option></option>
                    <?php
                        $query_courses = "SELECT courseID FROM Course";
                        $result_courses = $mysqli->query($query_courses);
                        if ($result_courses && $result_courses->num_rows > 0) {
                            while ($row = $result_courses->fetch_assoc()) {
                                echo "<option value='".$row['courseID']."'>".$row['courseID']."</option>";
                            }
                        }
			else {
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
                <label for="lname">Last Name</label>
                <input id='lname' type='text' name='Lname' class='form-control'>
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
