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
    <title>Theory</title>
</head>

<body>
    <div class="full-page">

        <section class="theory">
            <?php
            $c_id = $_GET['c_id'];

            $unit_id = $_GET['unit_id'];
            $sql = "SELECT unit_name,unit_description, content FROM units WHERE unit_id = $unit_id";
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
                        <h3> <?php echo $row["unit_description"]; ?></h3>
                    </b>
                </div>

                <div class="th-paragraph">
                    <?php echo $row["content"]; ?>

                </div>
                <?php

            } ?>
        </section>
        <?php
        $useremail = $_SESSION['lemail'];

        $query = mysqli_query($conn, "select enrollment_no from users where  email='$useremail' || enrollment_no='$useremail'");
        //This query is for getting the respective user's data from database.
        
        $string = mysqli_fetch_assoc($query); //function  use to store data which is in '$query' into an  associative array
        $enrollment_no = $string['enrollment_no']; //implode function is use to join all elements into a string         
        
        // Check if the user has already attempted the quiz
        $sql = "SELECT * FROM performance WHERE enrollment_no='$enrollment_no' AND c_id='$c_id' AND unit_id='$unit_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            ?>
                    <div class="php_msg">
                       <h2> you have already attempted this quiz </h2>
                    </div>
                    <?php
        } else {

            ?>
            <section class="questions">
                <?php
                $sql1 = "SELECT question, id, option1, option2, option3, option4 FROM mcq_questions WHERE unit_id = $unit_id";
                $result1 = $conn->query($sql1);
                if (mysqli_num_rows($result1) > 0) { ?>
                    <form action="result.php?c_id=<?php echo $c_id ?>&unit_id=<?php echo $unit_id ?>" method="POST">

                        <?php while ($row = mysqli_fetch_assoc($result1)) { ?>

                            <ul class='quiz'>
                                <div class='box'>
                                    <h4>
                                        <?php echo $row['question'] ?>
                                    </h4>
                                    <ul class='choices'>
                                        <label>
                                            <input type='radio' name='quizcheck[<?php echo $row['id'] ?>]' value='1' required>

                                            <?php echo $row['option1'] ?>
                                        </label>
                                    </ul>
                                    <ul class='choices'>
                                        <label>
                                            <input type='radio' name='quizcheck[<?php echo $row['id'] ?>]' value='2' required>
                                            <?php echo $row['option2'] ?>
                                        </label>
                                    </ul>
                                    <ul class='choices'>
                                        <label>
                                            <input type='radio' name='quizcheck[<?php echo $row['id'] ?>]' value='3' required>
                                            <?php echo $row['option3'] ?>
                                        </label>
                                    </ul>
                                    <ul class='choices'>
                                        <label>
                                            <input type='radio' name='quizcheck[<?php echo $row['id'] ?>]' value='4' required>

                                            <?php echo $row['option4'] ?>
                                        </label>
                                    </ul>
                                </div>
                            </ul>
                        <?php } ?>
                        <div class="clbtn">

                            <input type="submit" class="btn" name="submit" value="Submit">
                        </div>

                    </form>
                    <?php
                } else {
                    ?>
                    <div class="php_msg">
                      <h2>  No questions </h2>
                    </div>
                    <?php
                }
                ?>
            </section>
            <?php
        }
        ?>
</body>
<script src="script.js"></script>

<script>
if(window.history.replaceState)
{
window.history.replaceState(null,null,window.location.href);
}
</script>

</html>