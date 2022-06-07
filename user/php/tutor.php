<?php
    session_start();
    if (!isset($_SESSION['sessionid'])) {
        echo "<script>alert('Session not available. Please login');</script>";
        echo "<script> window.location.replace('login.php')</script>";
    }
    include_once("dbconnect.php");

    if (isset($_GET['submit'])) {
        $operation = $_GET['submit'];
        if ($operation == 'search') {
            $search = $_GET['search'];
                $sqltutor = "SELECT * FROM mytutordb.tbl_tutors WHERE tutor_name LIKE '%$search%'";
        }
    } else {
        $sqltutor = "SELECT * FROM mytutordb.tbl_tutors";
    }

    $results_per_page = 10;
    if (isset($_GET['pageno'])) {
        $pageno = (int)$_GET['pageno'];
        $page_first_result = ($pageno - 1) * $results_per_page;
    } else {
        $pageno = 1;
        $page_first_result = 0;
    }

    $stmt = $conn->prepare($sqltutor);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();
    $number_of_page = ceil($number_of_result / $results_per_page);
    $sqltutor = $sqltutor . " LIMIT $page_first_result , $results_per_page";
    $stmt = $conn->prepare($sqltutor);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();

    function truncate($string, $length, $dots = "...") {
        return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" 
        href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" style="css" href="../css/style.css">
        <script src="../js/menu.js" defer></script>
        <title>Welcome to MyTutor</title>
    </head>

    <body>
        <div class="w3-bar w3-light-grey w3-round w3-card-4 w3-hide-small">
            <a href="index.php" class="w3-bar-item w3-button w3-padding-16 w3-hover-none w3-border-white w3-bottombar w3-hover-border-blue w3-hover-text-blue w3-normal">Courses</a>
            <a href="tutor.php" class="w3-bar-item w3-button w3-padding-16 w3-hover-none w3-border-white w3-bottombar w3-hover-border-blue w3-hover-text-blue w3-normal">Tutors</a>
            <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hover-none w3-border-white w3-bottombar w3-hover-border-blue w3-hover-text-blue w3-normal">Subscription</a>
            <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hover-none w3-border-white w3-bottombar w3-hover-border-blue w3-hover-text-blue w3-normal">Profile</a>
            <a href="login.php" class="w3-bar-item w3-button w3-padding-16 w3-hover-none w3-border-white w3-bottombar w3-hover-border-blue w3-hover-text-blue w3-right w3-normal">Logout</a>
        </div>

        <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
            <button class="w3-bar-item w3-button w3-large w3-normal" 
                onclick="w3_close()">Close &times;
            </button>
            <a href="index.php" class="fa fa-book w3-bar-item w3-button w3-padding-16">&emsp;Courses</a>
            <a href="tutor.php" class="fa fa-mortar-board w3-bar-item w3-button w3-padding-16">&emsp;Tutors</a>
            <a href="#" class="fa fa-heart w3-bar-item w3-button w3-padding-16">&emsp;Subcription</a>
            <a href="#" class="fa fa-user w3-bar-item w3-button w3-padding-16">&emsp;Profile</a>
            <a href="login.php" class="fa fa-sign-out w3-bar-item w3-button w3-padding-16">&emsp;Logout</a>
        </div>

        <div class="w3-indigo">
            <button id="openNav" class="w3-button w3-blue w3-xlarge w3-padding-16 w3-hide-large w3-hide-medium " 
                onclick="w3_open()">&#9776;
            </button>
            <a href="index.php" class="w3-xlarge w3-hide-large w3-hide-medium w3-title" style="text-decoration: none;">&nbsp&nbsp&nbspMyTutor</a>
        </div>

        <div class="w3-card w3-container w3-padding w3-margin w3-round">
            <h3 class="w3-quarter w3-bold">Tutor Search</h3>
            <h5><input class="w3-half w3-input w3-block w3-round w3-border" type="search" name="search" placeholder="Enter search term" />
                <button class="w3-quarter w3-button w3-amber w3-round w3-right w3-normal w3-" type="submit" name="submit" value="search">Search</button>
            </h5>
        </div>

        <div class="w3-grid-template">
            <?php
                foreach($rows as $tutors) {
                    $tutorId = $tutors['tutor_id'];
                    $tutorEmail = truncate($tutors['tutor_email'],20);
                    $tutorPhone = $tutors['tutor_phone'];
                    $tutorName = truncate($tutors['tutor_name'],15);
                    $tutorPassword = $tutors['tutor_password'];
                    $tutorDesc = $tutors['tutor_description'];
                    $tutorDatereg = $tutors['tutor_datereg'];

                    echo "
                    <div class = 'w3-card-4 w3-light-grey w3-round' style='margin:10px;border-radius:20px'
                    <header><header class = 'w3-container w3-blue' style='border-radius:20px 20px 0px 0px'>
                    <h5 class = 'w3-bold'>$tutorName</h5></header></header>";

                    echo "<img class = 'w3-image' src='../../assets/tutors/$tutorId.jpg'" .
                    " onerror = this.onerror=null; this.src='src=../res/defaultTutor.png'"
                    . " style='width:100%;height:250px'>";

                    echo "<div class='w3-card-footer w3-container w3-left-align'><hr>
                    <p><i class='fa fa-envelope-o' style='font-size:16px'></i>&nbsp&nbsp<b>Email :</b><h5 class='w3-normal w3-medium'>$tutorEmail</h5><br>
                    <i class='fa fa-phone' style='font-size:16px'></i>&nbsp&nbsp<b>Phone :</b><h5 class='w3-normal w3-medium'>$tutorPhone</h5></p>
                    <div class = 'w3-center w3-padding-16'>
                    <a class='w3-button w3-hover-blue w3-center w3-border' style='border-radius:20px;' href='#'>View All</a>
                    </div></div></div>";
                }
            ?>
        </div>

        <br>
        <?php
        $num = 1;
        if ($pageno == 1) {
            $num = 1;
        } else if ($pageno == 2) {
            $num = ($num) + 10;
        } else {
            $num = $pageno * 10 - 9;
        }
        echo "<div class='w3-container w3-row'>";
        echo "<center>";
        for ($page = 1; $page <= $number_of_page; $page++) {
            echo '<a href = "tutor.php?pageno=' . $page . '" class = "w3-normal" style=
            "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
        }
        echo "&emsp;( " . $pageno . " )";
        echo "</center>";
        echo "</div>";
        ?>
        <br><br><br>
        <footer class="w3-footer w3-bottom w3-light-grey w3-center w3-small">
            <p class="w3-small w3-normal">&emsp;Copyright: H'ng Zi Ling</p>
            
        </footer>
    </body>
</html>
