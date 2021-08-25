<?php
session_start();
include "bd_configure.php";
include "confirm.php";
$numbers = array();
array_push($numbers, "0");

$uid = $_SESSION['id'];
$sql = "call getStaffInfo($uid)";
if ($result1 = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result1) > 0) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $name = $row1['fullname'];
            $staffid = $row1['staffid'];
        }
        // Close result set
        mysqli_free_result($result1);
    }
}

$all_receiver = false;
$all_student = false;
$all_offical = false;
$cs_dep = false;
$All_cs = false;
$All_compEng = false;
$All_ict = false;
$_other = false;
$level = false;
$coarse = false;
$department = false;
$college = false;
$nta4 = false;
$nta5 = false;
$nta6 = false;
$leve='normal';


function sendText($number, $text){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://messaging-service.co.tz/api/sms/v1/text/single',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{"from":"NEXTSMS", "to":"' . $number . '",  "text": "' . $text . '"}',
        CURLOPT_HTTPHEADER => array(
            'Authorization: API ID',
            'Content-Type: application/json',
            'Accept: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    //echo $response;

}


if (isset($_POST['submit_btn'])) {
    $link = mysqli_connect('localhost', 'root', '', 'board');
    $header = mysqli_real_escape_string($link, $_REQUEST['header']);
    $body = mysqli_real_escape_string($link, $_REQUEST['body']);
    $leve='argent';

    if (!empty($_POST['normal'])) {
        $normal = true;
        $leve='normal';
    }

    if (!empty($_POST['argent'])) {
        $argent = true;
        $leve='argent';
    }

    if (!empty($_POST['_other'])) {
        if ($coarse) {
        }
        if ($department) {
        }
        if ($college) {
        }
    }

    if (!empty($_POST['nta4'])) {
        $link = mysqli_connect('localhost', 'root', '', 'board');
        //Todo:check fill available and level
        $sql1 = "call board.makePost('$header', '$body', $staffid, 'All NTA4','null','$leve')";
        $nta4 = true;
    }

    if (!empty($_POST['nta5'])) {
        $link = mysqli_connect('localhost', 'root', '', 'board');
        //Todo:check fill available and level
        $sql1 = "call board.makePost('$header', '$body', $staffid, 'All NTA5','null','$leve')";
        $nta5 = true;
    }

    if (!empty($_POST['nta6'])) {
        $link = mysqli_connect('localhost', 'root', '', 'board');
        //Todo:check fill available and level
        $sql1 = "call board.makePost('$header', '$body', $staffid, 'All NTA6','null','$leve')";
        $nta6 = true;
    }

    if (!empty($_POST['All_ict'])) {
        $link = mysqli_connect('localhost', 'root', '', 'board');
        //Todo:check fill available and level
        $sql1 = "call board.makePost('$header', '$body', $staffid, 'all ict','null','$leve')";
        $All_ict = true;
    }

    if (!empty($_POST['All_compEng'])) {
        $link = mysqli_connect('localhost', 'root', '', 'board');
        $sql1 = "call board.makePost('$header', '$body', $staffid, 'all comp eng','null','$leve')";
        $All_compEng = true;
    }

    if (!empty($_POST['All_cs'])) {
        $link = mysqli_connect('localhost', 'root', '', 'board');
        $sql1 = "call board.makePost('$header', '$body', $staffid, 'all Cs','null','$leve')";
        $All_cs = true;
    }

    if (!empty($_POST['cs_dep'])) {
        $link = mysqli_connect('localhost', 'root', '', 'board');
        $sql1 = "call board.makePost('$header', '$body', $staffid, 'Cs and Comp eng dep','null','$leve')";
        $cs_dep = true;
    }

    if (!empty($_POST['all_offical'])) {
        $link = mysqli_connect('localhost', 'root', '', 'board');
        $sql1 = "call board.makePost('$header', '$body', $staffid, 'all staff','null','$leve')";
        $all_offical = true;
    }

    if (!empty($_POST['all_student'])) {
        $link = mysqli_connect('localhost', 'root', '', 'board');
        $sql1 = "call board.makePost('$header', '$body', $staffid, 'all student','null','$leve')";
        $all_student = true;
    }

    if (!empty($_POST['all_receiver'])) {
        $link = mysqli_connect('localhost', 'root', '', 'board');
        $sql1 = "call board.makePost('$header', '$body', $staffid, 'all','null','$leve')";
        $all_receiver = true;
    }

    if ($result10 = mysqli_query($link, $sql1)) {
        if (mysqli_num_rows($result10) > 0) {
            while ($row10 = mysqli_fetch_array($result10)) {
                $postid = $row10['last_insert_id()'];
            }

            if ($all_receiver) {
                $link = mysqli_connect('localhost', 'root', '', 'board');
                $sqlpost1 = "call board.postIds(1, $postid, 'college')";
                $sqlpost2 = "call board.postIds(3, $postid, 'department')";
                mysqli_query($link, $sqlpost1);
                $link = mysqli_connect('localhost', 'root', '', 'board');
                mysqli_query($link, $sqlpost2);

                $sql_num_staff = "call board.getStaffContact(3)";
                $sql_num_student = "call board.getStudentContact(0, 0, 0, 1)";

                $link = mysqli_connect('localhost', 'root', '', 'board');
                if ($staffContact = mysqli_query($link, $sql_num_staff)) {
                    if (mysqli_num_rows($staffContact) > 0) {
                        while ($staff = mysqli_fetch_array($staffContact)) {
                            $thisNum = $staff['phone_number'];
                            if (!array_search($thisNum, $numbers)) {
                                array_push($numbers, $thisNum);
                            }
                        }
                    }
                } else {
                }

                $link = mysqli_connect('localhost', 'root', '', 'board');
                if ($studentContact = mysqli_query($link, $sql_num_student)) {
                    if (mysqli_num_rows($studentContact) > 0) {
                        while ($student = mysqli_fetch_array($studentContact)) {
                            $thisNum = $student['phone_number'];
                            if (!array_search($thisNum, $numbers)) {
                                array_push($numbers, $thisNum);
                            }
                        }
                    }
                } else {
                }
            }

            if ($all_student) {
                $link = mysqli_connect('localhost', 'root', '', 'board');
                $sqlpost1 = "call board.postIds(1, $postid, 'college')";
                mysqli_query($link, $sqlpost1);

                $sql_num_student = "call board.getStudentContact(0, 0, 0, 1)";

                $link = mysqli_connect('localhost', 'root', '', 'board');
                if ($studentContact = mysqli_query($link, $sql_num_student)) {
                    if (mysqli_num_rows($studentContact) > 0) {
                        while ($student = mysqli_fetch_array($studentContact)) {
                            $thisNum = $student['phone_number'];
                            if (!array_search($thisNum, $numbers)) {
                                array_push($numbers, $thisNum);
                            }
                        }
                    }
                } else {
                }
            }

            if ($all_offical) {
                $link = mysqli_connect('localhost', 'root', '', 'board');
                $sqlpost2 = "call board.postIds(3, $postid, 'department')";
                mysqli_query($link, $sqlpost2);

                $sql_num_staff = "call board.getStaffContact(3)";

                $link = mysqli_connect('localhost', 'root', '', 'board');
                if ($staffContact = mysqli_query($link, $sql_num_staff)) {
                    if (mysqli_num_rows($staffContact) > 0) {
                        while ($staff = mysqli_fetch_array($staffContact)) {
                            $thisNum = $staff['phone_number'];
                            if (!array_search($thisNum, $numbers)) {
                                array_push($numbers, $thisNum);
                            }
                        }
                    }
                } else {
                }
            }

            if ($cs_dep) {
                $link = mysqli_connect('localhost', 'root', '', 'board');
                $sqlpost1 = "call board.postIds(1, $postid, 'department')";
                mysqli_query($link, $sqlpost1);

                $sql_num_student = "call board.getStudentContact(0, 0, 1, 0)";

                $link = mysqli_connect('localhost', 'root', '', 'board');
                if ($studentContact = mysqli_query($link, $sql_num_student)) {
                    if (mysqli_num_rows($studentContact) > 0) {
                        while ($student = mysqli_fetch_array($studentContact)) {
                            $thisNum = $student['phone_number'];

                            if (!array_search($thisNum, $numbers)) {
                                array_push($numbers, $thisNum);
                            }
                        }
                    }
                } else {
                }
            }

            if ($All_cs) {
                $link = mysqli_connect('localhost', 'root', '', 'board');
                $sqlpost1 = "call board.postIds(1, $postid, 'coarse')";
                mysqli_query($link, $sqlpost1);

                $sql_num_student = "call board.getStudentContact(0, 1, 0, 0)";

                $link = mysqli_connect('localhost', 'root', '', 'board');
                if ($studentContact = mysqli_query($link, $sql_num_student)) {
                    if (mysqli_num_rows($studentContact) > 0) {
                        while ($student = mysqli_fetch_array($studentContact)) {
                            $thisNum = $student['phone_number'];

                            if (!array_search($thisNum, $numbers)) {
                                array_push($numbers, $thisNum);
                            }
                        }
                    }
                } else {
                }
            }

            if ($All_compEng) {
                $link = mysqli_connect('localhost', 'root', '', 'board');
                $sqlpost1 = "call board.postIds(2, $postid, 'coarse')";
                mysqli_query($link, $sqlpost1);

                $sql_num_student = "call board.getStudentContact(0, 2, 0, 0)";

                $link = mysqli_connect('localhost', 'root', '', 'board');
                if ($studentContact = mysqli_query($link, $sql_num_student)) {
                    if (mysqli_num_rows($studentContact) > 0) {
                        while ($student = mysqli_fetch_array($studentContact)) {
                            $thisNum = $student['phone_number'];

                            if (!array_search($thisNum, $numbers)) {
                                array_push($numbers, $thisNum);
                            }
                        }
                    }
                } else {
                }
            }

            if ($All_ict) {
                $link = mysqli_connect('localhost', 'root', '', 'board');
                $sqlpost1 = "call board.postIds(3, $postid, 'coarse')";
                mysqli_query($link, $sqlpost1);

                $sql_num_student = "call board.getStudentContact(0, 3, 0, 0)";

                $link = mysqli_connect('localhost', 'root', '', 'board');
                if ($studentContact = mysqli_query($link, $sql_num_student)) {
                    if (mysqli_num_rows($studentContact) > 0) {
                        while ($student = mysqli_fetch_array($studentContact)) {
                            $thisNum = $student['phone_number'];

                            if (!array_search($thisNum, $numbers)) {
                                array_push($numbers, $thisNum);
                            }
                        }
                    }
                } else {
                }
            }

            if ($nta4) {
                $link = mysqli_connect('localhost', 'root', '', 'board');
                $sqlpost1 = "call board.postIds(1, $postid, 'level')";
                mysqli_query($link, $sqlpost1);

                $sql_num_student = "call board.getStudentContact(1, 0, 0, 0)";

                $link = mysqli_connect('localhost', 'root', '', 'board');
                if ($studentContact = mysqli_query($link, $sql_num_student)) {
                    if (mysqli_num_rows($studentContact) > 0) {
                        while ($student = mysqli_fetch_array($studentContact)) {
                            $thisNum = $student['phone_number'];

                            if (!array_search($thisNum, $numbers)) {
                                array_push($numbers, $thisNum);
                            }
                        }
                    }
                } else {
                }
            }

            if ($nta5) {
                $link = mysqli_connect('localhost', 'root', '', 'board');
                $sqlpost1 = "call board.postIds(4, $postid, 'level')";
                mysqli_query($link, $sqlpost1);

                $sql_num_student = "call board.getStudentContact(4, 0, 0, 0)";

                $link = mysqli_connect('localhost', 'root', '', 'board');
                if ($studentContact = mysqli_query($link, $sql_num_student)) {
                    if (mysqli_num_rows($studentContact) > 0) {
                        while ($student = mysqli_fetch_array($studentContact)) {
                            $thisNum = $student['phone_number'];

                            if (!array_search($thisNum, $numbers)) {
                                array_push($numbers, $thisNum);
                            }
                        }
                    }
                } else {
                }
            }

            if ($nta6) {
                $link = mysqli_connect('localhost', 'root', '', 'board');
                $sqlpost1 = "call board.postIds(7, $postid, 'level')";
                echo $sqlpost1;
                mysqli_query($link, $sqlpost1);

                $sql_num_student = "call board.getStudentContact(7, 0, 0, 0)";
                echo $sql_num_student;
                $link = mysqli_connect('localhost', 'root', '', 'board');
                if ($studentContact = mysqli_query($link, $sql_num_student)) {
                    if (mysqli_num_rows($studentContact) > 0) {
                        while ($student = mysqli_fetch_array($studentContact)) {
                            $thisNum = $student['phone_number'];

                            if (!array_search($thisNum, $numbers)) {
                                array_push($numbers, $thisNum);
                            }
                        }
                    }
                } else {
                }
            }

            if(!empty($_POST['argent'])){
                $arrSize = count($numbers);
                for ($x = 1; $x < $arrSize; $x++) {
                    sendText($numbers[$x], $body);
                }
            }

            // Close result set
            mysqli_free_result($result10);
            mysqli_close($link);
        }
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL= index.php">';
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}


//Basic bXdha2FsaW5nYTk4OnhTR0huYkU4dXliQEtM
?>