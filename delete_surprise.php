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
$fid = $_SESSION['faculty'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<header>
        <h1 class="logo">E-<span>Learners FACULTY</span></h1>
        <div id="menu"></div>
         <nav class="navbar">
                <a href="facultydashboard.php">E-learners Site</a>
                <a href="logout.php">logout</a>
                <a onclick="window.history.back()">Back</a>
            </nav>
    </header>
    
  <section class="delsur">
  <div class="performance_table">
<form action="" method="post">
<div class="label1" style="margin-bottom: 0.5rem;">
<label for="course">Course:</label>
<select id="course" name="course">
    <option value="" selected disabled hidden>Select a Course</option>
    <?php

    $course = $conn->query("SELECT c_id, c_name FROM courses where f_id = '$fid'");
    while ($row = $course->fetch_assoc()) {
        ?>
        <option value='<?php echo $row["c_id"]; ?>'><?php echo $row["c_name"]; ?></option>
<?php }
    ?>
</select>
</div>
<button class="btn"  name="delete">delete surprise</button>
</form></div>
    
    </section>
    
<?php
if(isset($_POST['delete']))
{
$c_id=$_POST['course'];
 
  $check=mysqli_query($conn,"SELECT * FROM surprise_test WHERE c_id='$c_id' AND test_id = (SELECT MAX(test_id) FROM surprise_test WHERE c_id = $c_id)");


   if(mysqli_num_rows($check)==0)
   {
    echo"<script>alert('no surprise test for this course is their');</script>";
   }
   else
{
    $deletesur=mysqli_query($conn,"DELETE FROM surprise_test WHERE c_id='$c_id' AND test_id = (SELECT MAX(test_id) FROM surprise_test WHERE c_id = $c_id)");
    echo "<script>alert('recent surprise test deleted successfully');</script>";
}
}
?>
</body
</html>
<style>
.delsur  {
    padding: 10rem 7%;
    }
    </style>