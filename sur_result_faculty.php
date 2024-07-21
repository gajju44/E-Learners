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
$fid = $_SESSION['faculty'];
?>

<html>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Faculty Surprise test result</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="admin-body">

    <header>
      <h1 class="logo">E-<span>Learners FACULTY

        </span></h1>
      <div id="menu" class="fas fa-bars"></div>
             <nav class="navbar">
            <a href="facultydashboard.php#home">home</a>

            <a href="logout.php">Logout</a>
                        <a onclick="window.history.back()">Back</a>
        </nav>
    </header>
<section></section>
<section></section>
    <section class="performance-adminside">
      <div class="performance_table">
        <div class="course-table">
          <h1>Surprise Test Result</h1>

          <form method="post" action="">
            <select id="course" name="course" required>
              <option value="" selected disabled hidden>Select course</option>
              <?php
              $cource = $conn->query("SELECT c_id, c_name FROM courses WHERE f_id='$fid'");
              while ($row = $cource->fetch_assoc()) {
                ?>
                <option value='<?php echo $row["c_id"]; ?>'><?php echo $row["c_name"]; ?></option>
              <?php } ?>
            </select>
            <button class="btn-per" name="submit" type="submit">See Performance</button>
          </form>

          <?php
          if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
            $getcid = $_POST['course'];
            ?>

            <table class="table">
              <thead>
                <tr>
                  <th>Enrollment No</th>
                  <th>Name</th>
                  <th>Percentage</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT enrollment_id, percentage FROM result WHERE c_id='$getcid'";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                  $enrollment_id = $row['enrollment_id'];
                  $percentage = $row['percentage'];

                  // Get the student's name
                  $sql2 = "SELECT name FROM users WHERE enrollment_no='$enrollment_id'";
                  $result2 = mysqli_query($conn, $sql2);
                  $row2 = mysqli_fetch_assoc($result2);
                  $name = $row2['name'];

                  echo "<tr>";
                  echo "<td>" . $enrollment_id . "</td>";
                  echo "<td>" . $name . "</td>";
                  echo "<td>" . $percentage . "%</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>

          <?php } ?>

        </div>
      </div>
    </section>
  </div>
</body>
<script src="script.js"></script>
<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>

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

  table thead tr {
    color: var(--white);
    text-align: left;
    font-weight: bold;
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
</style>
