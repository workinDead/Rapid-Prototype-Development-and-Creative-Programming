<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup on Fox</title>
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
            <li style="float:right;">
                <div>
                <a href="signup.html" class="active">Sign up </a>
                </div>
            </li>
            <li style="float:right;">
                <div>
                <a href="login.html">Log in</a>
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

$username = trim($_POST['username']);
$password = trim($_POST['password']);

if($username!=''){
    if(( !preg_match('/^[\w_\-]+$/', $username) )||(strlen($username) > 30)){
           ?>
           <div class="story-box" style="text-align:center;">
           <span class="material-icons nav-icons" style="font-size:60px;color:red;">close</span>
           <h2>Invalid username!</h2>
           </div>
           <?php
           exit;
        }
}
if($password!=''){
        if(( !preg_match('/^[\w_\-]+$/', $password) )||(strlen($password) > 30)){
                   ?>
                   <div class="story-box" style="text-align:center;">
                   <span class="material-icons nav-icons" style="font-size:60px;color:red;">close</span>
                   <h2>Invalid password!</h2>
                   </div>
                   <?php
                   exit;
            }
}
$result = mysqli_query($mysqli, "select * from users where username = '$username'");
$row_cnt = mysqli_num_rows($result);
if ($row_cnt == 1){
   ?>
   <div class="story-box" style="text-align:center;">
   <span class="material-icons nav-icons" style="font-size:60px;color:red;">close</span>
   <h2>This username already exists!</h2>
   </div>
   <?php
   exit;
}
else{
    $stmt = $mysqli->prepare("insert into users (username, password) values (?,?);");
    if(!stmt){
        printf("Query Prep Failed: %s\n",$mysqli->error);
        exit;}
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt->bind_param('ss',$username,$password_hash);
    $stmt->execute();
}

$stmt = $mysqli->prepare("select username, password from users where username=?");
if(!stmt){
    printf("Query Prep Failed: %s\n",$mysqli->error);
    exit;}


$stmt->bind_param('s',$username);
$stmt->execute();
$stmt->bind_result($username_init, $password_init);

while($stmt->fetch()){
if(!empty($username)){
    ?>
    <div class="story-box" style="text-align:center;">
    <span class="material-icons nav-icons" style="font-size:60px;color:green;">done</span>
    <h2><?php echo $username_init;?>, Start your Journey on Fox</h2>
    </div>

    <?php
        }
    }
    $stmt->close();
    if(empty($username_init)){
    ?>

    <div class="story-box" style="text-align:center;">
    <span class="material-icons nav-icons" style="font-size:60px;color:red;">close</span>
    <h2><?php echo $username_init;?>Please sign up again!</h2>
    </div>
    <?php
    }
    ?>
        </div>
    </div>
</body>
</html>