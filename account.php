<?php
session_start();
require "confirm.php";
$uid = $_SESSION['id'];
$student = $_SESSION['student'];
require "bd_configure.php";

if ($student) {
    $sql1 = "call getStudentInfo($uid)";
} else {
    $sql1 = "call getStaffInfo($uid)";
}

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate new password
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Please enter the new password.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Password must have atleast 6 characters.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm the password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before updating the database
    if (empty($new_password_err) && empty($confirm_password_err)) {
        // Prepare an update statement
        $sql = "UPDATE user SET password = ? WHERE iduser = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                echo '<META HTTP-EQUIV="Refresh" Content="0; URL= login.php">';
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
                exit();
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html>

<?php
// Attempt select query execution with order by clause
if ($result1 = mysqli_query($link, $sql1)) {
    if (mysqli_num_rows($result1) > 0) {
        while ($row1 = mysqli_fetch_array($result1)) {
            include "head.php";
?>

            <body>
                <?php
                include "navbar.php";

                ?>

                <!-- Start: account card -->
                <div class="card" style="margin: 30px;">
                    <div class="card-header">
                        <h5 class="mb-0">Profile settings</h5>
                    </div>
                    <div class="card-body">
                        <form action="accountUp.php" method="POST" enctype="multipart/form-data">
                            <div class="row row-cols-1 row-cols-xl-2 row-cols-xxl-2">
                                <div class="col">
                                    <label class="form-label">Username</label>
                                    <input name="username" value="<?php echo $row1['username']; ?>" class="border rounded form-control" type="text" placeholder="Username" required="" style="width: 100%;padding: 1px 2px;">
                                </div>
                                <div class="col">
                                    <label class="form-label">phone number</label>
                                    <input name="phone" class="border rounded form-control" type="text" value="<?php echo $row1['phone_number']; ?>" placeholder="phone number" required="" style="width: 100%;padding: 2px 2px;" inputmode="tel">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col">
                                    <input name="username_save" class="btn btn-primary" type="submit" style="padding: 5px 12px;" value="save information">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End: account card -->

                <!-- Start: account card -->
                <div class="card" style="margin: 30px;">
                    <div class="card-header">
                        <h5 class="mb-0">Change password</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                                    <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                                </div>
                                <div class="col">
                                    <label class="form-label">Repeat Password</label>
                                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="submit" class="btn btn-primary" value="change password">
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- End: account card -->
    <?php

            // Close connection
            mysqli_close($link);
        }
        // Close result set
        mysqli_free_result($result1);
    }
}
    ?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.min.js"></script>
            </body>

</html>