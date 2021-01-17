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
    {   $query="SELECT * FROM `ride`;";
        $result=mysqli_query($con,$query);
        if(mysqli_num_rows($result)==1)
        {
            echo "<script>alert('Table should contain atleast 1 entry!');</script>";
            echo '<script type="text/javascript">location.reload(true);</script>';
        }
        else{
            $delrideID=$_POST['delRideID'];
            $delQuery="DELETE FROM `ride` WHERE `rideID`='$delrideID';";
                $delResult=mysqli_query($con,$delQuery);
                if($delResult)
                {
                    echo "<script>alert('Deleted!')</script>";
                    echo("<meta http-equiv='refresh' content='1'>");
                    // echo '<script type="text/javascript">location.reload(true);</script>';
                    
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
      <h1>
          <center>
             RIDES
          </center>
      </h1>
      
      <?php
      $query="call `callRide`();";
      $result=mysqli_query($con,$query);
      echo "<table><tr><th>Ride ID </th>
      <th>Ride Name</th>
      <th>Ride Type</th>
      <th>Ride Status</th></tr>";
      while($row=mysqli_fetch_array($result))
      {
          $rideID= $row['rideID'];
          $rideName=$row['rideName'];
          $rideType=$row['rideType'];
          $rideCondition=$row['rideCondition'];
          echo "<tr><td>$rideID</td><td>$rideName</td><td>$rideType</td><td>$rideCondition</td></tr>";
      }

      echo "</table>";
      ?>
      <h2>Add New Rides</h2>
      <form  method="post">
          <table>
              <tr>
                  <td>
                      Ride ID:
                  </td>
                  <td>
                      <input type="text" name="setRideID">
                  </td>
              </tr>
              <tr>
                  <td>
                      Ride Name:
                  </td>
                  <td>
                      <input type="text" name="setRideName">
                  </td>
              </tr>
              <tr>
                  <td>
                      Ride Type:
                  </td>
                  <td>
                  <select name="setRideType">
                          <option value="Dry">Dry</option>
                          <option value="Water">Water</option>
                          
    </select>
                  </td>
    </tr>
    <tr>
        <td> Ride Status</td>
                  <td>
                      <select name="setRideCondition">
                          <option value="Active">Active</option>
                          <option value="Maintenance">Maintenance</option>
                          <option value="Breakdown">Breakdown</option>
                          <option value="Closed">Closed</option>
    </select>
                          

                  </td>
              </tr>
              <tr>
                  <td>

                  </td>
                  <td>
                      <button type="submit" name="create_btn" class="activityButton">
                          Create
                        </button>
                  </td>
              </tr>
          </table>
      </form>
    <?php
    global $con;
    if(isset($_POST['create_btn']))
                {
                
                    $setRideName= mysqli_real_escape_string($con,$_POST['setRideName']);
                    $setRideID= mysqli_real_escape_string($con,$_POST['setRideID']);
                    $setRideType= mysqli_real_escape_string($con,$_POST['setRideType']);
                    $setRideCondition= mysqli_real_escape_string($con,$_POST['setRideCondition']);
                    
                    if(empty($setRideName))
                        {echo "<script>alert('Empty Package Name');</script>";}
                    else if(empty($setRideID))
                        {echo "<script>alert('Empty Package ID!');</script>";}
                    
                    
                    else 
                    {   $Package_exists_query = "SELECT * FROM                 ride WHERE rideName = '$setRideName' OR rideID = '$setRideID'";

                        $Package_check = mysqli_query($con,$Package_exists_query);
                        $Pack=mysqli_fetch_assoc($Package_check);
                        if($Pack)
                        {    
                            if($Pack['rideName']===$setRideName || $Pack['rideID']===$setRideID) 
                            {
                                echo "<script>alert('Ride already exists.');</script>";
                            }
                            
                            
                            
                        }
                        else 
                        {
                        
                            $query="INSERT INTO `ride`(`rideID`, `rideName`, `rideType`, `rideCondition`) VALUES ('$setRideID','$setRideName','$setRideType','$setRideCondition')";
                            $result=mysqli_query($con,$query);
                            if($result==1){
                                echo "<script>alert('Ride Created.');</script>";
                                echo("<meta http-equiv='refresh' content='1'>");
                                //  echo '<script type="text/javascript">location.reload(true);</script>';
                            }
                            // echo '<script type="text/javascript">location.reload(true);</script>';
                        }
                        
                    }
                }
                
            ?>
            <h2>Delete Ride</h2>
            <form  method="POST">
                Select ride to Delete: <select name="delRideID">
                    <?php 
                        $query="SELECT * FROM `ride`;";
                        $result=mysqli_query($con,$query);
                        
                       
                        
                        
                        while($row = mysqli_fetch_array($result))
                            {
                            $packageName=$row['rideName'];
                            $packageID=$row['rideID'];
                            echo "<option value=$packageID> $packageID - <b>$packageName</b> </option>";
                            }
                        
                    ?>

                </select><button type="submit" name="delete-btn" class="activityButton">DELETE</button>
            </form>
  </div>

</body>
</html>
