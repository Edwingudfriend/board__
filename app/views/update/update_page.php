<?php require VIEW_ROOT.'/update/other_update.php'; ?>
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
                <!-- <div class="row" style="margin: 10px;">
                    <div class="col">
                        <label class="form-label">please choose file if any:</label>
                        <input class="form-control form-control" type="file">
                    </div>
                </div> -->

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
                            <label class="form-check-label" for="formCheck-22">Normal</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" onchange="fargent()" name="argent" type="checkbox" id="formCheck-23">
                            <label class="form-check-label" for="formCheck-23">Urgent&nbsp;
                                <span class="text-black-50" style="font-size: 12px;">(send sms)</span>
                            </label>
                        </div>
                    </div>

                </div>

                <div class="row" style="margin: 10px;">
                    <div class="col text-end">
                        <input name="submit_btn" type="submit" class="btn btn-primary" style="margin-left: 10px;" value="Save">
                    </div>
                </div>

            </form>
        </div>
    </div>