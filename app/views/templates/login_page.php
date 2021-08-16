    <?php
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session.
    session_destroy();

    $username = $password = "";
    $username_err = $password_err = $login_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if username is empty
        if (empty(trim($_POST["username"]))) {
            $username_err = "Please enter username.";
        } else {
            $username = trim($_POST["username"]);
        }

        // Check if password is empty
        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter your password.";
        } else {
            $password = trim($_POST["password"]);
        }

        // Validate credentials
        if (empty($username_err) && empty($password_err)) {
            // Prepare a select statement
            $sql = "SELECT iduser,status,password FROM user WHERE username = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                // Set parameters
                $param_username = $username;

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Store result
                    mysqli_stmt_store_result($stmt);

                    // Check if username exists, if yes then verify password
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $id, $status, $hashed_password);
                        if (mysqli_stmt_fetch($stmt)) {
                            if (password_verify($password, $hashed_password)) {
                                // Password is correct, so start a new session
                                session_start();

                                // Store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;
                                $_SESSION['loggedin_time'] = time();

                                if ($status == 'student') {
                                    $_SESSION['student'] = true;
                                } elseif ($status == 'staff') {
                                    $_SESSION['student'] = false;
                                } elseif ($status == 'admin') {
                                    $_SESSION['student'] = false;
                                }

                                // Redirect user to welcome page
                                echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.BASE_URL.'">';
                            } else {
                                // Password is not valid, display a generic error message
                                $login_err = "Invalid username or password.";
                            }
                        }
                    } else {
                        // Username doesn't exist, display a generic error message
                        $login_err = "Invalid username or password.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }

        // Close connection
        mysqli_close($link);
    }
    ?>
    <!-- Start: OcOrato - Login form -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="form" style="font-family:Quicksand, sans-serif;background-color:rgba(44,40,52,0.73);width:320px;padding:40px;">
        <h1 id="head" style="color: rgb(228,229,127);">Login Form</h1>
        <div class="text-center" style="margin: 20px; background-color:white; border-radius: 23px;">
            <img _ngcontent-iqd-c2="" alt="" src="assets/img/logo.svg" width="160" height="150">
        </div>
        <div class="form-group mb-3">
            <input id="formum" type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Username">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group mb-3">
            <input id="formum2" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <input type="submit" class="btn btn-outline-light" value="Login" id="butonas" style="width:100%;height:100%;margin-bottom:10px;background-color:rgb(106,176,209);">
        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>
    </form>