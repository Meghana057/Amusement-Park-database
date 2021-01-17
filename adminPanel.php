<?php
    require("connection.php");
    require("credentials.php");
    session_start();

    if(!isset($_SESSION['admin_username']))
    {
        header("location: admin_login.php");
    }
    if(isset($_POST['logout']))
    {
        session_destroy();
        header("location: admin_login.php");
    }
    
    global $con;
    if(isset($_POST['create_btn']))
    {
        $checkExist=mysqli_real_escape_string($con,$_POST['checkExist']);

        if(empty($checkExist))
            {echo "<script>alert('Empty Phone Number');</script>";}
        else if(!(is_numeric($checkExist)) )
        {echo "<script>alert('Invalid Amount error!');</script>";}
    
        else
        {
            $query="SELECT * FROM customer where `phoneNo`='$checkExist';";
            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result)==1)
          {
              header("location: ticket.php?phoneNo=$checkExist");
          }
          else 
          {
              header("location: addCustomer.php?phoneNo=$checkExist");
          }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Theme Park</title>
</head>
<?php
include('navbar.php');
?>
<body>
  <div class="content"></div>
  <div class="container">
  <h1>New Park PASS</h1>
  <table>
  <tr>
  <td>Enter Phone Number</td>
  </tr><tr>
  <td><form method="POST">
  <input type="text" name="checkExist"></input>
  <button type="submit" name="create_btn" class="activityButton">NEXT</button>
  </form>
  </td></tr>
  </table>
  </div>
</body>
</html>
