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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Mcq</title>
</head>

<body>
    <div class="full-page">

        <section class="theory">
            <?php
            $c_id = 1;

            $unit_id = 1;
            $sql = "SELECT `unit_name`, `url` FROM units WHERE `unit_id` = $unit_id";
            $result = $conn->query($sql);

            if ($result === false) {
                die("Query failed: ");
            }

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

            ?>
                <div class="heading">
                    <h1>
                        <?php echo $row["unit_name"]; ?>
                    </h1>
                </div>
                <div class="sub-heading">
                    <b>
                        <h3> Lorem ipsum dolor sit amet consectetur.</h3>
                    </b>
                </div>

                <div class="th-paragraph">
                    <iframe src="<?php echo $row['url']; ?>" width="100%" id="contentFrame" scrolling="no"></iframe>
                </div>
            <?php

            } ?>
        </section>
        <?php
        // Check if the user has already attempted the quiz
        $sql = "SELECT * FROM performance WHERE enrollment_no='2013014' AND c_id='$c_id' AND unit_id='$unit_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "You have already attempted this quiz.";
        } else {


            // User has not attempted the quiz, display the questions section
        ?>

            <section class="questions">
                <?php
                $sql1 = "SELECT `question`,`id`, `option1`,`option2`,`option3`,`option4` FROM mcq_questions WHERE `unit_id` = $unit_id";
                $result1 = $conn->query($sql1);
                if (mysqli_num_rows($result1) > 0) { ?>
                    <div id="timer"></div>
                    <form id="quiz-form" action="result.php?c_id=<?php echo $c_id ?>&unit_id=<?php echo $unit_id ?>" method="POST">

                        <?php while ($row = mysqli_fetch_assoc($result1)) { ?>

                            <ul class='quiz'>
                                <div class='box'>
                                    <h4>
                                        <?php echo $row['question'] ?>
                                    </h4>
                                    <ul class='choices'>
                                        <label>
                                            <input type='radio' name='quizcheck[<?php echo $row['id'] ?>]' value='1' required>
                                        </label>
                                        <?php echo $row['option1'] ?>
                                    </ul>
                                    <ul class='choices'>
                                        <label>
                                            <input type='radio' name='quizcheck[<?php echo $row['id'] ?>]' value='2' required>
                                        </label>
                                        <?php echo $row['option2'] ?>
                                    </ul>
                                    <ul class='choices'>
                                        <label>
                                            <input type='radio' name='quizcheck[<?php echo $row['id'] ?>]' value='3' required>
                                        </label>
                                        <?php echo $row['option3'] ?>
                                    </ul>
                                    <ul class='choices'>
                                        <label>
                                            <input type='radio' name='quizcheck[<?php echo $row['id'] ?>]' value='4' required>
                                        </label>
                                        <?php echo $row['option4'] ?>
                                    </ul>
                                </div>
                            </ul>
                        <?php } ?>
                        <div class="clbtn">

                            <input type="submit" class="btn" name="submit" value="Submit" id="submit-btn">
                        </div>

                    </form>
                <?php
                } else {
                    echo "No questions";
                }
                ?>
            </section>
        <?php
        }
        ?>
</body>
<script src="script.js"></script>
<script>
    window.addEventListener("load", function() {
        var iframe = document.getElementById("contentFrame");
        iframe.onload = function() {
            iframe.style.height = iframe.contentWindow.document.body.scrollHeight + "px";
        };
        iframe.style.height = iframe.contentWindow.document.body.scrollHeight + "px";
    });
    </script>
        <!-- JavaScript code -->

<script>
    // Set the time limit in seconds
    var timeLimit = 7; // 30 minutes

    // Get the timer element
    var timerElement = document.getElementById("timer");

    // Calculate the end time
    var endTime = new Date().getTime() + timeLimit * 1000;

    // Update the timer every second
    var timerInterval = setInterval(function() {
        // Calculate the remaining time
        var remainingTime = Math.max(0, endTime - new Date().getTime());

        // Calculate the minutes and seconds
        var minutes = Math.floor(remainingTime / 1000 / 60);
        var seconds = Math.floor(remainingTime / 1000 % 60);

        // Display the remaining time in the timer element
        timerElement.innerHTML = "Time remaining: " + minutes + "m " + seconds + "s";

        // If the time has run out, submit the quiz form
        if (remainingTime <= 0) {
            clearInterval(timerInterval);
            document.getElementById("quiz-form").submit();
        }
    }, 1000);

    // Submit the quiz form when the Submit button is clicked
    document.getElementById("submit-btn").addEventListener("click", function(event) {
        // Prevent the default form submission
        event.preventDefault();

        // Clear the timer interval
        clearInterval(timerInterval);

        // Submit the form
        document.getElementById("quiz-form").submit();
    });
</script>