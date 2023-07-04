
<?php
    include('dbcon.php');
    include('session.php');

    if (isset($_POST["teacher_class_id"]) && !empty($_POST["teacher_class_id"])) {
        $teacher_class_id = $_POST['teacher_class_id'];

        $get_class_students_qry = "SELECT tcs.teacher_class_student_id,
                                            tcs.teacher_class_id,
                                            tcs.student_id,
                                            tcs.teacher_id,
                                            s.firstname,
                                            s.lastname,
                                            s.username AS student_campus_id
                                    FROM `teacher_class_student` tcs
                                        JOIN student s ON tcs.student_id = s.student_id AND s.status='Registered'
                                    WHERE tcs.teacher_class_id = '$teacher_class_id'";
        $query = mysqli_query($conn,$get_class_students_qry)or die(mysqli_error());
        $count = mysqli_num_rows($query);
        if($count > 0) {
            while($row = mysqli_fetch_array($query)) 
            {
                $student_id = $row['student_id'];
?>
                <tr> 
                    <td width="30">
                        <input id="optionsCheckbox" class="uniform_on" name="student_id[]" type="checkbox" value="<?php echo $student_id; ?>">
                    </td>
                    <td><?=$row['student_campus_id'];?></td>
                    <td><?=$row['firstname'] . " " . $row['lastname'];?></td>
                </tr>
<?php
            }
        } else {
?>
            <tr>
                <td colspan="3">Class is empty. Please add students first.</td>
            </tr>
<?php
        }
    }

?>