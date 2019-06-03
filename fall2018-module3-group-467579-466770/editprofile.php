<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="personalpage.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

</head>
<body>


<header>
    <nav>
        <ul>
            <li>
                <a href="mainpage.php">
                    <span class="material-icons nav-icons">home</span>
                    <span class="text">
                            Home
                    </span>
                </a>
            </li>
            <?php

                session_start();
                if($_SESSION['login_status']==1){
                $username = $_SESSION['username'];
                $mysqli = new mysqli('localhost','hlan','lanhou199681','fox');
                if($mysqli->connect_errno){
                printf("Conncetion Failed:%s\n",$mysqli->connect_error);
                exit;
                }
                $stmt = $mysqli->prepare("select email, intro, location, birthday from users where username = ?");
                if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
                }
                $stmt->bind_param('s',$username);
                $stmt->execute();
                $stmt->bind_result($email, $intro, $location, $birthday );

                while($stmt->fetch()){
                echo $email;
                }
            ?>
             <li>
                <a href = "notification.php">
                        <span class="material-icons nav-icons">
                        notifications
                        </span>
                    <span class="text">
                            Notification
                        </span>
                    </a>
            </li>
            <li style="float:right;">
                <a href="logout.php">
                    <span class="text">
                        Log out
                    </span>
                </a>
            </li>
            <li style="float:right;">
                <a href = "personalpage.php">
                    <span class="text">
                        <?php echo $username;?>
                    </span>
                </a>
            </li>

            <?php
                }
                else{
                header("Location: login.html");
                ?>
            <li style="float:right;">
                <div>
                <a href="signup.html">Sign up </a>
                </div>
            </li>
            <li style="float:right;">
                <div>
                <a href="login.html">Log in</a>
                </div>
            </li>
            <?php
                }
            ?>
        </ul>
    </nav>
</header>
    <div class="container">
        <form action="editprofile.php" method="post">
        <div class="wrapper">
            <h1>&nbsp;Account</h1>
            <hr style="border-bottom: 1px solid #e6ecf0;">
            <div class="story-box" style="border-bottom: 0px;">
            <div>
                <strong>
                Username:
                </strong>
                <span class="text">
                <?php echo username?>
                </span>
            </div>
            <div>
                <strong>
                Password:
                </strong>
                <input name="password-input" type="password" placeholder="no longer than 30 letters">
                </input>
            </div>

            </div>

            <h1>&nbsp;Personal</h1>
            <hr style="border-bottom: 1px solid #e6ecf0;">

            <div class="story-box">
            <div>
                <strong>
                    Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </strong>
                <input name="email-input" type="text" placeholder="xxx@gmail.com" value="<?php echo $email;?>">
                </input>
            </div>
            <div>
                <strong>
                    Intro:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </strong>
                <input name="intro-input" type="text" value="<?php echo $intro;?>">
                </input>
            </div>
            <div>
                <strong>
                    Location:
                </strong>
                <input name="location-input" type="text" placeholder="STL, MO" value="<?php echo $location;?>">
                </input>
            </div>
            <div>
                <strong>
                    Birthday:
                </strong>
                <input name="birthday-input" type="text" placeholder="xx-xx-xxxx" value="<?php echo $birthday;?>">
                </input>
            </div>
            <div class="toolbar">
                <input type="submit" name="Update" value="Update">
            </div>
            </div>
        </div>
        </form>



        <?php

        if(isset($_POST['Update'])==1) {
        $password = trim($_POST['password-input']);
        $email = trim($_POST['email-input']);
        $intro = trim($_POST['intro-input']);
        $location = trim($_POST['location-input']);
        $birthday = trim($_POST['birthday-input']);



        if($password!=''){
        if(( !preg_match('/^[\w_\-]+$/', $password) )||(strlen($password) > 30)){
        echo "Invalid password";
        exit;
        }
        }
        $stmt = $mysqli->prepare("update users set password = ?, email=?, intro=?, location=?, birthday=? where username = ?");
        if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
        }
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param('ssssss',$password_hash,$email,$intro,$location,$birthday,$username);
        $stmt->execute();

        $stmt->close();

        }

        ?>
    </div>
</body>
</html>