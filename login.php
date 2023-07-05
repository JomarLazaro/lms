<?php

			
		include('session.php');
		include('admin/dbcon.php');

		$username = $_POST['username'];
		$password = $_POST['password'];

		if(!empty($password)) {
			/* student */
			$query = "SELECT * FROM student WHERE username='$username' AND password='$password' AND `status`='Registered'";
			$result = mysqli_query($conn,$query)or die(mysqli_error());
			$row = mysqli_fetch_array($result);
			$num_row = mysqli_num_rows($result);

			/* teacher */
			$query_teacher = mysqli_query($conn,"SELECT * FROM teacher WHERE username='$username' AND password='$password' AND `teacher_status`='Registered' AND teacher_stat NOT IN('Deactivated')")or die(mysqli_error());
			$num_row_teacher = mysqli_num_rows($query_teacher);
			$row_teahcer = mysqli_fetch_array($query_teacher);

			if( $num_row > 0 ) { 
				$_SESSION['id']=$row['student_id'];
				echo 'true_student';	
			}else if ($num_row_teacher > 0){
				$_SESSION['id']=$row_teahcer['teacher_id'];
				echo 'true';
			
			}else{ 
					echo 'false';
			}	
		} else {
			echo 'false';
		}
		?>