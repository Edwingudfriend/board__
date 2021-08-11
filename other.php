<?php
include "bd_configure.php";

// $name="good";
// $array= array("1", "2", "3");
// $array  = implode(',', $array);
// $sql ="INSERT INTO receiver_group (group_name,group_comment) VALUES ('$name','$array')";
// if($result = mysqli_query($link, $sql)){
//     echo "deone it";
// }else{
//     echo "fail";
// }

$sql = "SELECT * FROM announcement INNER JOIN receiver_group ON receiver_group.group_id=announcement.group_receiver_id";
$sql = "SELECT * FROM receiver_group WHERE group_id=1";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $helos = $row['group_comment'];
            $helos = explode(" ", $helos);
            
            foreach ($helos as $key=>$item){
                echo "$item <br>";
            }
            
        }
    }
    else{
        echo "no found";
    }
}else{
    echo "fail to run";
}
