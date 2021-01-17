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
    $customerID=$_GET['memberID'];
    $query="SELECT * FROM `customer` where phoneNo='$customerID';";
                $result=mysqli_query($con,$query);
                
                while($row=mysqli_fetch_array($result))
                {
                    $firstName=$row['customerFirstName'];
                    $lastName=$row['customerLastName'];
                    $gender=$row['customerGender'];
                    $age=$row['customerAge'];
                   
                }
    
                
?>

<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
        <link rel="stylesheet" href="adminPanelStyle.css">
        <title>Edit Customer</title>
    </head>
    <body ><?php include("navbar.php");?>
        <div class="content">
        </div>
        <div class="container">



            
            <h1><center>Edit Customer Details</center></h1>
            
            <form method="post" > 
                <table>
                <div><tr>
                                
                                <td>Phone Number</td>
                                <!-- <td><input type="text" name="setMemberID"> </td> -->
                                <td><input type="text" name="setPhone" value=<?php echo "$customerID";?>></td>
                            </tr>    
                        </div>
                        <div>
                            <tr>
                                
                                <td>First Name</td>
                                <td><input type="text" name="setFN" value=<?php echo "$firstName"?>></td>
                            </tr>    
                        </div>   

                        <div><tr>
                                
                                <td>Last Name</td>
                                <td><input type="text" name="setLN" value=<?php echo "$lastName"?>> </td>
                            </tr>    
                        </div>
                        <div>
                            <tr>
                                
                                <td>Gender</td>
                                <td>
                                <?php
                                if($gender=="male" || $gender=="Male")
                                { echo "
                                  <select name=\"setGender\" >
                                        <option value=\"male\" selected>Male</option>
                                        <option value=\"female\">Female</option>
                                        <option value=\"other\">Other</option>
                                    </select>";
                                }
                                else if($gender=="female" || $gender=="Female")
                                { echo "
                                  <select name=\"setGender\" >
                                        <option value=\"male\" >Male</option>
                                        <option value=\"female\" selected>Female</option>
                                        <option value=\"other\">Other</option>
                                    </select>";
                                }
                                else
                                {
                                  echo "
                                  <select name=\"setGender\" >
                                        <option value=\"male\" >Male</option>
                                        <option value=\"female\" >Female</option>
                                        <option value=\"other\" selected>Other</option>
                                    </select>";

                                }
                                
                                ?>  
                                
                                
                                
                                </td>
                                    
                            </tr>  
                        </div> 
                        <div><tr>
                                
                                <td>Age</td>
                                <td><input type="text" name="setAge" value=<?php echo "$age"?>> </td>
                            </tr>    
                        </div> 
                        
                        
                        

               

                        <tr>
                            <td></td>
                            <td><button type="submit" name="create_btn" class="activityButton">Update</button></td>
                        </tr> 
                </table>
            </form>
                
            
            <?php
                global $con;
                if(isset($_POST['create_btn']))
                {
                
                    $setFN= mysqli_real_escape_string($con,$_POST['setFN']);
                    $setLN= mysqli_real_escape_string($con,$_POST['setLN']);
                    $setGender= mysqli_real_escape_string($con,$_POST['setGender']);
                    $setAge= mysqli_real_escape_string($con,$_POST['setAge']);
                    $setPhone= mysqli_real_escape_string($con,$_POST['setPhone']);
                    
                    if(empty($setFN))
                        {echo "<script>alert('Empty First Name');</script>";}
                    else if(empty($setLN))
                        {echo "<script>alert('Empty Last Name!');</script>";}
                    else if(empty($setGender))
                        {echo "<script>alert('Empty Gender!');</script>";}
                    else if(empty($setAge))
                        {echo "<script>alert('Empty e-mail!');</script>";}
                    else if(empty($setPhone))
                        {echo "<script>alert('Empty Phone Number!');</script>";}
                    else if(!(is_numeric($setPhone)) )
                        {echo "<script>alert('Invalid Phone Number error!');</script>";}
                    else 
                    {   
                            $query3="UPDATE `customer` SET 
                            `phoneNo`='$setPhone',
                             `customerFirstName`='$setFN',
                              `customerLastName`='$setLN',
                               `customerGender`='$setGender',
                                `customerAge`=$setAge
                                WHERE `customer`.`phoneNo`='$customerID';";
                            $res3=mysqli_query($con,$query3);
                            //echo "<script>alert('$res3');</script>";
                            
                            if($res3)
                            {
                                echo "<script>alert('Customer Details Updated!');</script>";

                            }
                            else{
                              echo "<script>alert('error');</script>";
                            }
                            echo "<script>window.location.href = \"customerDetails.php\";</script>";
                            
                            
                        
                        
                    }
                }

                if(isset($_POST['delete-btn']))
                {   $query="SELECT * FROM `customer`;";
                    $result=mysqli_query($con,$query);
                    if(mysqli_num_rows($result)==1)
                    {
                        echo "<script>alert('Table should contain atleast 1 entry!');</script>";
                        echo '<script type="text/javascript">location.reload(true);</script>';
                    }
                    else{
                        $delMemID=$customerID;
                         
                        $delQuery="DELETE FROM `customer` WHERE `phoneNo`='$delMemID';";
                            $delResult=mysqli_query($con,$delQuery);
                            if($delResult)
                            {
                                echo "<script>alert('Deleted!')</script>";
                                echo "<script>window.location.href = \"customerDetails.php\";</script>";
                                
                            }
                    }
            
                }



            ?>
            <!--  -->
            
            <!-- <form method="POST">

            <table ><tr><td class=disnone>................</td><td >
            <button type="submit" name="delete-btn" class="activityButton">DELETE Customer</button></td>
            </table>
          </form> -->
            


            <!-- registration section end -->
        </div>

            
            
    </body>
</html>
