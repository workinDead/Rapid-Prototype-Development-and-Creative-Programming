<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Story Page on Fox</title>
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
             session_start;
             $story_id = $_GET['story_id'];
             $_SESSION['story_id']=$story_id;
             $mysqli = new mysqli('localhost','hlan','lanhou199681','fox');
             if($mysqli->connect_errno){
                 printf("Conncetion Failed:%s\n",$mysqli->connect_error);
                 exit;
             }
             $stmt = $mysqli->prepare("select username, stories.story_id, story, story_title, link, story_time from stories left outer join links on stories.story_id = links.story_id where stories.story_id=?");

             if(!$stmt){
                 printf("Query Prep Failed: %s\n", $mysqli->error);
                 exit;
             }
 
             $stmt->bind_param('i', $story_id);
 
             $stmt->execute();
            $stmt->bind_result($username_init, $story_id, $story, $story_title,$link, $story_time);

            while($stmt->fetch()){
            ?>
            <div class="story-box">
                <div class="story-header">
                     <strong>
                     <?php echo $username_init;?>
                     </strong>
                     <span class="time">&nbsp;Post @<?php echo $story_time;?></span>

                 </div>
                 <div>
                     <h1><?php echo $story_title;?></h1>
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
             $stmt = $mysqli->prepare("select stories.username as username_init, stories.story_id, story_title,story, story_time, comments.username as username_reply, comment,comment_time,comment_id from stories left outer join comments on stories.story_id = comments.story_id where stories.story_id=? order by comment_time desc");
             if(!$stmt){
                 printf("Query Prep Failed: %s\n", $mysqli->error);
                 exit;
             }

             $stmt->bind_param('i', $story_id);

             $stmt->execute();
             $stmt->bind_result($username_init, $story_id, $story_title, $story, $story_time,$username_reply,$comment,$comment_time,$comment_id);
             $stmt->store_result();
             $num_of_results = $stmt->num_rows;
            while($stmt->fetch()){
            if (!empty($comment)){
            ?>
            <div class="story-box">
                <div class="story-header">
                     <strong>
                     <?php echo $username_reply;?>
                     </strong>
                     <span class="time">&nbsp;Reply @<?php echo $comment_time;?></span>
                 </div>
                  <div>
                      <p>
                      <?php echo($comment);?>
                      </p>

                  </div>
            </div>

             <?php
                }
            }
            if($_SESSION['login_status']== 1){

            ?>
            <div class="story-box">
                <form action="replycomment.php" method="post">
                <textarea name="reply-input"></textarea>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                <input type="submit" value="reply">
                </form>
            </div>
            <?php
            }

            ?>
        </div>

    </div>

</body>
</html>
