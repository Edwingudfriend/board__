<?php
//Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL= login.php">';
    exit;
}
?>