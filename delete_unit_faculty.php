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
    <title>Delete Unit</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
<header>
            <h1 class="logo">E-<span>Learners FACULTY
                </span></h1>
            <div id="menu" class="fas fa-bars"></div>
             <nav class="navbar">
            <a href="facultydashboard.php#home">home</a>
            <a href="logout.php">Logout</a>
             <a onclick="window.history.back()">Back</a>
        </nav>
        </header>

    <!-- ============================= delete_content section starts ==================================== -->
    <section class="delete_unit_admin" id="delete_unit_admin">
        <div class="row">
            <form action="" method="post">
                <h2>Deletion Section</h2>
                <div>
                    <label for="course">Course:</label>
                    <select id="delcourse" name="delcourse">
                        <option value="" selected disabled hidden>Select a course</option>
                        <?php

                        // retrieve data from the courses table
                        $course = $conn->query("SELECT c_id, c_name FROM courses where f_id=$fid");
                       

                        while ($row = $course->fetch_assoc()) {
                            ?>
                            <option value='<?php echo $row["c_id"]; ?>'><?php echo $row["c_name"]; ?></option>
                     <?php }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="unit">Units:</label>
                    <select id="delunit" name="delunit">
                        <option value="" selected disabled hidden>Select a unit</option>
                        <?php

                        // retrieve data from the courses table
                        $units = $conn->query("SELECT * FROM units");
                       
                         
                        while ($row1 = $units->fetch_assoc()) {
                            ?>
                            <option value='<?php echo $row1['unit_id']. "' data-course='" . $row1['c_id']  ; ?>'><?php echo $row1["unit_name"]; ?></option>
                       <?php }
                        ?>
                    </select>
                   

                    <script>
                            // Get references to the two select dropdowns
const courseSelect = document.getElementById('delcourse');
const unitSelect = document.getElementById('delunit');

// Listen to the change event on the course select dropdown
courseSelect.addEventListener('change', () => {
    // Get the selected course ID
    const selectedCourseId = courseSelect.value;

    // If no course is selected, show all units
    if (!selectedCourseId) {
        Array.from(unitSelect.options).forEach(option => option.style.display = 'block');
        return;
    }
    const units = Array.from(unitSelect.options).filter(option => option.dataset.course === selectedCourseId);
    if (units.length > 0) {
    // Hide all units that do not belong to the selected course
    Array.from(unitSelect.options).forEach(option => {
        if (option.dataset.course !== selectedCourseId) {
            option.style.display = 'none';
        } else {
            option.style.display = 'block';
        }
    });
}
else { // Otherwise, hide all units and show the "no units" message
        Array.from(unitSelect.options).forEach(option => option.style.display = 'none');
        const noUnitsOption = document.createElement('option');
        noUnitsOption.value = '';
        noUnitsOption.disabled = true;
        noUnitsOption.selected = true;
        noUnitsOption.textContent = 'No units found';
        unitSelect.appendChild(noUnitsOption);
    }
});

                        </script>

                </div>
                <input type="submit" class="btn" value="Delete Unit" name="submit_unit">
            </form>
        </div>
    </section>
       
</body>

        <?php //delete unit with mcq
if (isset($_POST['submit_unit'])) {
    // Get the selected value from the combo box
    $selectedCourse = $_POST["delcourse"];
    $selectedUnit = $_POST["delunit"];


    // create a SQL query to delete the performance associated with unit 
    $sql3 = mysqli_query($conn,"DELETE FROM performance WHERE c_id = '$selectedCourse' AND unit_id = '$selectedUnit'");

    // create a SQL query to delete the mcq 
    $sql2 = mysqli_query($conn,"DELETE FROM mcq_questions WHERE c_id = '$selectedCourse' AND unit_id = '$selectedUnit'");

    // create a SQL query to delete the unit
    $sql1 = mysqli_query($conn,"DELETE FROM units WHERE c_id = '$selectedCourse' AND unit_id = '$selectedUnit'");

    // execute the query
    if ($sql1 || $sql2 || $sql3) {
        echo '<script>alert("Unit and their mcq deleted successfully...!!!") </script>';
    } else {
        echo "Error deleting unit: ";
    }
}
?>
