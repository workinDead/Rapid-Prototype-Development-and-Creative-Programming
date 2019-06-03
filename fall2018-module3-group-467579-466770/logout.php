<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log out on Fox</title>
    <link rel="stylesheet" type="text/css" href="fsstyle.css">

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
    <?php
    session_unset();
    session_destroy();
    header("Location:login.html");
    ?>
</body>
</html>
