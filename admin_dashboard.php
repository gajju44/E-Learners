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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

</head>

<body>

    <div class="admin-body">

        <header>
            <h1 class="logo">E-<span>Learners ADMIN</span></h1>
            <div id="menu" class="fas fa-bars"></div>
            <nav class="navbar">
                <a href="indexd.php">E-learners Site</a>
                <a href="logout.php">logout</a>
            </nav>
        </header>

        <!-- ======================== id -card ================= -->
        <section>
            <h2 class="admin-h2">Admin-options</h2>
        </section>
        <section class="admin-options">
            <div class="box" onclick="window.location.href='add_faculty.php';">
                <h3>Add Faculty</h3>
            </div>
            <div class="box" onclick="window.location.href='add_content.php';">
                <h3>Add Content</h3>
            </div>

            <div class="box" onclick="window.location.href='add_question_admin.php';">
                <h3>Add Questions</h3>
            </div>

            <div class="box" onclick="window.location.href='faculty_details.php';">
                <h3>Faculty Details</h3>
            </div>

            <div class="box" onclick="window.location.href='delete_unit_admin.php';">
                <h3>Delete Unit</h3>
            </div>

            <div class="box" onclick="window.location.href='delete_mcq_admin.php';">
                <h3>Delete MCQ</h3>
            </div>
        </section>

        <!-- ===========================performance/stats ===========================-->

        <section class="performance-adminside">
            <div class="performance_table">
                <div class="course-table">
                    <h1>Student's Performance</h1>
                    <form method="post" action="">
                        <select name="year" id="year">
                            <option value="1">1st year</option>
                            <option value="2">2nd year</option>
                            <option value="3">3rd year</option>
                        </select>
                        <button class="btn-per" type="submit">See Performance</button>
                    </form>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $year = $_POST['year'];
                        echo "<h2>Selected year: " . $year . "</h2>";

                        // Select the courses for the selected year
                        $sql = "SELECT c_id, c_name FROM courses WHERE years = '$year'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            echo "<table class='table'>";
                            echo "<thead><tr><th>Enroll No.</th><th>Name</th>";

                            // Display the course names as table headers
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<th>" . $row["c_name"] . "</th>";
                            }
                            echo "</tr></thead><tbody>";

                            // Select the users for the selected year
                            $sql2 = "SELECT enrollment_no, name FROM users WHERE years = '$year'";
                            $result_user = mysqli_query($conn, $sql2);

                            if (mysqli_num_rows($result_user) > 0) {
                                while ($row_user = mysqli_fetch_assoc($result_user)) {
                                    $total_marks = 0;
                                    echo "<tr>";
                                    echo "<td>" . $row_user["enrollment_no"] . "</td>";
                                    echo "<td>" . $row_user["name"] . "</td>";

                                    // Loop through each course and display the percentage for the user
                                    mysqli_data_seek($result, 0); // Reset the pointer to the beginning
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $c_id = $row["c_id"];
                                        $sql3 = "SELECT percentage FROM performance WHERE enrollment_no = '" . $row_user["enrollment_no"] . "' AND c_id = '$c_id'";
                                        $result_percentage = mysqli_query($conn, $sql3);

                                        if (mysqli_num_rows($result_percentage) > 0) {
                                            $row_percentage = mysqli_fetch_assoc($result_percentage);
                                            $percentage = $row_percentage["percentage"];
                                            $total_marks += $percentage;
                                            echo "<td>" . $percentage . "%</td>";
                                        } else {
                                            echo "<td>-</td>";
                                        }
                                    }
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='10'>No users found</td></tr>";
                            }

                            echo "</tbody></table>";
                        } else {
                            echo "<p>No results found for the selected year.</p>";
                        }
                    }
                    ?>
                </div>
            </div>
        </section>

    </div>
</body>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<script src="script.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js">
</script>
<script>
    AOS.init();
</script>
<script>
    AOS.init({
        offset: 150,
        duration: 1000
    });
</script>

</html>