<style>
    .forgotpassword-container{
        margin-top: 3rem;
        font-size: 25px
    }

	p{
		color: white;
	}


</style>



<?php include('header.php'); ?>

<p style>To reset your password, submit your username. If we can find you in the database, an email will be sent to your email address, with instructions how to get access again.</p>
<div class="container" style="position: relative">
    <form id="forgot_password" class="form-signin"  action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
						<input type="text" class="input-block-level" id="forgot_username" name="username" placeholder="Username" required><br><br>
						<input type="password" class="input-block-level" id="newpassword" name="newpassword" placeholder="New Password" required><br><br>
						<input type="password" class="input-block-level" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required>
                        <button data-placement="right" title="Click Here to Search" id="search_username" name="search_username" class="btn btn-info" type="submit"><i class="icon-signin icon-large"></i>Submit</button>
                        <br><br>
														<script type="text/javascript">
														$(document).ready(function(){
															$('#signin').tooltip('show');
															$('#signin').tooltip('hide');
														});
														</script>								
			</form>		
</div>
<?php

include('admin/dbcon.php');


if(!empty($_POST['username']) && isset($_POST['username']) && !empty($_POST['newpassword']) && isset($_POST['newpassword']) && !empty($_POST['confirmpassword']) && isset($_POST['confirmpassword']))
    {
	
    	$username = $_POST['username'];
		$newpassword = $_POST['newpassword'];
		$confirmpassword = $_POST['confirmpassword'];

		 /* student */
		 $query = "SELECT * FROM student WHERE username='$username'";
		 $result = mysqli_query($conn,$query)or die(mysqli_error());
		 $row = mysqli_fetch_array($result);
		 $num_row = mysqli_num_rows($result);

		 /* teacher */
		 $query_teacher = mysqli_query($conn,"SELECT * FROM teacher WHERE username='$username'")or die(mysqli_error());
		 $num_row_teacher = mysqli_num_rows($query_teacher);
		 $row_teacher = mysqli_fetch_array($query_teacher);

		//check username in the database
		//student
		if( $num_row > 0 ) { 
		
			//for debugging
			//echo 'true_student';
			//echo $username;

			if($newpassword == $confirmpassword)
			{
				//update password in the database
				$query_result = mysqli_query($conn,"UPDATE student SET password = '$newpassword' WHERE username = '$username'")or die(mysqli_error());//checking if update is working
	
				echo '<script type="text/javascript">
				alert("Password has been changed");
				</script>';
			}
			}
			else{
				echo '<script type="text/javascript">
				alert("Passwords do not match");
				</script>';
			}
		//teacher
		}else if ($num_row_teacher > 0){

			//for debugging
			//echo 'true';
			//echo $username;

			if($newpassword == $confirmpassword)
			{
				//update password in the database
				$query_result = mysqli_query($conn,"UPDATE teacher SET password = '$newpassword' WHERE username = '$username'")or die(mysqli_error());//checking if update is working
			
				echo '<script type="text/javascript">
				alert("Password has been changed");
				</script>';
			}
			else{
				echo '<script type="text/javascript">
				alert("Passwords do not match");
				</script>';
			}
		}
		else
		{ 
			echo 'false';
			echo '<script type="text/javascript">
			alert("Username is not in the Database, Check your Input");
			</script>';
		}	
?>