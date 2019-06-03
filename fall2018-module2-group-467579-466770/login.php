<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link type="text/css" rel="stylesheet" href="fsstyle.css">
</head>
<body>

<div class="content">
    <h2 style="text-align:center">Welcome to File Share System</h2>
    <div class="wrapper">
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="username"/>
        <input type="submit" class="submit" name="submit" value="login"/>
        <a href="register.php" class="in" style="font-size:15px">Without an account?</a>

    </form>
    </div>
    <div style="text-align:center" >
    <span class ="loginfb">
        <?php
            //we create four users: each one has one folder since the users have no right to build up folder in /srv/uploads
            $file = fopen("../../db/users.txt", "r");
           
            $users = array();
            while (!feof($file)) {
               $tmp = trim(fgets($file));
               if($tmp != ''){
                    $users[] = $tmp;
               }
            }
            fclose($file);
        ?>
        <?php
             if(isset($_POST['submit'])&&($_POST['submit']==login)){
             $username = $_POST['username'];
             if(in_array($username,$users)){
                session_start();
                $_SESSION['username'] = $username;
                 echo "Successfully Log-in!";
                 header("Location: mainpage.php");
             }
             else
             {
                session_start();
                session_unset();
                session_destroy();
                // echo trim($username);
                 if(trim($username)!=''){
                echo "Oops! Invalid Login Username. Please try again!";
                 }
                // header("Location:login.php");

                 }

 
                 }
            

        ?>
    </span>
    </div>
</div>
</body>
</html>