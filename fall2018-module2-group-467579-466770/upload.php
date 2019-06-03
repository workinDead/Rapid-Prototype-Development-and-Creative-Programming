<!DOCTYPE html>
<html lang='en'>

	<head>
		<title>Upload</title>
		<link type="text/css" rel="stylesheet" href="fsstyle.css">
	</head>
	<body>
    <?php
        session_start();
        $username = $_SESSION['username'];
    ?>
    <header>
        <nav>
            <ul>
                <li><a href = "logout.php">Logout</a></li>
                <li><a href="mainpage.php"><?php echo $username;?></a></li>
                <li><a href="upload.php?username=<?php echo $username;?>">Upload</a></li>
                <li><a>Delete</a></li>
            </ul>
        </nav>
    </header>
	<h3 style="text-align:center">Choose a file to upload</h3>
    <form class="wrapper" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	<p>
		<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
		<input name="uploadedfile" type="file" id="uploadfile_input" />
	</p>
	<p>
		<input type="submit" name="submit" value="Upload File" />
	</p>
    </form>
    <div style="text-align:center">
    <span class = "uploadfb">
    <?php
    if (isset($_POST['submit'])){
    session_start();
    $filename = basename($_FILES['uploadedfile']['name']);

    // Get the username and make sure it is valid
    $username = $_SESSION['username'];
    if( !preg_match('/^[\w_\-]+$/', $username) ){
    	echo "Invalid username";
    	exit;
    }
    //upload file
    //filtering input

    $user_folder = sprintf("/srv/uploads/%s", $username);
    if (!file_exists($user_folder)) {
        mkdir($user_folder, 0777, true);
    }
    $full_path = sprintf("/srv/uploads/%s/%s",$username,$filename);
    //echo $full_path;

    if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
        echo "Congradulations!";
    	exit;
    }else{
        echo "Oops!";
    	exit;
    }
    }
    ?>
    </span>
    </div>
</body>
</html>
