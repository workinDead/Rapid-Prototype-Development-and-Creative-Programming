<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link type="text/css" rel="stylesheet" href="fsstyle.css">

</head>
<body>
<h2 style="text-align:center">Sign up for File Share System</h2>

        <div class="wrapper">
        <form action="register.php" method="post">
        <input type="text" name="usertmp" placeholder="username"/>
        <input type="submit" name="submit" value="signin"/>
        <a href="login.php" class="in" style="font-size:15px;">Already exists an account?</a>     
    </form>
    </div>

    <?php
        if(isset($_POST['submit'])&&$_POST['submit']=signin){
            $usertmp = trim($_POST['usertmp']);
            if($usertmp!=''){
            if( !preg_match('/^[\w_\-]+$/', $usertmp) ){
        	    echo "Invalid username";
        	    exit;
               }
            }
            $user_folder = sprintf("/srv/uploads/%s", $usertmp);
            if (!file_exists($user_folder)) {
                mkdir($user_folder, 0777, true);
                $handle = fopen("../../db/users.txt", "a");
           
                //  $users = array();
                //   while (!feof($handle)) {
                //      $tmp = trim(fgets($file));
                //       if($tmp != ''){
                //     $users[] = $tmp;
                //    }
                //   }
                //   echo $users;
                //   array_push($users,$username);
                fwrite($handle,"\n".$usertmp);
                fclose($file);
            }
            if(file_exists($user_folder)){
                echo "Congradulations!";
                sleep(5);
                header("Location:login.php");
            }
        }
    ?>
</body>
</html>