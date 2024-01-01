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

<?php
require("Config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Faculty</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1 class="logo">E-<span>Learners ADMIN</span></h1>
        <div id="menu" class="fas fa-bars"></div>
        <nav class="navbar">
            <a href="indexd.php">E-learners Site</a>
            <a href="logout.php">logout</a>
        </nav>
    </header>

    <!-- ============================= add_content section starts ==================================== -->
    <section class="add_content" id="add_content">
        <div class="row">
            <form action="" method="post">
                <h2>Add Faculty Member</h2>
                <input type="text" placeholder="Enter Username" class="un1" name="username" required>
                <input type="password" placeholder="Enter Password" class="un1" name="password" required>
                <input type="text" placeholder="Enter Name" class="un1" name="name" required>

                <input type="submit" class="btn" value="Submit" name="submit">
            </form>
        </div>
    </section>

</body>
<script src="script.js"></script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<?php
if (isset($_POST['submit'])) {

    // Retrieve the form data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "INSERT INTO faculty (f_name, username, password) VALUES ('$name', '$username', '$password')";
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Faculty added successfully...!!!") window.location.href = "admin_dashboard.php";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>