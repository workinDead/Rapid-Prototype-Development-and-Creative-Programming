<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Personal Page</title>
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
                //echo $_SESSION['profile_img'];
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
                <a href = "personalpage.php"  class="active">
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
        <div class="profilecard">
            <ul>
                <li>
                    <div class="profilecard-image">
                        <img class="profilecard-image" src = "<?PHP echo $_SESSION['profile_img'];?>"></img>
                    </div>
                </li>
                <li>
                <div class="profile-stats">
                    <div style="text-align: center;">
                    <strong>
                        @<?php echo $username;?>
                    </strong>
                    </div>
                    <div style="text-align: center;">
                    <a  href="editprofile.php">
                        Edit Profile
                    </a>
                    </div>
                    <div style="text-align: center;">
                    <a href="upload.php" >
                        <span class="material-icons tool-icons" >insert_photo</span>
                    </a>
                    </div>
                </div>
                </li>
            </ul>
        </div>
        <div class="wrapper">
            <div class="post-box">
                <form action="poststory.php" method="post">
                    <div>
                        <textarea rows="1" name="title-input" placeholder="Enter your Title" ></textarea>
                    </div>
                    <div>
                        <textarea rows="4" name="story-input" placeholder="Enter your Story" ></textarea>
                    </div>
                    <div>
                        <textarea rows="1" name="link-input" placeholder="Enter your Link" ></textarea>
                    </div>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />

                    <div class="toolbar">
                        <input type="submit" name="story-post" value="Post">
                    </div>

                </form>
            </div>
            <?php
            $mysqli = new mysqli('localhost','hlan','lanhou199681','fox');
            if($mysqli->connect_errno){
                printf("Conncetion Failed:%s\n",$mysqli->connect_error);
                exit;
            }

            $stmt = $mysqli->prepare("select username, stories.story_id,story_title,story,link, story_time from stories left outer join links on stories.story_id = links.story_id where username=? order by story_time DESC");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }

            $stmt->bind_param('s', $username);

            $stmt->execute();
            $stmt->bind_result($username_init, $story_id, $story_title, $story, $link,$story_time);

            while($stmt->fetch()&&($_SESSION['login_status']== 1)){
            ?>
            <div class="story-box">
                <div class="story-header">
                     <a href="personalpage.php">
                     <strong>
                     <?php echo $username;?>
                     </strong>
                     </a>
                     <span class="time">&nbsp;@<?php echo $story_time;?></span>
                      <a style="float:right;" href="eachstory.php?story_id=<?php echo $story_id;?>">
                      <span class="material-icons tool-icons">link</span>
                      </a>
                      <a style="float:right;"  href="delete.php?story_id=<?php echo $story_id;?>&status=1" >
                      <span class="material-icons tool-icons">delete</span>
                      </a>
                        <a style="float:right;" href="editstory.php?story_id=<?php echo $story_id;?>" >
                        <span class="material-icons tool-icons">edit</span>
                        </a>
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
