 <?php
 include('admin/dbcon.php');
 include('session.php');
 
 
                            if (isset($_POST['change'])) {
                               

                                $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
                                $image_name = addslashes($_FILES['image']['name']);
                                $image_size = getimagesize($_FILES['image']['tmp_name']);

                                $accept = ["image/jpeg", "image/png", "image/gif", "image/webp"];
                                $image_type = strtolower($_FILES["image"]["type"]);

                                $folder = 'admin/uploads/';
                                if(!file_exists($folder))
                                {
                                    mkdir($folder,0777,true);
                                }

                                if (in_array($image_type, $accept)) {

                                    move_uploaded_file($_FILES["image"]["tmp_name"], "admin/uploads/" . $_FILES["image"]["name"]);

                                    $location = "uploads/" . $_FILES["image"]["name"];
                                    
                                    mysqli_query($conn,"update  teacher set location = '$location' where teacher_id  = '$session_id' ")or die(mysqli_error());
                                     
                                } else {
                                    $_SESSION['ERROR_AVATAR_UPLOAD'] = "Failed to update avatar due to invalid file type.";
                                }

								?>
 
								<script>
								    window.location = "dasboard_teacher.php";  
								</script>

                       <?php     }  ?> 