<!--GNU GENERAL PUBLIC LICENSE
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
along with this program.  If not, see <https://www.gnu.org/licenses/>.-->

<html>

<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
</body>

<?php
session_start();
error_reporting(0);

require_once('Config.php');

if (isset($_GET['v_code']) && isset($_GET['vemail'])) {
    $email = $_GET['vemail'];
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if ($query) {
        if (mysqli_num_rows($query) == 1) {
            $result_fetch = mysqli_fetch_assoc($query);

            if ($result_fetch['verification_status'] == 0) {
                $verification_code = $result_fetch['verification_code'];
                $update = mysqli_query($conn, "UPDATE users SET verification_status = '1' WHERE verification_code='$verification_code'");

                if ($update) {
                    echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Email verified successfully!!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href = 'login.php';
                        });
                    </script>";
                    exit;
                } else {
                    echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong',
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Email already verified',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.href = 'login.php';
                    });
                </script>";
                exit;
            }
        }
    }
   else{
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'SERVER DOWN',
    });
</script>";

   }
}

?>
</html>
