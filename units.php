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

<?php require_once('Config.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Units</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <header>

        <h1 class="logo">E-<span>Learners</span></h1>

        <div id="menu"></div>

         <nav class="navbar">
                <a href="index_after_login.php#home">home</a>
                <a href="index_after_login.php#course">course</a>
                <a href="index_after_login.php#about">about</a>
                <a href="dashboardStudent.php">Scorecard</a>
                <a onclick="window.history.back()">Back</a>

            </nav>

    </header>

    <!--============================unit section ======================= -->

    <div class="unit-container">

        <?php

        $c_id = $_GET['c_id'];

        $sql = "SELECT unit_id, unit_name, unit_description FROM units WHERE c_id = $c_id ";

        // Execute the query and store the result
        $result = $conn->query($sql);
        ?>
        <?php //for printing the name of the course
        $sql1 = "SELECT c_name FROM courses WHERE c_id= $c_id";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();
        $c_name = $row1["c_name"];
        ?>

        <h1 class="heading">
            <?php echo $c_name ?>
        </h1>

        <section class="unit">

            <div class="box-container">
                <?php
                // Check if there is at least one row returned
                if ($result->num_rows > 0) {
                    // Loop through each row and output the HTML block with dynamic values
                    while ($row = $result->fetch_assoc()) {
                        $unit_id = $row["unit_id"];
                        $unit_name = $row["unit_name"];
                        $unit_description = $row["unit_description"];

                        ?>
                        <div class="box"
                            onclick="window.location.href='https://gpnagpur.tk/theory1.php?c_id=<?php echo $c_id ?>&unit_id=<?php echo $unit_id ?>';">
                            <div class="content">
                                <h1>
                                    <?php echo $unit_name ?>
                                </h1>
                                <p>
                                    <?php echo $unit_description ?>
                                </p>

                            </div>
                        </div>


                    <?php }
                } else {
                    ?>
                    <div class="php_msg">
                    <h2>No Courses Found</h2>
                </div>
                    <?php
                }

                // Close the database connection
                $conn->close();
                ?>

            </div>

        </section>

    </div>



    <script src="script.js"></script>

</body>

</html>