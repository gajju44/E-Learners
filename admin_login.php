<!--
    GNU GENERAL PUBLIC LICENSE
Version 3, 29 June 2007
Copyright (C) [2023] [Gajendra Naphade]
Copyright (C) [2023] [Vedant Chaudhari]
Copyright (C) [2023] [Rupesh Dhamane]
Copyright (C) [2023] [Bhavesh Adekar]

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
-->
<!-- ==================== HTML starts ============== -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container1">
        <div class="main-div">
            <h1>Admin Log-in</h1>
            <form method="post" class="form-div" name="Login">
                <input type="text" name="user" placeholder="User Id" required="true"
                    style="text-transform: capitalize;">
                <input type="password" name="password" id="password" placeholder="Password" required="true">
                <div class="password-box">
                    <input type="checkbox" class="box" onclick="Show()">Show Password</input>
                </div>
                <button class="btn" type="submit" name="submit">Submit</button>

                <div class="links">
                    <p> <a href="login.php">USER LOGIN</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <script>
        function Show() {
            var x = document.getElementById("password");
            if (x.type == "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
<?php
session_start();
error_reporting(0);
require_once('Config.php');
// Login PHP
if (isset($_POST['submit'])) {
    $admin = $_POST['user'];
    $password = str_replace(' ', '', $_POST['password']);

    $ret = mysqli_query($conn, "select * from admin where user ='$admin'");
    $result = mysqli_fetch_array($ret);
    if ($result > 0) {

        if (password_verify($password, $result['password'])) {
            // start session and redirect to user page
            $_SESSION['admin_logged'] = true;
            echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Logged in successfully!",
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(function() {
                            window.location.href = "admin_dashboard.php";
                        });
                      </script>';
        } else {
            echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Incorrect password",
                        });
                      </script>';
        }
    } else {
        echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "User not found",
                    });
                  </script>';
    }
}
?>
<Style>
    body {
        min-height: 100vh;
        width: 100%;
        height: 100%;
        background: url(https://static.vecteezy.com/system/resources/previews/005/948/321/large_2x/back-to-school-banner-with-hand-drawn-line-art-icons-of-education-science-objects-and-office-supplies-school-supplies-concept-of-education-background-free-vector.jpg);
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
    }
</Style>

</html>
