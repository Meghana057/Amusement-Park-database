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
        if(isset($_POST['delete-btn']))
    {
        $delName=$_POST['delUser'];
        if($delName==$_SESSION['admin_username'])
        {
            echo "<script>alert('User Active! Deletion failed!')</script>";
        }
        else
        {
            $delQuery="DELETE FROM `admin_login` WHERE `admin_username`='$delName';";
            $delResult=mysqli_query($con,$delQuery);
            if($delResult)
            {
                echo "<script>alert('Deleted!')</script>";
                echo '<script type="text/javascript">location.reload(true);</script>';
                
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



            <!-- registration section start -->
            <h1><center>SETTINGS</center></h1>
            <h2>Add Admin User Accounts</h2>
            <form action="settings.php" method="post" > 
                <table>
                        <div>
                            <tr>
                                
                                <td>Username</td>
                                <td><input type="text" name="setUsername"></td>
                            </tr>    
                        </div>   

                        <div><tr>
                                
                                <td>Password</td>
                                <td><input type="password" name="setPassword"> </td>
                            </tr>    
                        </div>
                        <div>
                            <tr>
                                
                                <td>Confirm Password</td>
                                <td><input type="password" name="setPassword2"></td>
                            </tr>  
                        </div>  

                        <tr>
                            <td></td>
                            <td><button type="submit" name="create_btn" class="activityButton">Create</button></td>
                        </tr> 
                </table>
            </form>
                
            <h2>List of Existing Users</h2>
            <?php
                global $con;
                if(isset($_POST['create_btn']))
                {
                
                    $setUsername= mysqli_real_escape_string($con,$_POST['setUsername']);
                    $setPassword= mysqli_real_escape_string($con,$_POST['setPassword']);
                    $setPassword2= mysqli_real_escape_string($con,$_POST['setPassword2']);
                    if(empty($setUsername))
                        {echo "<script>alert('Empty Username');</script>";}
                    else if(empty($setPassword))
                        {echo "<script>alert('Empty password error!');</script>";}
                    else if(empty($setPassword2))
                        {echo "<script>alert('Empty password error!');</script>";}
                    else if($setPassword != $setPassword2)
                        {echo "<script>alert('Passwords do not match!');</script>";}
                    else 
                    {   $user_exists_query = "SELECT * FROM                 admin_login WHERE admin_username = '$setUsername' LIMIT 1";

                        $user_check = mysqli_query($con,$user_exists_query);
                        $user=mysqli_fetch_assoc($user_check);
                        if($user)
                        {
                            if($user['admin_username']===$setUsername) 
                            {
                                echo "<script>alert('Username already exists.');</script>";
                            }
                            
                            
                            
                        }
                        else 
                        {
                        // {   $hashPassword=password_hash($setPassword,PASSWORD_DEFAULT);
                            $query="INSERT INTO admin_login VALUES('$setUsername','$setPassword')";
                            mysqli_query($con,$query);
                            echo("<meta http-equiv='refresh' content='1'>");
                            // echo '<script type="text/javascript">location.reload(true);</script>';
                        }
                        
                    }
                }



                $query="SELECT * FROM `admin_login`;";
                $result=mysqli_query($con,$query);
                echo "<table><tr>
                <th>Admin Username</th>
                </tr>  ";
                while($row=mysqli_fetch_array($result))
                {
                    
                    $user_name=$row['admin_username'];
                  
                    echo"
                    <tr>
                    <td>$user_name</td>
                    
                    
                        
                    </tr>";

                }
                echo "</table>";
            ?>
            <h2>Delete User</h2>
            <form method="POST">
                Select User to Delete: <select name="delUser">
                    <?php 
                        $query="SELECT * FROM `admin_login`;";
                        $result=mysqli_query($con,$query);
                        while($row = mysqli_fetch_array($result))
                            {
                                $user_name=$row['admin_username'];
                                echo "<option value=$user_name>$user_name</option>";
                            }
                    ?>

                </select><button type="submit" name="delete-btn" class="activityButton">DELETE</button>
            </form>
</body>
</html>
