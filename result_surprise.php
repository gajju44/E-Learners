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
session_start();
error_reporting(0);
require_once('Config.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>result</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php

// Get user email from session
$useremail = $_SESSION['lemail'];

// Get course ID from URL parameter
$c_id = $_GET['c_id'];

// Get test ID from URL parameter
$test_id = $_GET['test_id'];

// Get user enrollment number
$select = mysqli_query($conn, "SELECT * FROM users WHERE email='$useremail' OR enrollment_no='$useremail'");
$selecten = mysqli_fetch_assoc($select);
$enroll = $selecten['enrollment_no'];

// Check if the user has already attempted the quiz
$sql1 = mysqli_query($conn, "SELECT enrollment_id FROM result WHERE enrollment_id=$enroll AND c_id=$c_id AND test_id='$test_id'");
if (mysqli_num_rows($sql1) > 0) {
    // User has already attempted the quiz, do not calculate and store the result again
    echo "<center><h3>You have already attempted this quiz.</h3></center>";
} else {
    // Calculate and store the result
    $questions = $_POST['quizcheck'];
    $correct = 0;
    $wrong = 0;
    $not_attempted = 0;

    // Count the total number of questions
    $count_query = "SELECT COUNT(*) as count FROM surprise_test WHERE c_id=$c_id AND test_id='$test_id'";
    $count_result = mysqli_query($conn, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_questions = $count_row['count'];

    foreach ($questions as $key => $value) {

        if ($value != null && $value != "") // Check if the answer is not null or empty
        {
            $query = "SELECT answer FROM surprise_test WHERE id=$key AND c_id=$c_id AND test_id='$test_id'";
            $result = mysqli_query($conn, $query);
            $query = "SELECT answer FROM surprise_test WHERE id=$key AND c_id=$c_id AND test_id='$test_id'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                if ($value == $row['answer']) {
                    $correct++;
                } else {
                    $wrong++;
                }
            }
        } else {
            $not_attempted++;
        }
    }
    $score = ($correct / $total_questions) * 100;


    $query =  mysqli_query($conn,"INSERT INTO result (enrollment_id,test_id, percentage,c_id) VALUES ('$enroll','$test_id', '$score', '$c_id')");
?>    

<div class="tablediv" style="position:absolute; right:40%;">

<?php
    if ($query) {
        echo "<h3 style='font-weight:bold; font-size:25px; margin-top:8px;'>Your Answers Are Submited</h3>";
        echo "<table align='center' class='table'  border='1' cellpadding='10'>
        <tbody>
                <tr> <th>Total_Questions
                            <td>$total_questions</td>
                </tr> 
                
                <tr>  <th>Correct answers</th>
                    <td>$correct</td> </tr>
                    <tr>  <th>Wrong answers</th>
                    <td>$wrong</td> </tr>
                    <tr> <th>Not Attempted questions</th>
                    <td>$not_attempted</td> </tr>
                    <tr> <th>Score</th>
                    <td>$score%</td>  </tr>
                    
                </tr>
                </tbody>
            </table>";
            ?>
             <button class="btn" onclick="window.history.back()">Back</button>
            <?php
    }
        
            
     else {
     echo "<center><h3>" . mysqli_error($conn) . "</h3></center>";

    }
?>
</div>

    <?php
}
?>
</body>
</html>

<style>

    .table {
  border-collapse: collapse;
  font-size: 15px;
  overflow: hidden;
  border-radius: 5px 5px 0 0;
  border: .1rem solid rgb(105 68 186 / 14%);
  box-shadow: 0 0.1rem 1.3rem rgb(0 0 0 / 20%);
}



.table th {
  background: rgb(25 25 25 / 90%);
  color: white;
  padding: 12px 25px;
}

.table td {
  padding: 12px 25px;
}

.table tbody tr {
  border-bottom: 1px solid #ddd;
}
.btn{
    margin-left: 9rem;
}


</style>
