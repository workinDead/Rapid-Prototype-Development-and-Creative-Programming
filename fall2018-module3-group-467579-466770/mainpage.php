<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Explore on Fox</title>
    <link type="text/css" rel="stylesheet" href="personalpage.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

</head>
<body>

<header>
    <nav>
        <ul>

            <li>
                <a href="mainpage.php" class="active">
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
            <form action="searchstory.php" method="post">
            <li style="float:right;">
                <div>
                    <input class="search-input" type="text" id="search-query" placeholder="Search Fox" name="q" autocomplete="off" spellcheck="false" aria-autocomplete="list" aria-expanded="false" aria-owns="typeahead-dropdown-1">
                </div>
            </li>
            <li style="float:right;">
                <div>
                <input type="submit" value="Go">
                </div>
            </li>
            </form>
            <li style="float:right;">
            <h1 style="padding: 0px 170px 0px 0px;">THE FOX STORIES</h1>
            </li>
           <li style="float:right;">
            <div>
            <img src="icon_Fox.png"></img>
            </div>
            </li>


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

        $stmt = $mysqli->prepare("select username, stories.story_id, story, story_title, link, story_time from stories left outer join links on stories.story_id = links.story_id order by story_time DESC");
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
                  <a style="float:right;" href="eachstory.php?story_id=<?php echo $story_id;?>">
                  <span class="material-icons tool-icons">link</span>
                  </a>
            </div>
            <div>
                <h2><?php echo $story_title;?></h2>

            </div>
        </div>
        <?php
            }
            ?>

    </div>

</div>




</body>
</html>