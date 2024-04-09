<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Assets\CSS\Login-SignStyle.css">
  <title>Login</title>
</head>
<body>
  <div class="container">
    <div class="box form-box">
      <?php
        include 'Php/Config.php';
        if(isset($_POST['submit'])){
          $username = $_POST['username'];
          $password = $_POST['password'];

          $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
          $result = mysqli_query($con, $sql);
          if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            session_start();
            $_SESSION['username'] = $row['UserName'];
            $_SESSION['valid'] = $row['Email'];
            $_SESSION['id'] = $row['Id'];
            if(isset($_SESSION['username'])){
              header('location:Pages/DashBoard.php');
            }
          } else {
            echo "<script>alert('Invalid username or password!')</script>";
          }
        }
      ?>
      <header>Login</header>
      <form action="" method="post">
        <div class="field input">
          <label for="username">Username</label>
          <input type="text" name="username" id="" autocomplete="off" required>
        </div>

        <div class="field input">
          <label for="password">Password</label>
          <input type="password" name="password" id="" autocomplete="off" required>
        </div>

        <div class="field">
          <input type="submit" class="btn" name="submit" value="Login">
        </div>
        <div class="links">
          Don't have an account? <a href="Pages/Register.php">Sign up</a>
        </div>        
      </form>
    </div>
  </div>
</body>
</html>