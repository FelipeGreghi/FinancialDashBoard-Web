<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="..\Assets\CSS\Login-SignStyle.css">
  <title>Sign Up</title>
</head>
<body>
  <div class="container">
    <div class="box form-box">
        <?php
            include '../Php/Config.php';
            if(isset($_POST['submit'])){
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirmPassword'];

                //create a querry to check if the email already exists
                $emailValidate = "SELECT * FROM users WHERE email = '$email'";
                $validate = mysqli_query($con, $emailValidate);
                if(mysqli_num_rows($validate) > 0){
                    echo "<script>alert('Email already exists!')</script>";
                }else{
                    if($password == $confirmPassword){
                        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
                        $result = mysqli_query($con, $sql);
                        if($result){
                            echo "<script>alert('User registered successfully!')</script>";
                        } else {
                            echo "<script>alert('Failed to register user!')</script>";
                        }
                    } else {
                        echo "<script>alert('Passwords do not match!')</script>";
                    }
                }
            }
        ?>
      <header>Sign Up</header>
      <form action="" method="post">
        <div class="field input">
          <label for="username">Username</label>
          <input type="text" name="username" id="" autocomplete="off" required>
        </div>

        <div class="field input">
          <label for="email">E-mail</label>
          <input type="text" name="email" id="" autocomplete="off" required>
        </div>

        <div class="field input">
          <label for="password">Password</label>
          <input type="password" name="password" id="" autocomplete="off" required>
        </div>

        <div class="field input">
          <label for="confirmPassword">Confirm password</label>
          <input type="password" name="confirmPassword" id="" autocomplete="off" required>
        </div>

        <div class="field">
          <input type="submit" class="btn" name="submit" value="Register">
        </div>
        <div class="links">
          Already a member? <a href="..\index.php">Sign in</a>
        </div>        
      </form>
    </div>
  </div>
</body>
</html>