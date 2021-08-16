<?php
$uid = $_SESSION['id'];
$student = $_SESSION['student'];
$name="";
if ($student) {
    $sql1 = "call getStudentInfo($uid)";
    
} else {
    $sql1 = "call getStaffInfo($uid)";
}

if ($result1 = mysqli_query($link, $sql1)) {
    if (mysqli_num_rows($result1) > 0) {
        while ($row1 = mysqli_fetch_array($result1)) {
            if ($student) {
                $level = $row1['idlevel'];
                $coarse = $row1['idcoarse'];
                $_level = $row1['level_name'];
                $_coarse = $row1['coarse_name'];
            }
            $department = $row1['iddepartment'];
            $college = $row1['idcollege'];
            $_department = $row1['department_name'];
            $_college = $row1['college_name'];
            $name = $row1['fullname'];
        }
        // Close result set
        mysqli_free_result($result1);
        mysqli_close($link);
    }
}
?>

<script type="text/javascript">
    function removes(id) {
        if (confirm("Are you sure you want to delete this post?")) {
            window.location.href = 'remove_post.php?post=' + id;
        }
    }
</script>

<div>
    <h5 class="text-white" style="margin: 20px;">Welcome&nbsp;&nbsp;
        <span style="font-weight: normal;"><?php echo $name; ?></span>
    </h5>
</div>

<div class="text-end">
    <h6 class="display-5 text-center text-white" style="margin: 20px;text-align: center;">Must Online Notice Board</h6>
</div>

<div class="row align-items-center" style="margin: 0px">
    <div class="col mb-4">

        <div class="card shadow border-start-success py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col-auto" style="border-right: 1px solid rgba(177, 178, 179, 0.53)">
                    </div>
                    <div class="col-auto me-2">

                        <div class="text-primary  text-xs mb-1">
                            <?php if ($student) {
                                echo '<ul style="margin:-12px"><li>Coarse : ' . $_coarse . '</li>';
                                echo '<li>Level : ' . $_level . '</li></ul>';
                            } else {
                                echo '<a class="fw-bold" href="upload.php"><span>Create New Announcement</span></a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col mb-4">
        <div class="card shadow border-start-info py-2">
            <div class="card-body">
                <ul class="text-primary" style="margin: -20px;">
                    <li>College : <?php echo $_college; ?></li>
                    <li>Department : <?php echo $_department; ?></li>

                </ul>
            </div>
        </div>
    </div>

    <div class="col mb-4">
        <div class="card shadow border-start-warning py-2" style="padding: 0px; background: rgba(29, 128, 159, 0); color: rgb(255, 255, 255);">
            <div class="card-body" style="padding: 0px">
                <div class="row no-gutters" style="margin: 0px">

                    <div class="col me-2" style="padding: 0px; margin: 0px">
                        <h1 class="display-6 text-center" style="margin: 0px">
                            <script>
                                setInterval(function() {
                                    hello();
                                }, 1000);

                                function hello() {
                                    //alert("<?php echo date("H:i:s"); ?>");
                                }
                            </script>
                            <?php echo date("H:i:s"); ?>
                        </h1>
                    </div>
                </div>
                <div class="row no-gutters" style="margin: 0px">
                    <div class="col text-center me-2">
                        <p><?php echo date("D, M-d-Y"); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start: two sided div -->
<div style="margin: 10px">
    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-2">
        <div class="col menus" style="margin-bottom: 10px">
            <div class=" row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-3" style="padding-right: 10px">

                <?php
                $link = mysqli_connect('localhost', 'root', '', 'board');
                if ($student) {
                    $sql = "call getStudentPost($level, $coarse, $department, $college)";
                } else {
                    $sql = "call getStaffPost($department)";
                }

                if ($result = mysqli_query($link, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<div class="col" style="margin-bottom: 10px; padding-right: 0px"><div class="card" style="height: 100%;"><div class="card-body">';
                            if ($row['level'] == 'argent') {
                                echo '<div class="col" style="text-align: right"><span style="color: var(--bs-red)"><i class="typcn typcn-pin"></i>&nbsp; Urgent<br /></span></div>';
                            } elseif ($row['level'] == 'normal') {
                                echo '<div class="col" style="text-align: right"><span style="color: var(--bs-blue)"><i class="typcn typcn-pin"></i>&nbsp; Normal<br /></span></div>';
                            }

                            echo '<div class="row" ><div class="col">';
                            echo '<h5 class="display-6" style="font-size: 30px">' . $row['post_head'] . '</h5></div></div>';
                            echo '<p class="lead text-muted" style="font-size: 15px">Sent at : ' . $row['post_time'];
                            echo '</p><p class="card-text" >' . $row['post_body'];
                            echo '</p><div class="row row-cols-2"><div class="col">';
                            if ($row['post_file'] != 'null' &&  $row['post_file'] != '') {
                                echo '<a href="#">Download file</a>';
                            }

                            echo '</div><div class="col">';
                            echo '<p class="text-end text-muted" style="font-size: 13px;">by ' . $row['sender'] . '</p></div></div><div class="row"><div class="col-auto">';
                            echo '<span class="border rounded-pill" style="padding-right: 5px;padding-left: 5px;padding-top: 2px;padding-bottom: 2px;">' . $row['tag'] . '</span>';
                            echo '</div></div></div></div></div>';
                        }
                        // Close result set
                        mysqli_free_result($result);
                    }
                } else {
                }
                ?>

            </div>

        </div>

        <?php
        if (!$student) {
        ?>
            <div class="col menuss" style="margin-bottom: 10px">

                <div style="background: #ffffff; border-radius: 5px">
                    <h4 class="text-center">Sent Announcement</h4>
                </div>

                <?php
                $link = mysqli_connect('localhost', 'root', '', 'board');
                $sql1 = "call board.getSenderPost('$name')";
                if ($result1 = mysqli_query($link, $sql1)) {
                    if (mysqli_num_rows($result1) > 0) {
                        while ($row1 = mysqli_fetch_array($result1)) {


                ?>
                            <div class="card" style="margin-bottom: 10px">
                                <div class="card-body">
                                    <h6 class="card-title"><?php echo $row1['post_head'] ?></h6>
                                    <p class="lead text-muted" style="font-size: 15px; margin: 0px">
                                        <?php echo $row1['post_time']  ?>
                                    </p>
                                    <p class="card-text">
                                        <?php echo $row1['post_body'] ?>
                                    </p>
                                    <p>
                                        <a class="link-danger" href="javascript:removes(<?php echo $row1['post_id']; ?>)">Remove post</a>
                                        <!-- <a class="float-end" href="#">Edit post</a> -->
                                    </p>
                                </div>
                            </div>

                <?php

                        }
                    }
                }
                ?>


            </div>
        <?php
        }
        ?>

    </div>

</div>
<!-- End: two sided div -->