<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit comment on Fox</title>
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
        <?php
         $mysqli = new mysqli('localhost','hlan','lanhou199681','fox');
        if($mysqli->connect_errno){
        printf("Conncetion Failed:%s\n",$mysqli->connect_error);
        exit;
        }
        $story_id = $_GET['story_id'];
        $comment_id = $_GET['comment_id'];

        $stmt = $mysqli->prepare("select stories.username as username_init,stories.story_id, story_title,story, story_time, comments.username as username_reply,comment_id,comment,comment_time from stories left outer join comments on stories.story_id = comments.story_id where comments.comment_id=?");

        if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
        }

        $stmt->bind_param('s', $comment_id);

        $stmt->execute();
        $stmt->bind_result($username_init, $story_id, $story_title, $story, $story_time,$username_reply,$comment_id,$comment,$comment_time);

        while($stmt->fetch()){
        ?>
<div class="story-box">
    <form action="editcomment.php?story_id=<?php echo $story_id;?>&comment_id=<?php echo $comment_id;?>" method="post">
        <div class="story-header">
            <span>Reply @ <?php echo $comment_time;?>:</span>
            <textarea name="comment-input" rows="1"><?php echo $comment;?></textarea>
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
        <div class="toolbar">
                <input type="submit" name="Update" value="Update">
        </div>
    </form>

</div>

        <?php
        }
        if(isset($_POST['Update'])==1) {

        $comment = htmlspecialchars(trim($_POST['comment-input']));

        $comment;
        $stmt = $mysqli->prepare("update comments set comment=? where comments.comment_id = ?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
        	exit;
        }
        $stmt->bind_param('ss',$comment,$comment_id);
        $stmt->execute();
        }

        ?>

    </div>
</div>
</body>
</html>