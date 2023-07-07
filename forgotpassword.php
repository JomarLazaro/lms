<?php include('header.php'); ?>

<style>
    .forgotpassword-container {
        margin-top: 3rem;
        font-size: 25px;
    }

    /* Add the provided style */
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .form-signin {
        width: 90%;
        max-width: 400px;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 10px;
		margin-right: 17px;
    }

    h3 {
        margin-top: 0;
        text-align: center;
    }

    p {
        text-align: center;
        margin-bottom: 20px;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }

    .error-message {
        color: red;
        margin-top: 10px;
        text-align: center;
    }
</style>

<div class="container">
    <form id="forgot_password" class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <h3 class="form-signin-heading">Reset Password</h3>

        <p>To reset your password, submit your username. If we can find you in the database, an email will be sent to your email address with instructions on how to regain access.</p>

        <div class="form-group">
            <input type="text" class="form-control" id="forgot_username" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required>
        </div>
        <button id="search_username" name="search_username" class="btn btn-info" type="submit"><i class="icon-signin icon-large"></i>Submit</button>
    </form>
</div>

<?php
include('admin/dbcon.php');

$num_row_teacher = 0;
if (!empty($_POST['username']) && isset($_POST['username']) && !empty($_POST['newpassword']) && isset($_POST['newpassword']) && !empty($_POST['confirmpassword']) && isset($_POST['confirmpassword'])) {
    $username = $_POST['username'];
    $newpassword = $_POST['newpassword'];
    $confirmpassword = $_POST['confirmpassword'];

    /* student */
    $query = "SELECT * FROM student WHERE username='$username'";
    $result = mysqli_query($conn, $query) or die(mysqli_error());
    $row = mysqli_fetch_array($result);
    $num_row = mysqli_num_rows($result);

    /* teacher */
    $query_teacher = mysqli_query($conn, "SELECT * FROM teacher WHERE username='$username'") or die(mysqli_error());
    $num_row_teacher = mysqli_num_rows($query_teacher);
    $row_teacher = mysqli_fetch_array($query_teacher);

    // check username in the database
    // student
    if ($num_row > 0) {

        if ($newpassword == $confirmpassword) {
            // update password in the database
            $query_result = mysqli_query($conn, "UPDATE student SET password = '$newpassword' WHERE username = '$username'") or die(mysqli_error());

            echo '<script type="text/javascript">
                alert("Password has been changed");
            </script>';
        } else {
            echo '<script type="text/javascript">
                alert("Passwords do not match");
            </script>';
        }
    }
    // teacher
    else if ($num_row_teacher > 0) {

        if ($newpassword == $confirmpassword) {
            // update password in the database
            $query_result = mysqli_query($conn, "UPDATE teacher SET password = '$newpassword' WHERE username = '$username'") or die(mysqli_error());

            echo '<script type="text/javascript">
                alert("Password has been changed");
            </script>';
        } else {
            echo '<script type="text/javascript">
                alert("Passwords do not match");
            </script>';
        }
    } else {
        echo '<script type="text/javascript">
            alert("Username is not in the Database, Check your Input");
        </script>';
    }
}
?>
