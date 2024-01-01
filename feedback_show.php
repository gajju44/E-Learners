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
error_reporting(0);
session_start();
require_once('Config.php');
$fid = $_SESSION['faculty'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback show</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<header>
            <h1 class="logo">E-<span>Learners FACULTY
                   
                </span></h1>
            <div id="menu" class="fas fa-bars"></div>
            <nav class="navbar">
                <a href="facultydashboard.php">E-learners Site</a>
                <a href="logout.php">logout</a>
                <a onclick="window.history.back()">Back</a>
            </nav>
        </header>
    <div class="admin-body">

<!-- =========================== feedback_show ===========================-->

        <section class="feedback-show">
            <div class="feedback-show_table">
                <div class="course-table">
                    <h1>Student's Feedback & queries</h1>
                    <form method="post" action="">
        

                        <select id="course" name="course">
                            <option value="" selected disabled hidden>Select course</option>
                            <?php

                            $cource = $conn->query("SELECT c_id, c_name FROM courses Where f_id='$fid' ");
                            while ($row = $cource->fetch_assoc()) {
                                ?>
                                <option value='<?php echo $row["c_name"]; ?>'><?php echo $row["c_name"]; ?></option>
                            <?php }
                            ?>
                        </select>

                        <button class="btn" type="submit" name="submit">See feedback</button>
                    </form>
                    <?php
                     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
                                    $fbid = $_POST['id'];
                                    $delete = mysqli_query($conn, "DELETE FROM feedback WHERE fb_id = '$fbid'");
                                   
                                }
                    global $course1;
                    
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
                        $course1 = $_POST['course'];
                        echo "<h2>Selected Course: " . $course1 . "<h2>";
                   
                    ?>
                    <form method="post" action="">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Enrollment No</th>
                                    <th>Feedback & Queries</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                // Select all users
                                $sql2 = mysqli_query($conn, "SELECT * FROM feedback where  course='$course1'");

                                // Loop through each user and display their enroll no, name, and percentage for each course associated with a faculty
                                while ($row_user = mysqli_fetch_assoc($sql2)) {

                                    echo "<tr>";
                                    echo "<td>" . $row_user["enroll_no"] . "</td>";
                                    echo "<td>" . $row_user["feedback"] . "</td>";
                                    echo "<td> <form method='post' action=''>
                                    <input type='hidden' name='id' value='" . $row_user["fb_id"] . "'>
                                    <input type='hidden' name='course' value='" . $course1 . "'>
                                    <button class='btn' type='submit' name='delete'>delete</button>
                                </form>
                                 </td>";
                                    echo "</tr>";
                                }
                                
                                ?>
                            </tbody>
                        </table>
                    </form>
                    <?php  } ?>
                </div>

            </div>
        </section>
    </div>
</body>
<script>
if(window.history.replaceState)
{
window.history.replaceState(null,null,window.location.href);
}
</script>

<script src="script.js"></script>

</html>
