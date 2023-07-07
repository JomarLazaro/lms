<?php
    include('admin/dbcon.php');
    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check for student
    $studentQuery = "SELECT * FROM student WHERE username='$username' AND password='$password'";
    $studentResult = mysqli_query($conn, $studentQuery) or die(mysqli_error($conn));
    $studentRow = mysqli_fetch_array($studentResult);
    $numStudentRows = mysqli_num_rows($studentResult);

    // Check for teacher
    $teacherQuery = "SELECT * FROM teacher WHERE username='$username' AND password='$password'";
    $teacherResult = mysqli_query($conn, $teacherQuery) or die(mysqli_error($conn));
    $teacherRow = mysqli_fetch_array($teacherResult);
    $numTeacherRows = mysqli_num_rows($teacherResult);

    if ($numStudentRows > 0) {
        $_SESSION['id'] = $studentRow['student_id'];
        echo 'true_student';
    } else if ($numTeacherRows > 0) {
        $_SESSION['id'] = $teacherRow['teacher_id'];
        echo 'true';
    } else {
        echo 'false';
    }
?>
