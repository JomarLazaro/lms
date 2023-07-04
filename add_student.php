<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>
    <body>
		<?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('class_sidebar.php'); ?>
                <div class="span9" id="content">
					<div class="row-fluid">
					     <!-- breadcrumb -->
						<div class="pull-right">
							<a href="my_students.php<?php echo '?id='.$get_id; ?>" class="btn btn-info"><i class="icon-arrow-left"></i> Back</a>
						</div>

						<?php 
							$get_student_limit_qry = "SELECT * FROM teacher_class WHERE teacher_class_id='$get_id' LIMIT 1";
							$teacher_class = mysqli_query($conn,$get_student_limit_qry)or die(mysqli_error());
							$tc = mysqli_fetch_array($teacher_class,MYSQLI_ASSOC);
							if(!empty($tc['students_limit'])) {
								$students_limit = $tc['students_limit'];
							} else {
								$students_limit = 0;
							}
						?> 

						<?php 
							$class_query = mysqli_query($conn,"select * from teacher_class
												LEFT JOIN class ON class.class_id = teacher_class.class_id
												LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
												where teacher_class_id = '$get_id'")or die(mysqli_error());
							$class_row = mysqli_fetch_array($class_query);

							$my_student = mysqli_query($conn,"SELECT * FROM teacher_class_student
												LEFT JOIN student ON student.student_id = teacher_class_student.student_id 
												INNER JOIN class ON class.class_id = student.class_id where teacher_class_id = '$get_id' order by lastname ")or die(mysqli_error());
							$count_my_student = mysqli_num_rows($my_student);
						?>
				
						<ul class="breadcrumb">
							<li><a href="#"><?php echo $class_row['class_name']; ?></a> <span class="divider">/</span></li>
							<li><a href="#"><?php echo $class_row['subject_code']; ?></a> <span class="divider">/</span></li>
							<li><a href="#">My Students</a><span class="divider">/</span></li>
							<li><a href="#"><b>Add Student</b></a></li>
						</ul>
						
						<!-- end breadcrumb -->
					 
                        <!-- block -->
                        <div id="block_bg" class="block">
							<form method="post" action="">
								<div class="navbar navbar-inner block-header">
									<div id="" class="pull-left">
										<h4>
											Add Students to <?=$class_row['class_name'];?> - <?=$class_row['subject_code'];?>

											<span class="badge badge-warning">
													<?=number_format($count_my_student,0)?> / 
													<?=number_format($students_limit,0)?>
												</span>
										</h4>
									</div>
									<div class="pull-right">
										<?php
											if($students_limit > 0 && $count_my_student < $students_limit) {
										?>
												<button name="submit" type="submit" class="btn btn-info"><i class="icon-save"></i>&nbsp;Add Student</button>
										<?php
											} else {
										?>
												<div class="alert alert-danger">Maximum students allowed to this class has been reached.</div>
										<?php
											}
										?>
									</div>
								</div>
                            	<div class="block-content collapse in">
                                	<div class="span12">
							 			<table cellpadding="0" cellspacing="0" border="0" class="table" id="example">                          
						 					<thead>
                                				<tr>
													<th>Photo</th>
													<th>Name</th>
													<th>Course Year and Section</th>
                                    				<th></th>
                                				</tr>
                            				</thead>
                            				<tbody>
                                         		<?php
													$a = 0 ;
													$query = mysqli_query($conn,"select * from student LEFT JOIN class on class.class_id = student.class_id
															") or die(mysqli_error());
													while ($row = mysqli_fetch_array($query)) {
                                        				$id = $row['student_id'];
														$a++;
                                        		?>
								
														<tr>
															<input type="hidden" name="test" value="<?php echo $a; ?>">
															<td width="70"><img  class="img-rounded" src="admin/<?php echo $row['location']; ?>" height="50" width="40"></td>
															<td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td> 
															<td><?php echo $row['class_name']; ?></td> 
												
															<td width="80">
																<select name="add_student<?php echo $a; ?>" class="span12">
																	<option></option>
																	<option>Add</option>
																</select>
															
																<input type="hidden" name="student_id<?php echo $a; ?>" value="<?php echo $id; ?>">
																<input type="hidden" name="class_id<?php echo $a; ?>" value="<?php echo $get_id; ?>">
																<input type="hidden" name="teacher_id<?php echo $a; ?>" value="<?php echo $session_id; ?>">
															</td>
														</tr>
												<?php 
													} 
												?>    
                            				</tbody>
                        				</table>
									</div>
								</div>
							</form>
						</div>
						
  										
						<?php
							if (isset($_POST['submit'])) 
							{
								$test = $_POST['test'];
									for($b = 1; $b <=  $test; $b++)
									{
									
										$test1 = "student_id".$b;
										$test2 = "class_id".$b;
										$test3 = "teacher_id".$b;
										$test4 = "add_student".$b;
									
										$id = $_POST[$test1];
										$class_id = $_POST[$test2];
										$teacher_id = $_POST[$test3];
										$Add = $_POST[$test4];
									
										$query = mysqli_query($conn,"select * from teacher_class_student where student_id = '$id' and teacher_class_id = '$class_id' ")or die(mysqli_error());
										$count = mysqli_num_rows($query); 
	
 										if ($count > 0) { 
						?>
											<script>
												alert('Student Already in the class'); 
											</script>
											<script>
												window.location = "add_student.php<?php echo '?id='.$get_id; ?>"; 
											</script>
						<?php
										} else  
										if($Add == 'Add') {
											mysqli_query($conn,"insert into teacher_class_student (student_id,teacher_class_id,teacher_id) values('$id','$class_id','$teacher_id') ")or die(mysqli_error());	
										}else{
	
										}
						?>
										<script>
										window.location = "my_students.php<?php echo '?id='.$get_id; ?>"; 
										</script>
						<?php
									}
							}
						?>
                        <!-- /block -->
                    </div>
                </div>
            </div>
			<?php include('footer.php'); ?>
        </div>
		<?php include('script.php'); ?>
    </body>
</html>