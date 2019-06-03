<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <link rel="stylesheet" type="text/css" href="fsstyle.css">

</head>
<body>
    <?php
    session_start();
    session_unset();
    session_destroy();
    header("Location:login.php");
    ?>

</body>
</html>
