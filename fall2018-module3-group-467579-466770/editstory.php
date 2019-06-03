<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit story on Fox</title>
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
        session_start();
        $username = $_SESSION['username'];

        $stmt = $mysqli->prepare("select username,story_title,story,link,story_time from stories left outer join links on stories.story_id = links.story_id where stories.story_id=?");
        if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
        }

        $stmt->bind_param('i', $story_id);
        $stmt->execute();
        $stmt->bind_result($username,$story_title,$story,$link,$story_time);

        while($stmt->fetch()){
        ?>
        <div class="story-box">
            <form action="editstory.php?story_id=<?php echo $story_id;?>" method="post">
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
                <a style="float:right;"  href="delete.php?story_id=<?php echo $story_id;?>" >
                    <span class="material-icons tool-icons">delete</span>
                </a>
                <a style="float:right;" href="editstory.php?story_id=<?php echo $story_id;?>" >
                    <span class="material-icons tool-icons">edit</span>
                </a>
            </div>
            <div>
                <strong>
                Title:
                </strong>
                <textarea name="title-input" rows="1">
                <?php echo trim($story_title);?>
                </textarea>
            </div>
            <div>
                <strong>
                Story:
                </strong>
                <textarea name="story-input" rows="4">
                <?php echo trim($story);?>
                </textarea>
            </div>
            <div>
                <strong>
                Link:
                </strong>
                <textarea rows="1" name="link-input" rows="1">
                <?php echo trim($link);?>
                </textarea>
            </div>
            <div class="toolbar">
                <input type="submit" name="Update" value="Update">
            </div>
            </form>
        </div>

        <?php
        }
        if(isset($_POST['Update'])==1) {
        $story_title = htmlspecialchars(trim($_POST['title-input']));
        echo $story_title;

        $story = htmlspecialchars(trim($_POST['story-input']));
        echo $link;

        $link = htmlspecialchars(trim($_POST['link-input']));
        echo $link;
        $stmt = $mysqli->prepare("update stories set story_title=?,story = ? where story_id = ?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
        	exit;
        }
        $stmt->bind_param('ssi',trim($story_title),trim($story),$story_id);
        $stmt->execute();

        $stmt = $mysqli->prepare("update links set link=? where story_id = ?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('si',trim($link),$story_id);
        $stmt->execute();
        $stmt->close();

        }


        ?>

    </div>
</div>
</body>
</html>