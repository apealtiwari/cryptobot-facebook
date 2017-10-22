<?php

function shortCodeToLongForm($receivedText){

$dbname="ynoymlpx_cryptobot";
$host="localhost";
$user="ynoymlpx_cryptobot";
$pass="apealisgood123";
$conn= mysqli_connect($host,$user,$pass,$dbname);

$query="SELECT name FROM cryptolist WHERE symbol='$receivedText'";
$row=mysqli_query($conn,$query);

while ($result = mysqli_fetch_assoc($row)) {
$receivedText= $result['name'];
}
return $receivedText;
}

?>