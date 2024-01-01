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

<?php require_once('Config.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete MCQ</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <header>
        <h1 class="logo">E-<span>Learners</span></h1>
        <div id="menu"></div>
        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#course">course</a>
            <a href="#about">about</a>
            <a href="dashboard.html">Dashboard</a>
        </nav>
    </header>

    <!-- ============================= add_content section starts ==================================== -->
    <section class="add_content" id="add_content">
        <div class="row">
            <form action="" method="post">
                <h2>MCQ Deletion Section</h2>
                <div>
                    <label for="course">Course:</label>
                    <select id="course" name="course" required>
                        <option value="" selected disabled hidden>Select a course</option>
                        <?php

                        // retrieve data from the courses table
                        $sql = "SELECT c_id, c_name FROM courses";
                        $result = $conn->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            $option_value = $row["c_id"] . ":" . $row["c_name"];
                            echo "<option value='" . $option_value . "'>" . $option_value . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="units">Units:</label>
                    <select id="units" name="units" required>
                        <option value="" selected disabled hidden>Select a unit</option>
                        <?php

                        // retrieve data from the courses table
                        $sql = "SELECT unit_id, unit_name FROM units";
                        $result = $conn->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            $option_value = $row["unit_id"] . ":" . $row["unit_name"];
                            echo "<option value='" . $option_value . "'>" . $option_value . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="mcq">MCQ:</label>
                    <select id="mcq" name="mcq" required>
                        <option value="" selected disabled hidden>Select a Question</option>
                        <?php
                        // Retrieve data from the mcq_questions table
                        $sql = "SELECT question FROM mcq_questions";
                        $result = $conn->query($sql);

                        // Check if any rows were returned
                        if ($result->num_rows > 0) {
                            // Loop through the rows and display each question as an option in the dropdown
                            while ($row = $result->fetch_assoc()) {
                                $option_value = $row["question"];
                                echo "<option value='" . $option_value . "'>" . $option_value . "</option>";
                            }
                        } else {
                            // If no rows were returned, display a message indicating that there are no questions
                            echo "<option value=''>No questions found</option>";
                        }
                        ?>
                    </select>
                </div>


                <input type="submit" class="btn" value="Delete Mcq" name="submit">
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

<?php
if (isset($_POST['submit'])) {
    // Get the selected value from the combo box
    $selectedCourse = $_POST["course"];
    $selectedUnit = $_POST["units"];
    $selectedmcq = $_POST["mcq"];



    // Separate the number and name using the colon delimiter
    $parts_c = explode(":", $selectedCourse);
    $number_c = $parts_c[0];
    $name_c = $parts_c[1];

    $parts_u = explode(":", $selectedUnit);
    $number_u = $parts_u[0];
    $name_u = $parts_u[1];

    // create a SQL query to delete the mcq 
    $sql = "SELECT * FROM mcq_questions WHERE c_id = '$number_c' AND unit_id = '$number_u' AND question = '$selectedmcq'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // row exists, proceed with DELETE query
        $sql2 = "DELETE FROM mcq_questions WHERE c_id = '$number_c' AND unit_id = '$number_u' AND question = '$selectedmcq'";
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