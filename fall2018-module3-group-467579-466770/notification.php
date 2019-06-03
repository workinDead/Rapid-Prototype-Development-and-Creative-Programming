<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications on Fox</title>
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
            ?>
             <li>
                <a href = "notification.php"  class="active">
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
    <div class="wrapper">
        <h1>&nbsp;Comments</h1>
        <hr style="border-bottom: 1px solid #e6ecf0;">

        <?php

        $mysqli = new mysqli('localhost','hlan','lanhou199681','fox');
        if($mysqli->connect_errno){
        printf("Conncetion Failed:%s\n",$mysqli->connect_error);
        exit;
        }

        $stmt = $mysqli->prepare("select stories.username as username_init,stories.story_id, story_title,story, story_time, comments.username as username_reply,comment_id,comment,comment_time from stories left outer join comments on stories.story_id = comments.story_id where comments.username=?");

        if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
        }

        $stmt->bind_param('s', $username);

        $stmt->execute();
        $stmt->bind_result($username_init, $story_id, $story_title, $story, $story_time,$username_reply,$comment_id,$comment,$comment_time);

        while($stmt->fetch()&&($_SESSION['login_status']== 1)){
        ?>
        <div class="story-box">

            <div class="story-header">
                <span>Reply @ <?php echo $comment_time;?>:</span>
                <span><?php echo $comment ;?></span>
                <a style="float:right;" href="editcomment.php?story_id=<?php echo $story_id;?>&comment_id=<?php echo $comment_id;?>" >
                <span class="material-icons tool-icons">edit</span>
                </a>
               <a style="float:right;"  href="delete.php?story_id=<?php echo $story_id;?>&comment_id=<?php echo $comment_id;?>&status=2" >
               <span class="material-icons tool-icons">delete</span>
               </a>
            </div>
            <div class="quote-story">
                <div class="story-header">
                    <a>
                        <strong>
                            <?php echo $username_init;?>
                        </strong>
                    </a>
                    <span class="time">&nbsp;@<?php echo $story_time;?></span>
                </div>
                <div>
                    <h3><?php echo $story_title;?></h3>
                    <p>
                        <?php echo($story);?>
                    </p>
                </div>

            </div>
        </div>

        <?php
        }
        ;?>
    </div>
</div>

</body>
</html>