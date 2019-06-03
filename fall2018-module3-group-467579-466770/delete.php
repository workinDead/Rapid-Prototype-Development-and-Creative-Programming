<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Personal Page</title>
    <link type="text/css" rel="stylesheet" href="personalpage.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

</head>
<body>
    <?php
        session_start();
        $username = $_SESSION['username'];
    ?>

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
            </ul>
        </nav>
    </header>
    <div class="container">

        <div class="wrapper">

    <?php
         session_start();
         $story_id = $_GET['story_id'];
         $comment_id = $_GET['comment_id'];
         $_SESSION['story_id']=$story_id;
         $_SESSION['comment_id']=$comment_id;
         $mysqli = new mysqli('localhost','hlan','lanhou199681','fox');
         if($mysqli->connect_errno){
             printf("Conncetion Failed:%s\n",$mysqli->connect_error);
             exit;
         }
        $status=$_GET['status'];
            if($status==2){
            $del_comment = $mysqli->prepare("delete from comments where comment_id = '$comment_id'");
            if(!$del_comment){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $del_comment->execute();
            exit;
             }
            elseif ($status == 1){
            $del_comment = $mysqli->prepare("delete from comments where story_id = '$story_id'");
            if(!$del_comment){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $del_comment->execute();
            $del_link = $mysqli->prepare("delete from links where story_id = '$story_id'");
            if(!$del_comment){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $del_link->execute();
            $del_story = $mysqli->prepare("delete from stories where story_id = '$story_id'");
            if(!$del_story){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $del_story->execute();
        }



?>
        </div>

    </div>


</body>
</html>