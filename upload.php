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
            'Authorization: Basic bXdha2FsaW5nYTk4OnhTR0huYkU4dXliQEtM',
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

    echo $sql1;
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

            if(!empty($_POST['argent'])){
                $arrSize = count($numbers);
                for ($x = 1; $x < $arrSize; $x++) {
                    //sendText($numbers[$x], $body);
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
?>
<!DOCTYPE html>
<html>

<?php
include "head.php";
?>

<body>
    <?php
    include "navbar.php";
    ?>

    <script>
        function fnormal() {
            var checkBox = document.getElementById("formCheck-22");
            if (checkBox.checked == true) {
                document.getElementById("formCheck-23").checked = false;
            }
        }

        function fargent() {
            var checkBox = document.getElementById("formCheck-23");
            if (checkBox.checked == true) {
                document.getElementById("formCheck-22").checked = false;
            }
        }

        function other() {
            var checkBox = document.getElementById("formCheck-8");
            if (checkBox.checked == true) {
                document.getElementById("others").style.display = "block";
                document.getElementById("formCheck-1").checked = false;
                document.getElementById("formCheck-2").checked = false;
                document.getElementById("formCheck-3").checked = false;
                document.getElementById("formCheck-4").checked = false;
                document.getElementById("formCheck-5").checked = false;
                document.getElementById("formCheck-6").checked = false;
                document.getElementById("formCheck-7").checked = false;
            } else {
                document.getElementById("others").style.display = "none";
            }
        }

        function Allict() {
            var checkBox = document.getElementById("formCheck-7");
            if (checkBox.checked == true) {
                document.getElementById("formCheck-1").checked = false;
                document.getElementById("formCheck-2").checked = false;
                document.getElementById("formCheck-3").checked = false;
                document.getElementById("formCheck-4").checked = false;
                document.getElementById("formCheck-5").checked = false;
                document.getElementById("formCheck-6").checked = false;
                document.getElementById("formCheck-8").checked = false;
                other();
            }
        }

        function AllcompEng() {
            var checkBox = document.getElementById("formCheck-6");
            if (checkBox.checked == true) {
                document.getElementById("formCheck-1").checked = false;
                document.getElementById("formCheck-2").checked = false;
                document.getElementById("formCheck-3").checked = false;
                document.getElementById("formCheck-4").checked = false;
                document.getElementById("formCheck-5").checked = false;
                document.getElementById("formCheck-7").checked = false;
                document.getElementById("formCheck-8").checked = false;
                other();
            }
        }

        function Allcs() {
            var checkBox = document.getElementById("formCheck-5");
            if (checkBox.checked == true) {
                document.getElementById("formCheck-1").checked = false;
                document.getElementById("formCheck-2").checked = false;
                document.getElementById("formCheck-3").checked = false;
                document.getElementById("formCheck-4").checked = false;
                document.getElementById("formCheck-7").checked = false;
                document.getElementById("formCheck-6").checked = false;
                document.getElementById("formCheck-8").checked = false;
                other();
            }
        }

        function csdep() {
            var checkBox = document.getElementById("formCheck-4");
            if (checkBox.checked == true) {
                document.getElementById("formCheck-1").checked = false;
                document.getElementById("formCheck-2").checked = false;
                document.getElementById("formCheck-3").checked = false;
                document.getElementById("formCheck-7").checked = false;
                document.getElementById("formCheck-5").checked = false;
                document.getElementById("formCheck-6").checked = false;
                document.getElementById("formCheck-8").checked = false;
                other();
            }
        }

        function alloffical() {
            var checkBox = document.getElementById("formCheck-3");
            if (checkBox.checked == true) {
                document.getElementById("formCheck-1").checked = false;
                document.getElementById("formCheck-2").checked = false;
                document.getElementById("formCheck-4").checked = false;
                document.getElementById("formCheck-7").checked = false;
                document.getElementById("formCheck-5").checked = false;
                document.getElementById("formCheck-6").checked = false;
                document.getElementById("formCheck-8").checked = false;
                other();
            }
        }

        function allstudent() {
            var checkBox = document.getElementById("formCheck-2");
            if (checkBox.checked == true) {
                document.getElementById("formCheck-1").checked = false;
                document.getElementById("formCheck-4").checked = false;
                document.getElementById("formCheck-3").checked = false;
                document.getElementById("formCheck-7").checked = false;
                document.getElementById("formCheck-5").checked = false;
                document.getElementById("formCheck-6").checked = false;
                document.getElementById("formCheck-8").checked = false;
                other();
            }
        }

        function allreceiver() {
            var checkBox = document.getElementById("formCheck-1");
            if (checkBox.checked == true) {
                document.getElementById("formCheck-4").checked = false;
                document.getElementById("formCheck-2").checked = false;
                document.getElementById("formCheck-3").checked = false;
                document.getElementById("formCheck-7").checked = false;
                document.getElementById("formCheck-5").checked = false;
                document.getElementById("formCheck-6").checked = false;
                document.getElementById("formCheck-8").checked = false;
                other();
            }
        }

        function levels() {
            var checkBox = document.getElementById("formCheck-9");
            if (checkBox.checked == true) {
                document.getElementById("level").style.display = "block";
                <?php $level = true; ?>
            } else {
                document.getElementById("level").style.display = "none";
                <?php $level = false; ?>
            }
        }

        function coarses() {
            var checkBox = document.getElementById("formCheck-10");
            if (checkBox.checked == true) {

                document.getElementById("coarse").style.display = "block";
                document.getElementById("level").style.display = "block";
                document.getElementById("department").style.display = "none";
                document.getElementById("college").style.display = "none";

                document.getElementById("formCheck-11").checked = false;
                document.getElementById("formCheck-12").checked = false;
                document.getElementById("formCheck-9").checked = true;

                <?php $coarse = true; ?>
            } else {
                document.getElementById("coarse").style.display = "none";
                <?php $coarse = false; ?>
            }
        }

        function departments() {
            var checkBox = document.getElementById("formCheck-11");
            if (checkBox.checked == true) {

                document.getElementById("department").style.display = "block";
                document.getElementById("level").style.display = "block";
                document.getElementById("coarse").style.display = "none";
                document.getElementById("college").style.display = "none";

                document.getElementById("formCheck-10").checked = false;
                document.getElementById("formCheck-12").checked = false;
                document.getElementById("formCheck-9").checked = true;
                <?php $department = true; ?>
            } else {
                document.getElementById("department").style.display = "none";
                <?php $department = false; ?>
            }
        }

        function colleges() {
            var checkBox = document.getElementById("formCheck-12");
            if (checkBox.checked == true) {

                document.getElementById("college").style.display = "block";
                document.getElementById("level").style.display = "block";
                document.getElementById("department").style.display = "none";
                document.getElementById("coarse").style.display = "none";

                document.getElementById("formCheck-10").checked = false;
                document.getElementById("formCheck-11").checked = false;
                document.getElementById("formCheck-9").checked = true;

                <?php $college = true; ?>
            } else {
                document.getElementById("college").style.display = "none";
                <?php $college = false; ?>
            }
        }
    </script>

    <div class="card" style="margin: 20px;">
        <div class="card-header">
            <h5 class="mb-0">Create new announcement</h5>
        </div>
        <div class="card-body">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <div class="row" style="margin: 10px;">
                    <div class="col">
                        <input class="form-control form-control" type="text" name="header" placeholder="Title max(100 characters)" required="" maxlength="100">
                    </div>
                </div>
                <div class="row" style="margin: 10px;">
                    <div class="col">
                        <textarea class="form-control form-control" name="body" placeholder="content max(320 characters)" required="" maxlength="320" spellcheck="true" wrap="soft"></textarea>
                    </div>
                </div>
                <div class="row" style="margin: 10px;">
                    <div class="col">
                        <label class="form-label">please choose file if any:</label>
                        <input class="form-control form-control" type="file">
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-3" style="margin: 10px;">
                    <div class="col">
                        <div>
                            <label class="form-label">Select Receiver<span class="text-black-50" style="font-size: 12px;">&nbsp; &nbsp;(choose only one)</span></label>
                            <div id="all_receiver" class="form-check">
                                <input onchange="allreceiver()" name="all_receiver" class="form-check-input" type="checkbox" id="formCheck-1">
                                <label class="form-check-label" for="formCheck-1">For All&nbsp; (student and staff)</label>
                            </div>
                            <div id="all_student" class="form-check">
                                <input onchange="allstudent()" name="all_student" class="form-check-input" type="checkbox" id="formCheck-2">
                                <label class="form-check-label" for="formCheck-2">All Student</label>
                            </div>
                            <div id="all_offical" class="form-check">
                                <input onchange="alloffical()" name="all_offical" class="form-check-input" type="checkbox" id="formCheck-3">
                                <label class="form-check-label" for="formCheck-3">All Staff</label>
                            </div>
                            <div id="cs_dep" class="form-check">
                                <input onchange="csdep()" name="cs_dep" class="form-check-input" type="checkbox" id="formCheck-4">
                                <label class="form-check-label" for="formCheck-4">Cs and Comp Eng Department</label>
                            </div>
                            <div id="All_cs" class="form-check">
                                <input onchange="Allcs()" name="All_cs" class="form-check-input" type="checkbox" id="formCheck-5">
                                <label class="form-check-label" for="formCheck-5">Computer science</label>
                            </div>
                            <div id="All_compEng" class="form-check">
                                <input onchange="AllcompEng()" name="All_compEng" class="form-check-input" type="checkbox" id="formCheck-6">
                                <label class="form-check-label" for="formCheck-6">Computer Eng</label>
                            </div>
                            <div id="All_ict" class="form-check">
                                <input onchange="Allict()" name="All_ict" class="form-check-input" type="checkbox" id="formCheck-7">
                                <label class="form-check-label" for="formCheck-7">ICT</label>
                            </div>
                            <div id="_other" class="form-check">
                                <input onchange="other()" name="_other" class="form-check-input" type="checkbox" id="formCheck-8">
                                <label class="form-check-label" for="formCheck-8">Choose other</label>
                            </div>
                        </div>
                    </div>

                    <div id="others" style="display: none;" class="col">
                        <div>
                            <label class="form-label">Other Option</label>
                            <div class="form-check">
                                <input onchange="levels()" name="level" class="form-check-input" type="checkbox" id="formCheck-9">
                                <label class="form-check-label" for="formCheck-9">Level</label>
                            </div>
                            <div class="form-check">
                                <input onchange="coarses()" name="coarse" class="form-check-input" type="checkbox" id="formCheck-10">
                                <label class="form-check-label" for="formCheck-10">Coarse</label>
                            </div>
                            <div class="form-check">
                                <input onchange="departments()" name="department" class="form-check-input" type="checkbox" id="formCheck-11">
                                <label class="form-check-label" for="formCheck-11">Department</label>
                            </div>
                            <div class="form-check">
                                <input onchange="colleges()" name="college" class="form-check-input" type="checkbox" id="formCheck-12">
                                <label class="form-check-label" for="formCheck-12">College</label>
                            </div>
                        </div>

                        <div id="level" style="display: none;">
                            <label class="form-label">Level</label>
                            <div class="form-check">
                                <input name="nta4" class="form-check-input" type="checkbox" id="formCheck-13" checked>
                                <label class="form-check-label" for="formCheck-13">NTA 4</label>
                            </div>
                            <div class="form-check">
                                <input name="nta5" class="form-check-input" type="checkbox" id="formCheck-14">
                                <label class="form-check-label" for="formCheck-14">NTA 5</label>
                            </div>
                            <div class="form-check">
                                <input name="nta6" class="form-check-input" type="checkbox" id="formCheck-15">
                                <label class="form-check-label" for="formCheck-15">NTA 6</label>
                            </div>
                        </div>

                        <div id="coarse" style="display: none;">
                            <label class="form-label">Coarse</label>
                            <div class="form-check">
                                <input name="cs_co" class="form-check-input" type="checkbox" id="formCheck-16" checked>
                                <label class="form-check-label" for="formCheck-16">Computer Science</label>
                            </div>
                            <div class="form-check">
                                <input name="eng_co" class="form-check-input" type="checkbox" id="formCheck-17">
                                <label class="form-check-label" for="formCheck-17">Computer Eng</label>
                            </div>
                            <div class="form-check">
                                <input name="ict_co" class="form-check-input" type="checkbox" id="formCheck-18">
                                <label class="form-check-label" for="formCheck-18">ICT</label>
                            </div>
                        </div>

                        <div id="department" style="display: none;">
                            <label class="form-label">Department</label>
                            <div class="form-check">
                                <input name="eng_cs" class="form-check-input" type="checkbox" id="formCheck-19" checked>
                                <label class="form-check-label" for="formCheck-19">Computer Science and Computer Eng</label>
                            </div>
                            <div class="form-check">
                                <input name="ict" class="form-check-input" type="checkbox" id="formCheck-20">
                                <label class="form-check-label" for="formCheck-20">ICT</label>
                            </div>
                        </div>

                        <div id="college" style="display: none;">
                            <label class="form-label">College</label>
                            <div class="form-check">
                                <input name="college" class="form-check-input" type="checkbox" id="formCheck-21" checked>
                                <label class="form-check-label" for="formCheck-21">COICT</label>
                            </div>
                        </div>

                    </div>

                    <div class="col">
                        <label class="form-label">Select level of announcement</label>
                        <div class="form-check">
                            <input class="form-check-input" onchange="fnormal()" name="normal" type="checkbox" id="formCheck-22" checked>
                            <label class="form-check-label" for="formCheck-22">normal</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" onchange="fargent()" name="argent" type="checkbox" id="formCheck-23">
                            <label class="form-check-label" for="formCheck-23">Argent&nbsp;
                                <span class="text-black-50" style="font-size: 12px;">(send sms)</span>
                            </label>
                        </div>
                    </div>

                </div>

                <div class="row" style="margin: 10px;">
                    <div class="col text-end">
                        <input name="submit_btn" type="submit" class="btn btn-primary" style="margin-left: 10px;" value="save">
                    </div>
                </div>

            </form>
        </div>
    </div>
    <script defer src="assets/js/jquery.min.js"></script>
    <script defer src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script defer src="assets/js/script.min.js"></script>
</body>

</html>