<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mainpage</title>
    <link type="text/css" rel="stylesheet" href="fsstyle.css">
    <script>
    function checkAll() {
        
        var all=document.getElementById('all');//get id
        var one=document.getElementsByName('check[]');//get name
        if(all.checked==true){
            for(var i=0;i<one.length;i++){
                one[i].checked=true;
            }
 
        }else{
            for(var j=0;j<one.length;j++){
                one[j].checked=false;
            }
        }
    }
</script>
</head>
<body>
    <?php
        session_start();
        $username = $_SESSION['username'];
    ?>
    <form action="mainpage.php" method="post">
    <header>
        <nav>
            <ul>
                <li><a href = "logout.php">Logout</a></li>
                <li><a href="mainpage.php"><?php echo $username;?></a></li>
                <li><a href="upload.php?username=<?php echo $username;?>">Upload</a></li>
                <li><input type="submit" name="delete"  value="Delete"/>
                </li>
            </ul>
        </nav>
    </header>
    
    <div class="container">

        <div class="presentation">
            <input type="checkbox" id="all" name="all" value="all" onclick="checkAll()" />
            <div>Name</div>
            <div>Last modified time</div>
        </div>

        <?php
        //style=""
            $filepaths = sprintf("/srv/uploads/%s/*.*",$username);
            $files = glob($filepaths);
            $_SESSION['files'] = $files;
            //echo $filepaths;
            //printf("%s/%s",$files,$_SERVER['DOCUMENT_ROOT']);
            foreach($files as $file){
            ?>
            <div class="clouddata" >
            <input type="checkbox" name="check[]" value="<?php echo $file ?>"/>
            <a href="view.php?username=<?php echo $username;?>&file=<?php echo basename($file);?>">
            <?php
            echo basename($file);
            ?>
            </a>
            <div name="time"><?php echo date("Y-m-d H:i:s",fileatime($file))
           ;?></div>
            </div>

            <?php
            }
            if($_POST['delete'] == Delete){
                       $checkfiles = $_POST['check'];
                       $_SESSION['check'] = $_POST['check']; 
                       //$checkfiles = array_intersect_key($files,$checkids);
                       foreach($checkfiles as $checkfile){
                           unlink($checkfile);
                       }
            }
        ?>

    </div>
        </form>
</body>
</html>