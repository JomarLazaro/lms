<?php
include('session.php');
include('dbcon.php');
if (isset($_POST['read']) && isset($_POST['selector'])) {
    $id = $_POST['selector'];
    if (!empty($id)) {
        $N = count($id);
        for ($i = 0; $i < $N; $i++) {
            $result = mysqli_query($conn, "UPDATE message SET message_status = 'read' WHERE message_id='$id[$i]'");
        }
    }
    header("location: student_message.php");
}
?>

<?php
if (isset($_POST['reply'])) {
    $sender_id = $_POST['sender_id'];
    $sender_name = $_POST['name_of_sender'];
    $my_name = $_POST['my_name'];
    $my_message = $_POST['my_message'];

    mysqli_query($conn, "INSERT INTO message (reciever_id, content, date_sended, sender_id, reciever_name, sender_name) VALUES ('$sender_id', '$my_message', NOW(), '$session_id', '$sender_name', '$my_name')") or die(mysqli_error());
    mysqli_query($conn, "INSERT INTO message_sent (reciever_id, content, date_sended, sender_id, reciever_name, sender_name) VALUES ('$sender_id', '$my_message', NOW(), '$session_id', '$sender_name', '$my_name')") or die(mysqli_error());
?>
    <script>
        alert('Message Sent');
        window.location = "student_message.php";
    </script>
<?php
}
?>
