<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<body>
	<?php include('navbar_teacher.php'); ?>
	<div class="container-fluid">
		<div class="row-fluid">
			<?php include('quiz_sidebar_teacher.php'); ?>
			<div class="span9" id="content">
				<div class="row-fluid">
					<!-- breadcrumb -->	
						<ul class="breadcrumb">
							<?php
								$school_year_query = mysqli_query($conn,"select * from school_year order by school_year DESC")or die(mysqli_error());
								$school_year_query_row = mysqli_fetch_array($school_year_query);
								$school_year = $school_year_query_row['school_year'];
							?>
							<li><a href="#"><b>My Class</b></a><span class="divider">/</span></li>
							<li><a href="#">School Year: <?php echo $school_year_query_row['school_year']; ?></a><span class="divider">/</span></li>
							<li><a href="#"><b>Quiz</b></a></li>
						</ul>
					<!-- end breadcrumb -->
					<!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
								<div id="" class="pull-left">
									<h4>Add Quiz to Selected Student</h4>
								</div>
                                <div id="" class="muted pull-right"></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
									<div class="pull-right">
										<a href="teacher_quiz.php" class="btn btn-info"><i class="icon-arrow-left"></i> Back</a>
									</div>
								
									<form class="form-horizontal" method="post">
										<div class="control-group">
											<label class="control-label" for="teacher_class_id">Class</label>
											<div class="controls">
												<select name="teacher_class_id" id="teacher_class_id">
													<option></option>
													<?php  
														$query = mysqli_query($conn,"select * from teacher_class
														LEFT JOIN class ON class.class_id = teacher_class.class_id
														LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
														where teacher_id = '$session_id' and school_year = '$school_year'")or die(mysqli_error());
														while ($row = mysqli_fetch_array($query))
														{ 
															$teacher_class_id = $row['teacher_class_id']; ?>
															<option value="<?php echo $teacher_class_id; ?>"><?php echo $row['class_name'] . " - " . $row['subject_code']; ?></option>
													<?php 
														} 
													?>
												</select>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="quiz_id">Quiz</label>
											<div class="controls">
												<select name="quiz_id" id="quiz_id">
													<option></option>
													<?php  
														$query = mysqli_query($conn,"select * from quiz where teacher_id = '$session_id'")or die(mysqli_error());
														while ($row = mysqli_fetch_array($query))
														{ 
															$id = $row['quiz_id']; ?>
															<option value="<?php echo $id; ?>"><?php echo $row['quiz_title']; ?></option>
													<?php 
														} 
													?>
												</select>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="inputPassword">Test Time (in minutes)</label>
											<div class="controls">
												<input type="text" class="span3" name="time" id="inputPassword" placeholder="Test Time" required>
											</div>
										</div>

										<div class="control-group">
											<div class="controls">
												<table class="table span6">
													<thead>
														<th></th>
														<th>Student ID</th>
														<th>Student Name</th>
													</thead>
													<tbody id="class_students">
															<tr>
																<td colspan="3">No class is selected yet. Please select a class first.</td>
															</tr>
													</tbody>
												</table>
											</div> 
										</div>  
											
										<div class="control-group">
											<div class="controls">
												<button name="save" type="submit" class="btn btn-info"><i class="icon-save"></i> Save</button>
											</div>
										</div>
									</form>
									<?php
											if (isset($_POST['save'])){
												$teacher_class_id = $_POST['teacher_class_id'];
												$quiz_id = $_POST['quiz_id'];
												$time = $_POST['time'] * 60;
												$student_id=$_POST['student_id'];
												$N = count($student_id);

												for($i=0; $i < $N; $i++)
												{
													
													$name_notification = 'Add Quiz to Student with ID#' . $student_id[$i];
													
													mysqli_query($conn,"insert into class_quiz_student (teacher_class_id,quiz_time,quiz_id,student_id) values('$teacher_class_id','$time','$quiz_id','$student_id[$i]')")or die(mysqli_error());
													mysqli_query($conn,"insert into notification (teacher_class_id,notification,date_of_notification,link,student_id) value('$teacher_class_id','$name_notification',NOW(),'student_quiz_list.php','$student_id[$i]')")or die(mysqli_error());
												} 
									?>
												<script>
													$.jGrowl("Quiz Added to students successfully", { header: 'Quiz Added' });
													window.location = 'teacher_quiz.php';
												</script>
									<?php
											}
									?>
								
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                </div>
            </div>
		<?php include('footer.php'); ?>
        </div>
		<?php include('script.php'); ?>

		<script>
			$(document).ready(function() {
				$("#teacher_class_id").on('change',function() {
					fetchRecordsfromDB(this.value);
				});

				function fetchRecordsfromDB(teacher_class_id){
					$.ajax({
						url: "add_quiz_to_student_get_students.php",
						cache: false,
						type: "POST",
						data: {teacher_class_id : teacher_class_id},
						success: function(html){
							$("#class_students").html(html);
						}
					});
				}
			});
		</script>
    </body>
</html>