<?php
require '../app/start.php';
//require "confirm.php";
$student = $_SESSION['student'];


// Escape user inputs for security
$username = mysqli_real_escape_string($link, $_REQUEST['username']);
$username = str_replace( array("#",";","<",">","=","*"," "), '', $username);
$username = str_replace( array("\""), '\'', $username);

$phone = mysqli_real_escape_string($link, $_REQUEST['phone']);
$phone = str_replace( array("#",";","<",">","=","*"," "), '', $phone);
$phone = str_replace( array("\""), '\'', $phone);

$id = $_SESSION['id'];

if($student){
    $sql = "UPDATE all_student SET phone_number='$phone' WHERE uid='$id'";
    $sql1 = "UPDATE all_student SET username='$username' WHERE uid='$id'";
}elseif(!$student){
    $sql = "UPDATE all_staff SET phone_number='$phone' WHERE uid='$id'";
    $sql1 = "UPDATE all_staff SET username='$username' WHERE uid='$id'";
}else{
    echo "hello";
}

mysqli_query($link, $sql);
if(mysqli_query($link, $sql1)){
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.BASE_URL.'/account.php">';
    exit;
}else{
    echo "Oops! Something went wrong. Please try again later.";
}
// Close connection
mysqli_close($link);
