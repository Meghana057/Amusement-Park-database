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
    {   $query="SELECT * FROM `package`;";
        $result=mysqli_query($con,$query);
        if(mysqli_num_rows($result)==1)
        {
            echo "<script>alert('Table should contain atleast 1 entry!');</script>";
            echo '<script type="text/javascript">location.reload(true);</script>';
        }
        else{
            $delPackID=$_POST['delPackID'];
            $delQuery="DELETE FROM `package` WHERE `packageID`='$delPackID';";
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
              PACKAGES
          </center>
      </h1>
      <H2>Packages Available</H2>
      <?php
      $query="select * from `package`;";
      $result=mysqli_query($con,$query);
      echo "<table><tr><th>Package ID </th>
      <th>Package Name</th>
      <th>Amount </th></tr>";
      while($row=mysqli_fetch_array($result))
      {
          $packageID= $row['packageID'];
          $packageName=$row['packageName'];
          $packageAmount=$row['packageAmount'];
          echo "<tr><td>$packageID</td><td>$packageName</td><td>$packageAmount</td></tr>";
      }

      echo "</table>";
      ?>
      <h2>Add New Packages</h2>
      <form  method="post">
          <table>
              <tr>
                  <td>
                      Package ID:
                  </td>
                  <td>
                      <input type="text" name="setPackageID">
                  </td>
              </tr>
              <tr>
                  <td>
                      Package Name:
                  </td>
                  <td>
                      <input type="text" name="setPackageName">
                  </td>
              </tr>
              <tr>
                  <td>
                      Package Amount:
                  </td>
                  <td>
                      <input type="text" name="setPackageAmount">
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
                
                    $setPackageName= mysqli_real_escape_string($con,$_POST['setPackageName']);
                    $setPackageID= mysqli_real_escape_string($con,$_POST['setPackageID']);
                    $setPackageAmount= mysqli_real_escape_string($con,$_POST['setPackageAmount']);
                    if(empty($setPackageName))
                        {echo "<script>alert('Empty Package Name');</script>";}
                    else if(empty($setPackageID))
                        {echo "<script>alert('Empty Package ID!');</script>";}
                    else if(empty($setPackageAmount))
                        {echo "<script>alert('Empty Amount error!');</     script>";}
                    else if(!(is_numeric($setPackageAmount)) )
                        {echo "<script>alert('Invalid Amount error!');</script>";}
                    
                    else 
                    {   $Package_exists_query = "SELECT * FROM                 package WHERE packageName = '$setPackageName' OR packageID = '$setPackageID'";

                        $Package_check = mysqli_query($con,$Package_exists_query);
                        $Pack=mysqli_fetch_assoc($Package_check);
                        if($Pack)
                        {    
                            if($Pack['packageName']===$setPackageName || $Pack['packageID']===$setPackageID) 
                            {
                                echo "<script>alert('Package already exists.');</script>";
                            }
                            
                            
                            
                        }
                        else 
                        {
                        
                            $query="INSERT INTO package VALUES('$setPackageID','$setPackageName',$setPackageAmount)";
                            $result=mysqli_query($con,$query);
                            if($result==1){
                                echo "<script>alert('Package Created.');</script>";
                                echo("<meta http-equiv='refresh' content='1'>");
                                //  echo '<script type="text/javascript">location.reload(true);</script>';
                            }
                            // echo '<script type="text/javascript">location.reload(true);</script>';
                        }
                        
                    }
                }
                
            ?>
            <h2>Delete Package</h2>
            <form  method="POST">
                Select Package to Delete: <select name="delPackID">
                    <?php 
                        $query="SELECT * FROM `package`;";
                        $result=mysqli_query($con,$query);
                        
                       
                        
                        
                        while($row = mysqli_fetch_array($result))
                            {
                            $packageName=$row['packageName'];
                            $packageID=$row['packageID'];
                            echo "<option value=$packageID> $packageID - <b>$packageName</b> </option>";
                            }
                        
                    ?>

                </select><button type="submit" name="delete-btn" class="activityButton">DELETE</button>
            </form>
  </div>

</body>
</html>
