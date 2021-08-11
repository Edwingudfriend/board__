<?php
require "bd_configure.php";
$post=$_GET['post'];
$sql="DELETE FROM post WHERE idpost='$post'";
if(mysqli_query($link, $sql)){
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL= index.php">';
    exit;
}else{
    echo "Oops! Something went wrong. Please try again later.";
}

?>