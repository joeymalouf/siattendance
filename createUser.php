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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
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
                    if(isset($_POST['Admin'])) {
                        $admin = 1;
                    }
                    if(isset($_POST['Mentor'])) {
                        $mentor = 1;
                    }
                    if(isset($_POST['Leader'])) {
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
                }
                else {
                    $_SESSION["message"] = "Enter correct info";
                    header("Location: createUser.php");
                    exit;
                }
            }
        ?>
        <form method='post' action='createUser.php'>
            <div class='form-group'>
                <label for="username">Username</label>
                <input id='username' type='text' name='Username' class='form-control'>
            </div>
            <div class='form-group'>
                <label for="fname">First Name</label>
                <input id='fname' type='text' name='Fname' class='form-control'>
            </div>
            <div class='form-group'>
                <label for="lname">Last Name</label>
                <input id='lname' type='text' name='Lname' class='form-control'>
            </div>
            <div class='form-group'>
                <label for="mi">Middle Initial</label>
                <input id='mi' type='text' name='Mi' class='form-control'>
            </div>
            <div class='form-group'>
                <label for="id">Student ID</label>
                <input id='id' type='number' name='Id' class='form-control'>
            </div>
            <div class='form-group'>
                <label for="admin">Admin</label>
                <input id='admin' type='checkbox' name='Admin' class='form-control' value="1">
                <label for="mentor">Mentor</label>
                <input id='mentor' type='checkbox' name='Mentor' class='form-control' value="1">
                <label for="leader">Leader</label>
                <input id='leader' type='checkbox' name='Leader' class='form-control' value="1">
            </div>
            <div class='form-group'>
                <label for="email">Email</label>
                <input id='email' type='email' name='Email' class='form-control'>
            </div>
            <div class='form-group'>
                <input type='submit' name='submit' class='btn btn-primary' />
            </div>
        </form>
    </div>


</body>

</html>