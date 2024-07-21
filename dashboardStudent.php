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

<?php require_once('Config.php');
session_start();
$useremail = $_SESSION['lemail'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <div class="main-body">

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

        <!-- ======================== id -card ================= -->
        <section class="id-info">
            <div class="id_card">
                <h1>
                    <?php


                    $query = mysqli_query($conn, "select name from users where  email='$useremail' || enrollment_no='$useremail'");
                    //This query is for getting the respective user's data from database.
                    
                    $string = mysqli_fetch_assoc($query); //function  use to store data which is in '$query' into an  associative array
                    $email = implode("_", $string); //implode function is use to join all elements into a string         
                    echo $email;

                    ?>
                </h1>
                <p>Enroll no. :
                    <?php

                  
                    $query = mysqli_query($conn, "select enrollment_no from users where  email='$useremail' || enrollment_no='$useremail'");
                    //This query is for getting the respective user's data from database.
                    
                    $string = mysqli_fetch_assoc($query); //function  use to store data which is in '$query' into an  associative array
                    $enroll = implode("_", $string); //implode function is use to join all elements into a string         
                    echo $enroll;

                    ?>
                </p> <br>
                <p>Branch :
                    <?php

                   

                    $query = mysqli_query($conn, "select branch from users where  email='$useremail' || enrollment_no='$useremail'");
                    //This query is for getting the respective user's data from database.
                    
                    $string = mysqli_fetch_assoc($query); //function  use to store data which is in '$query' into an  associative array
                    $branchp = implode("_", $string); //implode function is use to join all elements into a string         
                    echo $branchp;

                    ?>
                </p> <br>
                <p>Year :
                    <?php

                  
                    $query = mysqli_query($conn, "select years from users where  email='$useremail' || enrollment_no='$useremail'");
                    //This query is for getting the respective user's data from database.
                    
                    $string = mysqli_fetch_assoc($query); //function  use to store data which is in '$query' into an  associative array
                    $year = implode("_", $string); //implode function is use to join all elements into a string         
                    echo $year;

                    ?>
                </p>
            </div>
        </section>

        <!-- ===========================performance/stats ===========================-->

        <h2>Performance</h2>

        <section class="performance">


            <?php
          
            $enrollment_number = $enroll;
            $sql = "SELECT DISTINCT c_id FROM performance WHERE enrollment_no = '$enrollment_number'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $course_id = $row["c_id"];
                    $unit_sql = "SELECT unit_id, percentage FROM performance WHERE enrollment_no = '$enrollment_number' AND c_id = '$course_id'";
                    $unit_result = $conn->query($unit_sql);

                    $total_percentage = 0;
                    $unit_count = 0;
                    $unit_percentages = array();

                    // Loop through each unit associated with the course
                    while ($unit_row = $unit_result->fetch_assoc()) {
                        $unit_id = $unit_row["unit_id"];
                        $unit_percentage = $unit_row["percentage"];

                        $total_percentage += $unit_percentage;
                        $unit_count++;

                        $uname_sql = "SELECT unit_name FROM units WHERE unit_id = '$unit_id'";
                        $unit_name_result = $conn->query($uname_sql);

                        // Loop through each row of the result to fetch the unit names
                        while ($unit_name_row = $unit_name_result->fetch_assoc()) {
                            $unit_name = $unit_name_row["unit_name"];
                            $unit_percentages[$unit_name] = $unit_percentage;
                        }
                    }
                    $aggregate_percentage = $total_percentage / $unit_count;
                    ?>

                    <div class="box">

                        <?php
                        $sql2 = "SELECT c_name FROM courses WHERE c_id = '$course_id'";
                        $course_name_result = $conn->query($sql2);
                        $course_name_row = $course_name_result->fetch_assoc();
                        $c_name = $course_name_row["c_name"];

                        echo " <h3>" . $c_name . "</h3>"; //for displaying the course name 
                        ?>
                        <p>
                            <?php echo "<br>Aggregate percentage : $aggregate_percentage %<br><br>"; ?>
                        </p>
                        <p>
                            <?php echo "Percentage of each unit : <br>"; ?>
                        </p>
                        <?php
                        foreach ($unit_percentages as $unit_name => $unit_percentage) {
                            ?>
                            <p>
                                <?php echo " $unit_name: $unit_percentage %<br>"; ?>
                            </p>
                        <?php
                        }

                        // Query to retrieve the total number of units for the course
                        $sql_units = "SELECT COUNT(*) AS total_units FROM units WHERE c_id = '$course_id'";
                        $result_units = $conn->query($sql_units);
                        $row_units = $result_units->fetch_assoc();
                        $total_units = $row_units["total_units"];

                        // Query to retrieve the number of completed units by the student for the course
                        $sql_completed_units = "SELECT COUNT(*) AS completed_units FROM units JOIN performance ON units.unit_id = performance.unit_id WHERE units.c_id = '$course_id' AND performance.enrollment_no = '$enrollment_number'";
                        $result_completed_units = $conn->query($sql_completed_units);
                        $row_completed_units = $result_completed_units->fetch_assoc();
                        $completed_units = $row_completed_units["completed_units"];

                        // Calculate the overall completeness of the course as a percentage
                        $overall_completeness = round(($completed_units / $total_units) * 100, 2);
                        ?>

                        <div class="barperc">
                            <div class="bar">
                                <div style="width: <?php echo $overall_completeness ?>% ;" class="range html"></div>
                            </div>
                            <p>
                                <?php echo $overall_completeness ?>%
                            </p>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo "No courses found for enrollment number $enrollment_number";
            }
            $conn->close();
            ?>
        </section>
    </div>
</body>

<script src="script.js"></script>
<script>
if(window.history.replaceState)
{
window.history.replaceState(null,null,window.location.href);
}
</script>

</html>
