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
    
    global $con;
    $phoneNo=$_GET['phoneNo'];
    $query="SELECT * FROM `customer` where phoneNo='$phoneNo';";
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
  <h1>Invoice</h1>
  <form method="POST">
  <table>
  <tr>
    <td>
        Payment ID:
    </td>
    <td>
        <?php echo $pid;?>
        
    </td>
  </tr>
  <tr>
    <td>
        Phone Number:
    </td>
    <td>
        <?php echo $phoneNo;?>
        
    </td>
  </tr>
  <div>
    <tr>
        
        <td>First Name</td>
        <td><?php echo $firstName;?></td>
    </tr>    
</div>   

<div><tr>
        
        <td>Last Name</td>
        <td><?php echo $lastName;?> </td>
    </tr>    
</div>
<div>
    <tr>
        
        <td>Gender</td>
        <td>
        <?php echo $gender;?>
            </td>
    </tr>  
</div> 
<div><tr>
        
        <td>Age</td>
        <td><?php echo $age;?> </td>
    </tr>    

</div>
<div>
    <!-- <tr>
        
        <td>Payment Method:</td>
        <td>
        <select name="PayType">
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="cheque">Cheque</option>
            </td>
    </tr> -->  
</div>
</table>
Select Package:
<form method="POST">
<table>

<?php 
$query="select * from `package`;";
$result=mysqli_query($con,$query);

while($row=mysqli_fetch_array($result))
{
    $packageID= $row['packageID'];
    $packageName=$row['packageName'];
    $packageAmount=$row['packageAmount'];
    echo "<tr><td>$packageName-$packageAmount</td>
    <td>";
    if(!isset($_POST['next'])){echo "
    <select  name='no-$packageID'>
    <option value='0'>0</option>
    <option value='1'>1</option>
    <option value='2'>2</option>
    <option value='3'>3</option>
    <option value='4'>4</option>
    <option value='5'>5</option>
    <option value='6'>6</option>
    <option value='7'>7</option>
    <option value='8'>8</option>
    </select>";
    }
    else{
        $checkString="no-$packageID";
        $noPack= mysqli_real_escape_string($con,$_POST[$checkString])*1.0;
        echo "$noPack";
    }

    echo "</td>
    </tr>";
}

echo "</table>";


  if(isset($_POST['next']))
    {   $query="select * from `package`;";
        $result=mysqli_query($con,$query);
        $calcAmnt=0.0;
        
        while($row=mysqli_fetch_array($result))
        {
            $packageID= $row['packageID'];
            $packageName=$row['packageName'];
            $packageAmount=$row['packageAmount'];
            $checkString="no-$packageID";
            $noPack= mysqli_real_escape_string($con,$_POST[$checkString])*1.0;
            $calcAmnt=$calcAmnt+($noPack*$packageAmount);
            $calcAmnt=floatval($calcAmnt);
            

        }
        $paytype=mysqli_real_escape_string($con,$_POST['PayType']);
        echo "<table><tr> <td>Payment Method:</td>
        <td>$paytype</td></tr>
        <tr><td>Amount:</td><td>$calcAmnt.00/- Rupees Only</td></tr>
        
        </table>";
        echo "
        <table>
<tr><td><a href=\"ticket.php?phoneNo=$phoneNo\"><button class=\"activityButton\">Back</button></a></td><td>
<a href=\"confirmTrans.php?payID=$pid&phoneNo=$phoneNo&amount=$calcAmnt&paytype=$paytype\"><button type=\"button\" name=\"Pay\" class=\"activityButton\">Pay</button></a>
</td></tr> 
  </table>";
