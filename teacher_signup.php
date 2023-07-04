<?php
	include('admin/dbcon.php');
	session_start();

	$username = $_POST['username'];
	$password = $_POST['password'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$department_id = $_POST['department_id'];
	$location = "uploads/NO-IMAGE-AVAILABLE.jpg";
	$teacher_status = "Registered";


	$response = [];
	// Check Teacher Username if exist
	$teacher_qry = mysqli_query($conn,"SELECT * FROM teacher WHERE username='$username' ")or die(mysqli_error());
	$t_row = mysqli_fetch_array($teacher_qry);

	if(empty($t_row)) {
		// $query = mysqli_query($conn,"SELECT * FROM teacher WHERE firstname='$firstname' AND lastname='$lastname' AND department_id = '$department_id'")or die(mysqli_error());
		// $row = mysqli_fetch_array($query);

		// if(!empty($row)) {
			// $id = $row['teacher_id'];
			// $count = mysqli_num_rows($query);
			// if ($count > 0){
				// mysqli_query($conn,"UPDATE teacher SET username='$username', `password` = '$password', teacher_status = 'Registered' WHERE teacher_id = '$id'")or die(mysqli_error());
				mysqli_query($conn,"INSERT INTO teacher (`username`, `password`, `firstname`, `lastname`, `department_id`, `location`, `teacher_status`) VALUES('$username', '$password', '$firstname', '$lastname', '$department_id', '$location', '$teacher_status')")or die(mysqli_error());
				// $_SESSION['id']=$id;
				$response = [
					'status' => 'true'
				];
			// }else{
				// $response = [
					// 'status' => 'false'
				// ];
			// }
		// } else {
			// $response = [
				// 'status' => 'false'
			// ];
		// }
		
	} else { 
		$response = [
			'status' => 'exist'
		];
	} 

	exit(json_encode($response));
?> 