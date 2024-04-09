<?php
  if(!isset($_SESSION)){
    session_start();
  }else{
    if(!isset($_SESSION['username'])){
      header('location:../index.php');
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DashBoard</title>
</head>
<body>
  <H1><?php echo("Welcome ".$_SESSION['username']);?></H1>
</body>
</html>