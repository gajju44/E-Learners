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

<?php session_start();
require_once('Config.php');
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] !== true)
{
  echo'<script> window.location.href = "index.php"</script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body>

    <header>
        <h1 class="logo">E-<span>Learners</span></h1>
        <div id="menu" class="fas fa-bars"></div>
        <nav class="navbar">
            <a href="index_after_login.php#home">home</a>
            <a href="index_after_login.php#course">course</a>
            <a href="index_after_login.php#about">about</a>
            <a onclick="window.history.back()">Back</a>
        </nav>
    </header>
    <div class="unit-container">
        <h1 class="heading">
            surprise test
        </h1>
        <section class="unit">
            <div class="box-container">

                <?php
                $useremail = $_SESSION['lemail'];
               $year=mysqli_query($conn,"SELECT * FROM users WHERE email='$useremail' || enrollment_no='$useremail'");
               $getyear=mysqli_fetch_assoc($year)['years'];
                $sql = "SELECT c_id, c_name, c_decs FROM courses Where years='$getyear'";

                // Execute the query and store the result
                $result = $conn->query($sql);

                // Check if there is at least one row returned
                if ($result->num_rows > 0) {
                    // Loop through each row and output the HTML block with dynamic values
                    while ($row = $result->fetch_assoc()) {
                        $c_id = $row["c_id"];
                        $c_name = $row["c_name"];
                        $c_decs = $row["c_decs"];


                        ?>
                        <div class="box" onclick="window.location.href='https://gpnagpur.tk/surprise_test1.php?c_id=<?php echo $c_id; ?>';">


                            <h3>
                                <?php echo $c_name ?>
                            </h3>
                            <p>
                                <?php echo $c_decs ?>
                            </p>

                        </div>
                    <?php }
                } else {
                    echo "No courses found";
                }

                // Close the database connection
                $conn->close();
                ?>
            </div>
        </section>
    </div>
</body>

</html>