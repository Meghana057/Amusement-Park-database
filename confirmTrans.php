<?php
require("connection.php");
require("credentials.php");

session_start();

if(!isset($_SESSION['admin_username']))
{
    header("location: admin_login.php");
}


global $con;
$phoneNo=$_GET['phoneNo'];
$pid=$_GET['payID'];
$amount=$_GET['amount'];
$paytype=$_GET['paytype'];
$query="INSERT INTO `payment`(`paymentID`, `DateTime`, `phoneNo`, `paymentType`, `total`) VALUES ('$pid',Null,'$phoneNo','$paytype','$amount')";
$result=mysqli_query($con,$query);
if($result){
    $message="Transaction of Rs. $amount.00/- towards THEME PARK is successful";
    

$fields = array(
    "sender_id" => "FSTSMS",
    "message" => "$message",
    "language" => "english",
    "route" => "p",
    "numbers" => "$phoneNo",
);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($fields),
  CURLOPT_HTTPHEADER => array(
    "authorization: UpWbrkE5vfxYoPCems7cnO9FD3zAyRjhgXIawqBZH2t4SKVGNlxiFKseBaM9EpQ10SHTAbld82VzWtUJ",
    "accept: */*",
    "cache-control: no-cache",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

/*
    $field = array(
        "sender_id" => "FSTSMS",
        "language" => "english",
        "route" => "qt",
        "numbers" => "$phoneNo",
        "message" => "$message",
        "variables" => "",
        "variables_values" => ""
    );
    
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($field),
      CURLOPT_HTTPHEADER => array(
        "authorization: UpWbrkE5vfxYoPCems7cnO9FD3zAyRjhgXIawqBZH2t4SKVGNlxiFKseBaM9EpQ10SHTAbld82VzWtUJ",
        "cache-control: no-cache",
        "accept: /*",
        "content-type: application/json"
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }*/

    //echo "<script>alert('Transaction Successful.');</script>";
    header('location: transSuccessful.php');
}
else{
    echo "<script>alert('Transaction failed!.');</script>";
    header("location: ticket.php?phoneNo=$phoneNo");
}
