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
    
    
?>

<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
        <link rel="stylesheet" href="adminPanelStyle.css">
        <title>Theme Park</title>
    </head>
    <body ><?php include("navbar.php");?>
        <div class="content">
        </div>
        
        <div class="container">



            
            <h1><center>Customer List</center></h1>
            
                
            
            <table>
                <tr>
                    <th>Phone NO</th>    
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    
                    
                    <th><i class="fas fa-edit"></i></th>
                    
                </tr>
            <?php
                



                $query="SELECT * FROM `customer`;";
                $result=mysqli_query($con,$query);
                
                while($row=mysqli_fetch_array($result))
                {
                    $firstName=$row['customerFirstName'];
                    $lastName=$row['customerLastName'];
                    $gender=$row['customerGender'];
                    
                    $Phone=$row['phoneNo'];
                    $age=$row['customerAge'];
                    
                    echo"
                    <tr>
                    <td>$Phone</td>
                    <td>$firstName</td>
                    <td>$lastName</td>
                    <td>$gender</td>
                    <td>$age</td>
                    
                    
                    <td><a href=customerEdit.php?memberID=$Phone><button type=\"submit\" name=\"editUser\"><i class=\"fas fa-user-edit\"></button></i></a></td>
                    
                    
                    
                    
                        
                    </tr>";

                }
                echo "</table>";
            ?>
            
        </div>

            
            
    </body>
</html>
