<?php 
    session_start();
    if (!isset($_SESSION['sessionid'])) {
        echo "<script> alert('Session not available. Please login');</script>";
        echo "<script> window.location.replace('login.php')</script>";
    }

    if (isset($_POST['submit'])) {
        include_once 'dbconnect.php';
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=sha1($_POST['password']);
        $phone=$_POST['phone'];
        $address=$_POST['address'];
        $sqlregister="INSERT INTO `table_users` (`user_name`, `user_email`, `user_password`, `user_phone`, `user_address`) 
        VALUES ('$name', '$email', '$password', '$phone', '$address')";
        
        try {
            $conn->exec($sqlregister);
            if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
                $last_id = $conn->lastInsertId();
                uploadImage($last_id);
                echo "<script> alert('Registration Successful')</script>";
                echo "<script> window.location.replace('login.php')</script>";
            }
        } catch (PDOException $e) {
                echo "<script> alert('Registration Failed')</script>";
                echo "<script> window.location.replace('register.php')</script>";
        }
    }

    function uploadImage($id)
    {
        $target_dir="../res/users/";
        $target_file=$target_dir . $id . ".png";
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" style="css" href="../css/style.css">
        <script src="../js/menu.js"></script>
        <script src="../js/scripts.js"></script>
    </head>

    <body>
        <div class="w3-container w3-margin">
            <div class="w3-card">
                <div class="w3-container w3-indigo w3-large w3-title w3-center" style="border-radius:25px 25px 0px 0px">
                    <p>New User Regiatration</p>
                </div>
                <form class="w3-container w3-padiing formco" name="registerForm" action="register.php" method="post" onSubmit="return confirmDialog()" enctype = "multipart/form-data">
                    <div class="w3-display-container w3-third">
                        <p>
                            <div class="w3-container w3-center w3-padding">
                                <img class="w3-image w3-round w3-margin" src="../res/upload.png" style="width:20vw; max-width:150px">
                                <br>
                                <input type="file" onchange="previewFile()" name="fileToUpload" id="fileToUpload" style="width:20vw">
                                <br>
                            </div>
                        </p>
                    </div>
                    <div class="w3-display-container w3-twothird">
                        <p> 
                            <label class="w3-bold">Name</label>
                            <input class = "w3-input w3-border w3-round w3-normal" name="name" id="idname" type="text"required style="border-radius:20px;">
                        </p>
                        <p> 
                            <label class="w3-bold">Email</label>
                            <input class = "w3-input w3-border w3-round w3-normal" name="email" id="idemail" type="email" placeholder="Example: hngziling@gmail.com" required style="border-radius:20px;">
                        </p>
                        <p> 
                            <label class="w3-bold">Password</label>
                            <input class = "w3-input w3-border w3-round" name="password" id="idpassword" type="password" required style="border-radius:20px;">
                        </p>
                        <p> 
                            <label class="w3-bold">Phone No</label>
                            <input class = "w3-input w3-border w3-round w3-normal" name="phone" id="idphone" type="phone" placeholder="Example : 012-4413822" required style="border-radius:20px;">
                        </p>
                        <p> 
                            <label class="w3-bold">Address</label>
                            <style>
                                .textarea { resize: none; }
                            </style>
                            <textarea class="textarea w3-input w3-border w3-normal" name="address" id="idaddress" required style="border-radius:20px;"></textarea>
                        </p>
                        <div class="row">
                            <input class="w3-input w3-border w3-block w3-amber w3-round w3-bold" style="border-radius:20px;" type="submit" name="submit" value="Submit">
                            <p><a href="login.php" class="w3-center w3-normal" style="display:flex; justify-content: center">Already register? Click to login</a>
                            <br>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <br><br><br><br><br>
        <footer class="w3-footer w3-bottom w3-light-grey w3-center w3-small">
            <p class="w3-small">&emsp;Copyright: H'ng Zi Ling</p>
            <p class="w3-small"><a href="mailto:hngziling@gmail.com">hngziling@gmail.com</a></p>
        </footer>
    </body>
</html>