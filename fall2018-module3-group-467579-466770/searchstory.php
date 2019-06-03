<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search on Fox</title>
    <link type="text/css" rel="stylesheet" href="login.css">
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

        $content = $_POST['q'];

        $stmt = $mysqli->prepare("select count(*) from stories where story_title like '%$content%' OR story like '%$content%'");
        if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
        }
        $stmt->execute();
        $stmt->bind_result($result_cnt);
        while($stmt->fetch()){
        printf("<p style=\"color: #657786;\">&nbsp;&nbsp;About %s results are shown</p>",$result_cnt);
        }



        $stmt = $mysqli->prepare("select username, stories.story_id, story, story_title, link, story_time from stories left outer join links on stories.story_id = links.story_id where story_title like '%$content%' OR story like '%$content%'");
        if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
        }
        $stmt->execute();
        $stmt->bind_result($username, $story_id, $story, $story_title,$link, $story_time);

        while($stmt->fetch()){

        ?>

        <div class="story-box" name=<?php echo $story_id;?>>
                   <div class="story-header">
                       <strong>
                           <?php echo $username;?>
                       </strong>
                       <span class="time">&nbsp;@<?php echo $story_time;?></span>
                   </div>
                   <div>
                       <h2><?php echo $story_title;?></h2>
                       <p>
                           <?php echo($story);?>
                       </p>
                        <a href= "<?php echo($link);?>">
                        <?php echo($link);?>
                        </a>
                   </div>
       </div>


        <?php

            }
            ?>

    </div>

</div>


</body>
</html>