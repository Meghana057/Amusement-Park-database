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
    $phoneNo=$_GET['phoneNo'];
    if(isset($_POST['next']))
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
            {echo "<script>alert('Empty Age!');</script>";}
        else if(empty($setPhone))
            {echo "<script>alert('Empty Phone Number!');</script>";}
        else if(!(is_numeric($setPhone)) )
            {echo "<script>alert('Invalid Phone Number error!');</script>";}
        else if(!(is_numeric($setAge)) )
            {echo "<script>alert('Invalid Age error!');</script>";}
        else {
        // {       echo "<script>alert('$setGender');</script>";
                $query="INSERT INTO `customer`(`phoneNo`, `customerFirstName`, `customerLastName`, `customerGender`, `customerAge`) VALUES ('$setPhone','$setFN','$setLN','$setGender',$setAge);";
               //echo "<script>alert('INSERT INTO `customer`(`phoneNo`, `customerFirstName`, `customerLastName`, `customerGender`, `customerAge`) VALUES ('$setPhone','$setFN','$setLN','$setGender','$setAge')');</script>";
                //$query2="select * from customer;";
                $res=mysqli_query($con,$query);
                
                
                if($res)
                {
                    header("location: ticket.php?phoneNo=$setPhone");
                }
                else{
                    echo "<script>alert('Error!');</script>";
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
  <h1>Add New Customer</h1>
  <form method="POST">
  <table>
  <tr>
    <td>
        Phone Number:
    </td>
    <td>
        <input type="text" name="setPhone" value=<?php echo $phoneNo;?>>
        </input>
    </td>
  </tr>
  <div>
    <tr>
        
        <td>First Name</td>
        <td><input type="text" name="setFN"></td>
    </tr>    
</div>   

<div><tr>
        
        <td>Last Name</td>
        <td><input type="text" name="setLN"> </td>
    </tr>    
</div>
<div>
    <tr>
        
        <td>Gender</td>
        <td>
            <select name="setGender" >
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            </td>
    </tr>  
</div> 
<div><tr>
        
        <td>Age</td>
        <td><input type="text" name="setAge"> </td>
    </tr>    

</div>
<tr><td></td><td>
<button name="next" class="activityButton">Proceed</button>
</td></tr> 
  </table>
  </form>
  
  </div>
</body>
</html>
