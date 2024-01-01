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
error_reporting(0);
session_start();
$useremail = $_SESSION['lemail'];
$c_id = $_GET['c_id'];
$sql_time = mysqli_query($conn, "SELECT Time1 FROM surprise_test WHERE c_id = $c_id AND test_id = (SELECT MAX(test_id) FROM surprise_test WHERE c_id = $c_id)limit 1");
$time = mysqli_fetch_assoc($sql_time)['Time1'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />

    <script>
        var timeLeft = <?php echo $time; ?>;

        function timeout() {
            var hours = Math.floor(timeLeft / 3600);
            var minute = Math.floor((timeLeft - (hours * 60 * 60)) / 60);
            var second = timeLeft % 60;
            var hrs = checktime(hours);
            var mint = checktime(minute);
            var sec = checktime(second);

            if (timeLeft <= 0) {
                clearTimeout(tm);
                document.getElementById("khatam").submit();
            } else {
                document.getElementById("time").innerHTML = hrs + ":" + mint + ":" + sec;
            }
            if (timeLeft <= 50) {
                document.getElementById("fast").classList.add("blink");
            } else {
                document.getElementById("fast").classList.remove("blink");
            }


            timeLeft--;
            var tm = setTimeout(function () { timeout() }, 1000);
        }

        function checktime(num) {
            if (num < 0) {
                num = "0" + num;
            }
            return num;
        }
    </script>


    <title>Theory</title>
</head>

<body onload="timeout()">



    <div class="full-page">

        <section class="theory">
            <?php


            $sql = mysqli_query($conn, "SELECT c_name FROM courses WHERE c_id = $c_id");


            if ($sql === false) {
                die("Query failed: ");
            }

            if ($sql->num_rows > 0) {
                $row = mysqli_fetch_assoc($sql);

                ?>
                <div class="heading">
                    <h1>
                        <?php echo $row["c_name"]; ?>
                    </h1>
                </div>
                <div class="sub-heading">
                    <b>
                        <h3> Surprise Test</h3>
                    </b>
                </div>

                <?php
            }
            ?>
        </section>
        <?php
        $select = mysqli_query($conn, "SELECT enrollment_no FROM users WHERE email='$useremail' OR enrollment_no='$useremail'");
        $selecten = mysqli_fetch_array($select);
        $enroll = $selecten['enrollment_no'];
        $get_testid = mysqli_query($conn, "SELECT test_id FROM surprise_test WHERE c_id = $c_id AND test_id = (SELECT MAX(test_id) FROM surprise_test WHERE c_id = $c_id) limit 1");
        $test_row = mysqli_fetch_assoc($get_testid);
        $test_row1 = $test_row['test_id'];
        $sql1 = mysqli_query($conn, "SELECT enrollment_id FROM result WHERE enrollment_id=$enroll AND c_id = $c_id AND test_id='$test_row1'");


        if (mysqli_num_rows($sql1) > 0) {
            // User has already attempted the quiz, do not display the questions section
            echo "<h1>You have already attempted this quiz.</h1>";
        } else {

            ?>
            <h2 class="timer" id="fast"> TIME REMAINING:&ensp;<div id="time" style="float:right">Timeout</div>
            </h2>

            <section class="questions">


                <?php
                $sql2 = mysqli_query($conn, "SELECT question, id, option1, option2, option3, option4, test_id, Time1 FROM surprise_test WHERE c_id = $c_id AND test_id = (SELECT MAX(test_id) FROM surprise_test WHERE c_id = $c_id) ORDER BY id ASC LIMIT 25");
                $rows = array();
                while ($row1 = mysqli_fetch_assoc($sql2)) {
                    $rows[] = $row1;
                }

                // Display questions
                if (count($rows) > 0) {
                    ?>
                    <form id="khatam" method="POST"
                        action="https://gpnagpur.tk/result_surprise.php?c_id=<?php echo $c_id ?>&test_id=<?php echo $rows[0]['test_id'] ?>">
                        <?php foreach ($rows as $row1) { ?>
                            <ul class='quiz'>
                                <div class='box'>
                                    <h4>
                                        <?php echo $row1['question'] ?>
                                    </h4>
                                    <ul class='choices'>
                                        <label>
                                            <input type='radio' name='quizcheck[<?php echo $row1['id'] ?>]' value='1' required>
                                        </label>
                                        <?php echo $row1['option1'] ?>
                                    </ul>
                                    <ul class='choices'>
                                        <label>
                                            <input type='radio' name='quizcheck[<?php echo $row1['id'] ?>]' value='2' required>
                                        </label>
                                        <?php echo $row1['option2'] ?>
                                    </ul>
                                    <ul class='choices'>
                                        <label>
                                            <input type='radio' name='quizcheck[<?php echo $row1['id'] ?>]' value='3' required>
                                        </label>
                                        <?php echo $row1['option3'] ?>
                                    </ul>
                                    <ul class='choices'>
                                        <label>
                                            <input type='radio' name='quizcheck[<?php echo $row1['id'] ?>]' value='4' required>
                                        </label>
                                        <?php echo $row1['option4'] ?>
                                    </ul>
                                </div>
                            </ul>
                        <?php } ?>
                        <div class="clbtn">
                            <input type="submit" class="btn" value="Submit">
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


</html>

<style>
    .timer.blink {
        animation: blink 1s linear infinite;
        background-color: red;
        color: white;
    }

    @keyframes blink {
        50% {
            opacity: 0;
        }
    }

    .timer {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        padding: 10px;
        background-color: black;
        border-radius: 10px;
        margin-bottom: 20px;
        top: 20px;
        right: 20px;
        font-size: 20px;
        color: white;
        position: fixed;
    }
</style>