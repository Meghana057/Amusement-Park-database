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
    {   $query="SELECT * FROM `guide`;";
        $result=mysqli_query($con,$query);
        if(mysqli_num_rows($result)==1)
        {
            echo "<script>alert('Table should contain atleast 1 entry!');</script>";
            echo '<script type="text/javascript">location.reload(true);</script>';
        }
        else{
            $delGuideID=$_POST['delGuideID'];
            $delQuery="DELETE FROM `guide` WHERE `guideID`='$delGuideID';";
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
             Guides
          </center>
      </h1>
      
      <?php
      $query="select * from `guide`;";
      $result=mysqli_query($con,$query);
      echo "<table><tr><th>Guide ID </th>
      <th>Guide Name</th>
      <th>Guide PhoneNumber </th>
      <th>Ride Name</th></tr>";
      while($row=mysqli_fetch_array($result))
      {
          $guideID= $row['guideID'];
          $guideName=$row['guideName'];
          $guidePhoneNo=$row['guidePhoneNo'];
          $rideID=$row['rideID'];
          $query2="Select `rideName` from `ride` where `rideID`='$rideID';";
          $res2=mysqli_query($con,$query2);
          $rideName=mysqli_fetch_array($res2,MYSQLI_ASSOC);
          $rideName2=$rideName["rideName"];
         
          echo "<tr><td>$guideID</td><td>$guideName</td><td>$guidePhoneNo</td><td>$rideName2</td></tr>";
      }

      echo "</table>";
      ?>
      <h2>Add New Guide</h2>
      <form  method="post">
          <table>
              <tr>
                  <td>
                      Guide ID:
                  </td>
                  <td>
                      <input type="text" name="setGuideID">
                  </td>
              </tr>
              <tr>
                  <td>
                      Guide Name:
                  </td>
                  <td>
                      <input type="text" name="setGuideName">
                  </td>
              </tr>
              <tr>
                  <td>
                      Guide Number:
                  </td>
                  <td>
                      <input type="text" name="setGuidePhoneNo">
                  </td>
              </tr>
              <tr>
                  <td>
                      select ride:
                  </td>
                  <td>
                  <select name="rideQuery">
                    <?php 
                        $query="SELECT * FROM `ride`;";
                        $result=mysqli_query($con,$query);
                        while($row = mysqli_fetch_array($result))
                            {
                                $rideName=$row['rideName'];
                                $rideID=$row['rideID'];
                                echo "<option value=$rideID>$rideName</option>";
                            }
                    ?>

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
                
                    $setGuideName= mysqli_real_escape_string($con,$_POST['setGuideName']);
                    $setGuideID= mysqli_real_escape_string($con,$_POST['setGuideID']);
                    $setGuidePhoneNo= mysqli_real_escape_string($con,$_POST['setGuidePhoneNo']);
                    $setRideID=mysqli_real_escape_string($con,$_POST['rideQuery']);
                    if(empty($setGuideName))
                        {echo "<script>alert('Empty Guide Name');</script>";}
                    else if(empty($setGuideID))
                        {echo "<script>alert('Empty Guide ID!');</script>";}
                    else if(empty($setGuidePhoneNo))
                        {echo "<script>alert('Empty Guide Phone Number error!');</     script>";}
                    else if(!(is_numeric($setGuidePhoneNo)) )
                        {echo "<script>alert('Invalid Phone NUmber!');</script>";}
                    
                    else 
                    {   $Package_exists_query = "SELECT * FROM          guide WHERE guideName = '$setGuideName' OR guideID = '$setGuideID'";

                        $Package_check = mysqli_query($con,$Package_exists_query);
                        $Pack=mysqli_fetch_assoc($Package_check);
                        if($Pack)
                        {    
                            if($Pack['guideName']===$setGuideName || $Pack['guideID']===$setGuideID) 
                            {
                                echo "<script>alert('Guide already exists.');</script>";
                            }
                            
                            
                            
                        }
                        else 
                        {
                        
                            $query2="INSERT INTO `guide`(`guideID`, `guideName`, `guidePhoneNo`, `rideID`) VALUES ('$setGuideID','$setGuideName','$setGuidePhoneNo','$setRideID')";
                            $result2=mysqli_query($con,$query2);
                            
                            if($result2==1){
                                echo "<script>alert('Guide Created.');</script>";
                                echo("<meta http-equiv='refresh' content='1'>");
                                //  echo '<script type="text/javascript">location.reload(true);</script>';
                            }
                            // echo '<script type="text/javascript">location.reload(true);</script>';
                        }
                        
                    }
                }
                
            ?>
            <h2>Delete Guide</h2>
            <form  method="POST">
                Select Guide to Delete: <select name="delGuideID">
                    <?php 
                        $query="SELECT * FROM `guide`;";
                        $result= mysqli_query($con,$query);
                        
                       
                        
                        
                        while($row = mysqli_fetch_array($result))
                            {
                            $guideName=$row['guideName'];
                            $guideID=$row['guideID'];
                            echo "<option value=$guideID> $guideID - <b>$guideName</b> </option>";
                            }
                        
                    ?>

                </select><button type="submit" name="delete-btn" class="activityButton">DELETE</button>
            </form>
  </div>

</body>
</html>
