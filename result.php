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
    <title>result</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php

// process user's answers
if (isset($_POST['submit'])) {
    $total_questions = 0;
    $score = 0;
    foreach ($_POST['quizcheck'] as $key => $value) {
        $sql = "SELECT * FROM mcq_questions WHERE id = $key";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $total_questions++;
        if ($row['answer'] == $value) {
            $score++;
        }
    }
    $percentage = ($score / $total_questions) * 100;
    // store percentage in the performance table
    $c_id = $_GET['c_id']; // assuming there's a hidden input field for c_id in the form
    $useremail = $_SESSION['lemail'];
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$useremail' OR enrollment_no='$useremail'");
    $row = mysqli_fetch_assoc($query);
    $enrollment_no = $row['enrollment_no'];
    $name=$row['name'];
    $unit_id = $_GET['unit_id']; // assuming there's a hidden input field for unit_id in the form
   
    $unit=mysqli_fetch_assoc(mysqli_query($conn,"Select * FROM units where unit_id='$unit_id'"));
   
    $u_name=$unit['unit_name'];
    
    $check=mysqli_query($conn, "SELECT * FROM performance WHERE enrollment_no='$enrollment_no' AND unit_id='$unit_id' AND c_id='$c_id'");
    
    if(mysqli_num_rows($check))
    {
        echo'<h1>"You Have Attempted This Quiz Successfully"</h1>';
    }
   else{
    $insert_sql = "INSERT INTO performance (c_id, enrollment_no, unit_id, percentage, studname) VALUES ('$c_id', '$enrollment_no', '$unit_id', '$percentage','$name')";
    mysqli_query($conn, $insert_sql);

    echo "<table align='center' class='table'  border='1' cellpadding='10'>
            <tbody>
                <tr> 
                    <th>Total Questions</th>
                    <td>$total_questions</td>
                </tr> 
                <tr>  
                    <th>Correct answers</th>
                    <td>$score</td> 
                </tr>
                <tr>  
                    <th>Incorrect answers</th>
                    <td>" . ($total_questions - $score) . "</td> 
                </tr>
                <tr> 
                    <th>Percentage</th>
                    <td>$percentage%</td>
                </tr>
            </tbody>
        </table>";
        }?>
        <button class="btn" onclick="window.history.back()">Back</button>
<?php
}
?>
</body>
</html>





<style>
*{
margin-left: 25rem;

}
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
    margin-left: 12rem;
}


</style>


