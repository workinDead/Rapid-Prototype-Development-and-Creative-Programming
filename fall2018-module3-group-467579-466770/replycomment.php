<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reply comment on Fox</title>
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
                if(!hash_equals($_SESSION['token'], $_POST['token'])){
                    die("Request forgery detected");
                }
                if($_SESSION['login_status']==1){
                $username = $_SESSION['username'];
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
    <div class="wrapper">
        <?php
        $mysqli = new mysqli('localhost','hlan','lanhou199681','fox');
        if($mysqli->connect_errno){
            printf("Conncetion Failed:%s\n",$mysqli->connect_error);
            exit;
        }
        $comment = $_POST['reply-input'];

        $username = $_SESSION['username'];
        $story_id= $_SESSION['story_id'];

        $stmt = $mysqli->prepare("insert into comments (username,comment,story_id) values (?,?,?)");
        if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
        }

        $stmt->bind_param('ssi', $username,$comment,$story_id);
        $stmt->execute();
        $stmt->close();


    if(!empty($comment)){

    ?>
    <div class="story-box" style="text-align:center;">
    <span class="material-icons nav-icons" style="font-size:60px;color:green;">done</span>
    <h2>Congratulations!</h2>
    </div>

    <?php
    }

    ?>

</div>
</div>
</body>
</html>