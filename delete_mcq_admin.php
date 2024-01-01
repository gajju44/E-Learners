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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Unit</title>
    <link rel="stylesheet" href="style.css">
      <!--faicon code start -->
 <link rel="icon" type="image/svg+xml" href="favicon.svg">
<link rel="icon" type="image/png" href="Phoenix.png">

</head>

<body>
    <header>
        <h1 class="logo">E-<span>Learners</span></h1>
        <div id="menu"></div>
         <nav class="navbar">
                <a href="admin_dashboard.php">E-learners Site</a>
                <a href="logout.php">logout</a>
            </nav>
    </header>

<section class="delete_unit_admin" id="delete_unit_admin">
        <div class="row">
            <form action="" method="post">
                <h2>Deletion Section</h2>
                <div>
                    <label for="course">Course:</label>
                    <select id="mcqcourse" name="mcqcourse">
                        <option value="" selected disabled hidden>Select a course</option>
                        <?php

                        // retrieve data from the courses table
                        $course = $conn->query("SELECT c_id, c_name FROM courses");
                       

                        while ($row = $course->fetch_assoc()) {
                            ?>
                            <option value='<?php echo $row["c_id"]; ?>'><?php echo $row["c_name"]; ?></option>
                     <?php }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="unit">Units:</label>
                    <select id="mcqunit" name="mcqunit">
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
                        </div>

                        <div>
                    <label for="mcq">MCQ:</label>
                    <select id="mcq" name="mcq" required>
    <option value="" selected disabled hidden>Select a Question</option>
    <?php
    // Retrieve data from the mcq_questions table
    $sql = "SELECT *FROM mcq_questions";
    $result = $conn->query($sql);

    // Loop through the rows and display each question as an option in the dropdown
    while ($row = $result->fetch_assoc()) {
        ?>
        <option value='<?php echo $row["id"]; ?>' data-course='<?php echo $row["c_id"]; ?>' data-unit='<?php echo $row["unit_id"]; ?>'><?php echo $row["question"]; ?></option>
    <?php } ?>
</select>
                   

                   <script>
    // Get references to the three select dropdowns
    const courseSelect = document.getElementById('mcqcourse');
    const unitSelect = document.getElementById('mcqunit');
    const mcqSelect = document.getElementById('mcq');

    // Listen to the change event on the unit select dropdown
    unitSelect.addEventListener('change', () => {
        // Get the selected unit ID and course ID
        const selectedUnitId = unitSelect.value;
        const selectedCourseId = unitSelect.options[unitSelect.selectedIndex].dataset.course;

        // If no unit is selected, show all mcq questions
        if (!selectedUnitId) {
            Array.from(mcqSelect.options).forEach(option => option.style.display = 'block');
            return;
        }

        // Hide all mcq questions that do not belong to the selected unit and course
        Array.from(mcqSelect.options).forEach(option => {
            if (option.dataset.course === selectedCourseId && option.dataset.unit === selectedUnitId) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });

        // Show the "Select a question" option if it was hidden
        const selectOption = mcqSelect.querySelector('option[value=""]');
        if (selectOption) {
            selectOption.style.display = 'block';
        }
    });

    // Listen to the change event on the course select dropdown
    courseSelect.addEventListener('change', () => {
        // If no course is selected, show all units and mcq questions
        if (!courseSelect.value) {
            Array.from(unitSelect.options).forEach(option => option.style.display = 'block');
            Array.from(mcqSelect.options).forEach(option => option.style.display = 'block');
            return;
        }

        // Hide all units that do not belong to the selected course
        Array.from(unitSelect.options).forEach(option => {
            if (option.dataset.course === courseSelect.value) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });

        // Trigger the change event on the unit select dropdown to filter the mcq questions
        const event = new Event('change');
        unitSelect.dispatchEvent(event);
    });
</script>

                </div>
                <input type="submit" class="btn" value="Delete Unit" name="submit_mcq">
            </form>
 
                    
                    </div>
    </section>
    </body>
<script src="script.js"></script>
<script>
if(window.history.replaceState)
{
window.history.replaceState(null,null,window.location.href);
}
</script>
</html>
    <?php //delete only mcq
if (isset($_POST['submit_mcq'])) {
    // Get the selected value from the combo box
    $selectedCourse = $_POST["mcqcourse"];
    $selectedUnit = $_POST["mcqunit"];
    $selectedmcq = $_POST["mcq"];


    // create a SQL query to delete the mcq 
    $sql = "SELECT * FROM mcq_questions WHERE c_id = '$selectedCourse' AND unit_id = '$selectedUnit' AND id = '$selectedmcq'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // row exists, proceed with DELETE query
        $sql2 = "DELETE FROM mcq_questions WHERE c_id = '$selectedCourse' AND unit_id = '$selectedUnit' AND id = '$selectedmcq'";
        if ($conn->query($sql2) === TRUE) {
            echo '<script>alert("Unit and their mcq deleted successfully...!!!") </script>';
        } else {
            echo "Error in deleting mcq";
        }
    } else {
        // row does not exist, display error message
        echo "<h3>Error: Please select the valid course unit or mcq</h3>";
    }
}



?>

</body>

<style>
.row {
    
    margin-top: 20rem;
}
    </style>