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
function alertd()
{
    echo "<script>alert('done');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Add content</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <header>
        <h1 class="logo">E-<span>Learners</span></h1>
        <div id="menu"></div>
         <nav class="navbar">
            <a href="facultydashboard.php#home">home</a>

            <a href="logout.php">Logout</a>
                        <a onclick="window.history.back()">Back</a>
        </nav>
    </header>

    <!-- ============================= add_question section starts ==================================== -->
    <section class="add_question" id="add_question">
        <div class="row1">
            <div class="form-classaddque">
                <form method='post' action=''>
                    <input oninput="this.value=this.value.replace(/[^0-9+]/g,'');" type="number" class="enternomcq"
                        name="num" placeholder="Enter mcq number">

                    <input type="submit" class="btn-per" value="Enter" name="nsubmit">
                </form>
            </div>
            <form method="post">
                <h2>Question Section</h2>
                <div class="label1" style="margin-bottom: 0.5rem;">
                    <label for="course">Course:</label>
                    <select id="course" name="course">
                        <option value="" selected disabled hidden>Select a unit</option>
                        <?php
                        session_start();
                        $fid = $_SESSION['faculty'];
                        echo $fid;
                        $course = $conn->query("SELECT c_id, c_name FROM courses where f_id = '$fid'");
                        while ($row = $course->fetch_assoc()) {
                            ?>
                            <option value='<?php echo $row["c_id"]; ?>'><?php echo $row["c_name"]; ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
                <div class="label2">
                    <label for="unit">Unit:</label>
                    <select id="unit" name="unit">
                        <option value="" selected disabled hidden>Select a unit</option>
                        <?php

                        $units = $conn->query("SELECT * FROM units ");
                        while ($row1 = $units->fetch_assoc()) {
                            ?>
                            <option value='<?php echo $row1['unit_id'] . "' data-course='" . $row1['c_id']; ?>'><?php echo $row1["unit_name"]; ?></option>
                        <?php }
                        ?>

                    </select>
                    <script>
                        // Get references to the two select dropdowns
                        const courseSelect = document.getElementById('course');
                        const unitSelect = document.getElementById('unit');

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
                <div id="questions_container">
                    <div class="question_container">


                        <?php
                        $number_of_ques = 1;
                        if (isset($_POST['nsubmit'])) {

                            $number_of_ques = $_POST['num'];
                        }
                        for ($i = 1; $i <= $number_of_ques; $i++) { ?>
                            <input type="text" placeholder="Enter Question No." <?php echo $i; ?>
                                id="question<?php echo $i; ?>" name="question[]" class="question" required=true>
                            <input type="text" placeholder="Option 1" id="option1" name="option1[]" class="option"
                                required=true>
                            <input type="text" placeholder="Option 2" id="option2" name="option2[]" class="option"
                                required=true>
                            <input type="text" placeholder="Option 3" id="option3" name="option3[]" class="option"
                                required=true>
                            <input type="text" placeholder="Option 4" id="option4" name="option4[]" class="option"
                                required=true>
                            <select id="answer<?php echo $i; ?>" name="answer[]" class="option" required>
                                <option value="" selected disabled hidden>Select Answer</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                                <option value="4">Option 4</option>
                            </select>
                            <div class="border-bottom1"></div>
                            <?php
                        } ?>
                    </div>
                </div>
                <input type="submit" class="btn" value="Final Submit" name="submit">
            </form>
        </div>
    </section>
</body>

<?php
require_once('Config.php');
if (isset($_POST["submit"])) {

    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $answer = $_POST['answer'];
    $c_id = $_POST['course'];
    $unit_id = $_POST['unit'];


    for ($i = 0; $i < count($question); $i++) {
        $q = $question[$i];
        $o1 = $option1[$i];
        $o2 = $option2[$i];
        $o3 = $option3[$i];
        $o4 = $option4[$i];
        $a = $answer[$i];

        // Insert into database
        $sql = "INSERT INTO mcq_questions (question, option1, option2, option3, option4, answer, c_id, unit_id) VALUES ('$q', '$o1', '$o2', '$o3', '$o4', '$a', '$c_id', '$unit_id')";
        $conn->query($sql);
    }
        if ($sql == true) {
            echo "<script>alert('questions added successfully');</script>";
        } else {
            echo "<script>alert('server not available');</script>";
        }
    
}
?>
