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
require_once('Config.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Details</title>
    <link rel="stylesheet" href="style.css">
      <!--faicon code start -->
 <link rel="icon" type="image/svg+xml" href="favicon.svg">
<link rel="icon" type="image/png" href="Phoenix.png">
</head>

<body>

    <div class="admin-body">

    <header>
            <h1 class="logo">E-<span>Learners ADMIN</span></h1>
            <div id="menu" class="fas fa-bars"></div>
            <nav class="navbar">
                <a href="admin_dashboard.php">E-learners Site</a>
                <a href="logout.php">logout</a>
            </nav>
        </header>

        <section class="faculty_details">
            <div class="faculty_table">
                <div class="faculty-assign-table">
                    <h1>Faculty assigned to Courses </h1>
            
                        <table class="table">

                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Name</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                // Select course name and faculty name from the "courses" and "faculty" tables
                                $result = $conn->query("SELECT c.c_name, f.f_name FROM courses c INNER JOIN faculty f ON c.f_id = f.f_id");

                                // Display each course name and faculty name in the next column
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td>
                                            <?php echo $row["c_name"] ?>
                                        </td>
                                        <td>
                                            <?php
                                            // Display the faculty name for the current course
                                            echo $row["f_name"];
                                            ?>
                                        </td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>


                        </table>
                        
                        <h3>Faculty assigned to Courses </h3>

                    <form class="f2"method="POST">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Select course name from the "courses" table
                                $result = $conn->query("SELECT c_name FROM courses");

                                // Display a dropdown list of course names in the first column
                                echo '<tr><td><select name="course">';
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["c_name"] . '">' . $row["c_name"] . '</option>';
                                }
                                echo '</select></td>';

                                // Select faculty name and ID from the "faculty" table
                                $result = $conn->query("SELECT f_id, f_name FROM faculty");

                                // Display a dropdown list of faculty names with IDs in the second column
                                echo '<td><select name="faculty">';
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["f_id"] . ':' . $row["f_name"] . '">' . $row["f_name"] . '</option>';
                                }
                                echo '</select></td></tr>';
                                ?>
                            </tbody>
                        </table>
                        <input type="submit" class="btn-per" name="submit" value="add details">
                    </form>

                </div>
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

<?php
// If the form is submitted, get the selected course and faculty values
if (isset($_POST['submit'])) {
    $course_name = $_POST['course'];

    $faculty = explode(':', $_POST['faculty']);
    $faculty_id = $faculty[0];
    $faculty_name = $faculty[1];

    // Prepare the SQL query to update the f_id column of the courses table
    $sql = "UPDATE courses SET f_id = $faculty_id WHERE c_name = '$course_name'";

    // Execute the query and check if it was successful
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: ";
    }

}
?>