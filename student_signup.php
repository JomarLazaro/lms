<?php
	include('admin/dbcon.php');
	session_start();
	$username = $_POST['username'];
	$password = $_POST['password'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$class_id = $_POST['class_id'];
	$location = "uploads/NO-IMAGE-AVAILABLE.jpg";
	$status = "Registered";
	$response = [];

	// $query = mysqli_query($conn,"select * from student where username='$username' and firstname='$firstname' and lastname='$lastname' and class_id = '$class_id'")or die(mysqli_error());
	$query = mysqli_query($conn,"select * from student where username='$username' ")or die(mysqli_error());
	$row = mysqli_fetch_array($query);
	$id = $row['student_id'];

	$count = mysqli_num_rows($query);
 
	if ($count > 0){
		$response = [
			'status' => 'false'
		];

	}else{ 

		if(empty($username) || empty($password) || empty($class_id)) {
		
			$response = [
				'status' => 'false',
				'required' => 'true'
			];

		} else {
			// mysqli_query($conn,"update student set password = '$password', status = 'Registered' where student_id = '$id'")or die(mysqli_error());
			mysqli_query($conn,"INSERT INTO student (firstname, lastname, class_id, username, `password`, `location`, `status`) VALUES('$firstname','$lastname','$class_id','$username','$password','$location','$status')")or die(mysqli_error());
			// $_SESSION['id']=$id;
			$response = [
				'status' => 'true'
			];		
		}
	}  

	exit(json_encode($response));
?> 