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
    $pid = rand(0001,5000);
    $Pay_list = mysqli_query($con,"SELECT * FROM payment");
    while ($row = mysqli_fetch_array($Pay_list))
    {
        if ($pid == $row['paymentID'])
        {
            echo '<script type="text/javascript">location.reload(true);</script>';
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="adminPanelStyle.css">
    <title>Theme Park</title>
</head>
<body>
    <?php include("navbar.php");?>
        <div class="content">
        </div>
        
        <div class="container">



            <!-- Payments section start -->
            <h1><center>Payment DETAILS</center></h1>
            
                
            <h2>Transactions</h2>

            <?php
                 $query="SELECT * FROM `payment` ORDER BY `DateTime` DESC;";
                 $result=mysqli_query($con,$query);
                 echo "<table><tr>
                 <th>Payment ID</th>
                 <th>Date and Time</th>
                 <th>Phone No</th>
                 
                 <th>Payment Type</th>
                 
                 <th>Total</th>
                 
                 </tr>  ";
                 while($row=mysqli_fetch_array($result))
                 {
                     
                     $PaymentID=$row['paymentID'];
                     $DateTime=$row['DateTime'];
                     $phoneNo=$row['phoneNo'];
                     
                     $PaymentType=$row['paymentType'];
                     
                     $Total=$row['total'];
                    
                     echo"
                     <tr>
                     <td>$PaymentID</td>
                     <td>$DateTime</td>
                     <td>$phoneNo</td>
                     
                     <td>$PaymentType</td>
                     <td>$Total</td>
                     
                     
                     
                     
                         
                     </tr>";
 
                 }
                 echo "</table>";
            ?>
            
           


    

</body>
</html>
