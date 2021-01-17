<?php
      require("connection.php");
      require("credentials.php");
      if(isset($_POST['Signin']))
      {
          $query = "SELECT * FROM `admin_login` WHERE `admin_username`='$_POST[admin_username]' AND `admin_password`='$_POST[admin_password]'";
          $result=mysqli_query($con,$query);
          if(mysqli_num_rows($result)==1)
          {
              session_start();
              $_SESSION['admin_username']=$_POST['admin_username'];
              header("location: adminPanel.php");
          }
          else 
          {
              echo "<script>alert('Incorrect username or password!');</script>";
          }
      }
?>

<html>
<head>
<title>Admin Login Panel</title>
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<link rel="stylesheet" type="text/css" href="admin_login.css">

<script src="https://kit.fontawesome.com/cd0eff0a5d.js" 
crossorigin="anonymous"></script>
</head>
<body>
    <div class="login-form">
        <h2>ADMIN LOGIN</h2>
        <form method="POST">
            <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Username" name="admin_username">
                
            </div>
            <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Password" name="admin_password">
                <button type="submit" name="Signin">Login in</button>
            </div>
            <!-- <button type="submit" name="Signin">Sign in</button> -->
            
        </form>
    </div>
   
</body>
</html>
