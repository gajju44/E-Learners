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
require_once('Config.php');
session_start();

if(!isset($_SESSION['faculty_logged']) && $_SESSION['faculty_logged'] !== true)
{
  echo'<script> window.location.href = "index.php"</script>';
    exit();
}
$fid = $_SESSION['faculty'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="admin-body">

        <header>
            <h1 class="logo">E-<span>Learners FACULTY
                   
                </span></h1>
            <div id="menu" class="fas fa-bars"></div>
             <nav class="navbar">
            <a href="facultydashboard.php#home">home</a>
            <a href="logout.php">Logout</a>
        </nav>
        </header>

        <!-- ======================== id -card ================= -->
        <section class="faculty-d-options" id="home">
            <div class="box" onclick="window.location.href='add_content_faculty.php';">
                <h3>Add Content</h3>
            </div>

            <div class="box" onclick="window.location.href='add_question_faculty.php';">
                <h3>Add Questions</h3>
            </div>

            <div class="box" onclick="window.location.href='sur_testadd.php';">
                <h3>Surprise test</h3>
            </div>

            <div class="box" onclick="window.location.href='sur_result_faculty.php';">
                <h3>Surprise-test Result</h3>
            </div>
            <div class="box" onclick="window.location.href='delete_unit_faculty.php';">
                <h3>Delete Unit</h3>
            </div>

            <div class="box" onclick="window.location.href='delete_mcq_faculty.php';">
                <h3>Delete MCQ</h3>
            </div>

            <div class="box" onclick="window.location.href='feedback_show.php';">
                <h3>See Feedback</h3>
            </div>
            <div class="box" onclick="window.location.href='delete_surprise.php';">
                <h3>Delete Surprise Test</h3>
            </div>
        </section>

        <!-- ===========================performance/stats ===========================-->

        <section class="performance-adminside">
            <div class="performance_table">
                <div class="course-table">
                    <h1>Student's Performance</h1>


                    <form method="post" action="">

                        <select id="course" name="course" required>
                            <option value="" selected disabled hidden>Select course</option>
                            <?php

                            $cource = $conn->query("SELECT c_id, c_name FROM courses Where f_id='$fid' ");
                            while ($row = $cource->fetch_assoc()) {
                                ?>
                                <option value='<?php echo $row["c_id"]; ?>'><?php echo $row["c_name"]; ?></option>
                            <?php }
                            ?>
                        </select>

                        <button class="btn-per" name="submit" type="submit">See Performance</button>
                    </form>



                    <?php
                    $getcid = '';
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
                        $getcid = $_POST['course'];
                        ?>



                        <table class="table">
                            <thead>
                                <tr>

                                    <th>Enrollment No</th>
                                    <th>Name</th>
                                    <?php
                                    $unit = mysqli_query($conn, "SELECT * FROM units WHERE c_id = '$getcid'");

                                    // Display course names as table headers
                                    while ($unit_name = $unit->fetch_assoc()) {
                                        echo "<th>" . $unit_name['unit_name'] . "</th>";
                                    }

                                    ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Initialize an empty array to keep track of processed enrollment numbers
                                $processed_enrollment_numbers = array();

                                $sql1 = "SELECT * FROM courses WHERE c_id='$getcid'";
                                $result1 = mysqli_query($conn, $sql1);
                                $row1 = mysqli_fetch_assoc($result1);
                                $course_name = $row1['c_name'];

                                // Select all users
                                $sql2 = "SELECT * FROM performance WHERE c_id='$getcid' ";
                                $result_user = mysqli_query($conn, $sql2);

                                // Loop through each user and display their enroll no, name, and percentage for each unit associated with a course
                                while ($row_user = mysqli_fetch_assoc($result_user)) {
                                    $enrollment_no = $row_user["enrollment_no"];
                                    $name = $row_user["studname"];

                                    // Check if the enrollment number has already been processed
                                    if (in_array($enrollment_no, $processed_enrollment_numbers)) {
                                        // If it has, skip displaying the enrollment number and name, and only display the performance for the current unit
                                        $unit_id = $row_user['unit_id'];


                                    } else {
                                        // If it hasn't, add it to the array and display the user's data as before
                                        array_push($processed_enrollment_numbers, $enrollment_no);
                                        echo "<tr>";
                                        echo "<td>" . $enrollment_no . "</td>";
                                        echo "<td>" . $name . "</td>";

                                        // Loop through each unit associated with the course and display the performance for the user if available
                                        $unit = mysqli_query($conn, "SELECT * FROM units WHERE c_id = '$getcid'");
                                        while ($unit_name = $unit->fetch_assoc()) {
                                            $unit_id = $unit_name['unit_id'];
                                            $unit_percentage_query = mysqli_query($conn, "SELECT percentage FROM performance WHERE enrollment_no = '$enrollment_no' AND c_id ='$getcid' AND unit_id = '$unit_id' ");
                                            if (mysqli_num_rows($unit_percentage_query) > 0) {
                                                $row_percentage = mysqli_fetch_assoc($unit_percentage_query);
                                                $percentage = $row_percentage["percentage"];
                                                echo "<td>" . $percentage . "%</td>";
                                            } else {
                                                echo "<td>N/A</td>";
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                }
                                ?>


                            </tbody>
                        </table>
                    <?php } ?>

                </div>
        </section>
    </div>
</body>

<script src="script.js"></script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>


</html>
<?php

?>