<?php
    session_start();
    $_SESSION["sessionid"]=session_id();
    if (isset($_POST['submit'])) {
        include 'dbconnect.php';
        $email = $_POST['email'];
        $password = sha1($_POST['password']);
        $sqllogin = "SELECT * FROM table_users WHERE user_email = '$email' AND user_password='$password'";
        $stmt = $conn->prepare($sqllogin);
        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn();
    
        if ($number_of_rows  > 0) {
            $_SESSION["email"] = $email ;
            echo "<script>alert('Login Success');</script>";
            echo "<script> window.location.replace('index.php')</script>";
        } else {
            echo "<script>alert('Login Failed');</script>";
            echo "<script> window.location.replace('login.php')</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MyTutor Login</title>
        <link rel="stylesheet" href="http://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" style="css" href="../css/style.css">
        <script src="../js/login.js" defer></script>
    </head>

    <div class="w3-header w3-container w3-indigo w3-center w3-padding-20 w3-bold">
        <h3 class="w3-title" style="font-size:calc(3px + 3vw); font-weight: bold;">MyTutor</h3>
    </div>

    <body onload="loadCookies()">        
        <div style="display:flex; justify-content: center">
            <div class="w3-container w3-card w3-round w3-padding-16 w3-margin" style="width:1000px; margin:auto; text-align:left;">
                <form name="loginForm" class="w3-container w3-padding" action="login.php" method="post">
                    
                    <div class = "w3-half w3-center w3-middle">
                        <img src= "../res/logo.png" alt="MyTutor Logo" width="70%" height="70%">
                    </div>

                    <div class = "w3-half">
                        <div class= "w3-container" style="border-radius: 25px;">
                        <p>
                            <label class="w3-text-grey"><b>Email</b></label>
                            <input class="w3-input w3-bol w3-round w3-border w3-center" type="email" name="email" id="idemail" placeholder="Your email" required style="border-radius:20px;">
                        </p>
                        <p>
                            <label class="w3-text-grey"><b>Password</b></label>
                            <input class="w3-input w3-round w3-border w3-center" type="password" name="password" id="idpassword" placeholder="Your password" required style="border-radius:20px;">
                        </p>
                        <p>
                            <input class="w3-check" name="rememberme" type="checkbox" 
                            id="idremember" onclick="rememberMe()">
                            <label class="w3-normal">Remember Me</label>
                        </p>
                        <p><input class="w3-button w3-round w3-amber w3-block w3-bold" style="border-radius:25px;" type="submit" name="submit" id=idsubmit></p>
                        <p><a href="register.php" class="w3-center w3-normal" style="display:flex; justify-content: center">Create New Account</a>
                    </div>
                    </div> 
                </form>
            </div>
        </div>
        
        <div id="cookieNotice" class="w3-right w3-block" style="display: none;">
            <div class="w3-indigo">
                <h4>Cookie Consent</h4>
                <p>This website uses cookies or similar technologies, to enhance your
                    browsing experience and provide personalized recommendations.
                    By continuing to use our website, you agree to our
                    <a style="color:#115cfa;" href="/privacy-policy">Privacy Policy</a>
                </p>
                <div class="w3-button">
                    <button onclick="acceptCookieConsent();">Accept</button>
                </div>
            </div>
        </div>
        <br><br><br><br><br>
        <footer class="w3-footer w3-bottom w3-indigo w3-center w3-small">
            <p class="w3-small w3-normal">&emsp;Copyright: H'ng Zi Ling</p>
            <p class="w3-small w3-normal"><a href="mailto:hngziling@gmail.com">hngziling@gmail.com</a></p>
        </footer>
    </body>
    
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"> 
        let cookie_consent=getCookie("user_cookie_consent");
        if (cookie_consent!="") {
            document.getElementById("cookieNotice").style.display="none";
        } else {
            document.getElementById("cookieNotice").style.display="block";
        }
    </script>
</html>