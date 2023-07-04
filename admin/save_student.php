<?php
    include('dbcon.php');
        
    $un = $_POST['un'];
    $fn = $_POST['fn'];
    $ln = $_POST['ln'];
    $class_id = $_POST['class_id'];

    $query = mysqli_query($conn,"select * from student where username='$un'")or die(mysqli_error());
    $row = mysqli_fetch_array($query);
    if(empty($row)) {
        $un = $un;

        mysqli_query($conn,"insert into student (username,firstname,lastname,location,class_id,status)
		values ('$un','$fn','$ln','uploads/NO-IMAGE-AVAILABLE.jpg','$class_id','Unregistered')                                    
		") or die(mysqli_error()); 

        echo 'true';

    } else {
        echo 'false';
    }
?>
<?php    

?>