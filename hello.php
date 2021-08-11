<?php
include "bd_configure.php";
$sql = "CALL makePost('to ict student', 'hello guys. make sure you study hard', 1,'ict students')";

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo $row['last_insert_id()'];
        }
    } else {
        echo 'fail fail';
    }
} else {
    echo 'fail';
}
?>