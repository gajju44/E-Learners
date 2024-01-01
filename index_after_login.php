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
<?php session_start();
if(!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] !== true)
{
  echo'<script> window.location.href = "index.php"</script>';
    exit();
}
require_once('Config.php');
$useremail = $_SESSION['lemail'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
      <!--faicon code start -->
 <link rel="icon" type="image/svg+xml" href="favicon.svg">
<link rel="icon" type="image/png" href="Phoenix.png">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body>
    <div class="container">

        <header>
            <h1 class="logo">E-<span>Learners</span></h1>
            <div id="menu" class="fas fa-bars"></div>
            <nav class="navbar">
                <a href="#home">Home</a>
                <a href="#course">Course</a>
                <a href="#about">About</a>
                <a href="dashboardStudent.php">Scorecard</a>
                <a href="course_surprise.php">Suprise-test</a>
                <a href="logout.php">Logout</a>
            </nav>
        </header>

        <!-- =========================================== home section ========================================== -->

        <section class="home" id="home">

            <div class="content">
                <div class="names">
                    <h3>Welcome</h3>
                    <h2>
                        <?php


                        $query = mysqli_query($conn, "select name from users where  email='$useremail' || enrollment_no='$useremail'");
                        //This query is for getting the respective user's data from database.
                        
                        $string = mysqli_fetch_assoc($query); //function  use to store data which is in '$query' into an  associative array
                        $getname = implode("_", $string); //implode function is use to join all elements into a string         
                        echo $getname;

                        ?>
                    </h2>
                </div>
                <p>Our platform E-learners provides world-class LMS solutions that empower <br> organizations to meet
                    education
                    and workplace learning needs.</p>
                <a href="#course" class="btn">Explore Courses</a>
            </div>

            <div class="image">
                <img src="images\PNG\Education Illustration Kit-01.png" alt="">
            </div>

        </section>

        <!-- ========================================== more-info =================================== -->

        <h1 class="more-info-heading">Revolutionizing the way of Learning</h1>
        <h1 class="more-info-subheading">Online Learning is Perceived</h1>
        <section class="more-info">

            <div class="box">
                <h3>Easy Integration</h3>
                <p>Our website for e-learning is compatible with popular cources like java programming, Software
                    Engineering and more</p>
            </div>


            <div class="box" href="#feedback">
                <h3>Give Feedback</h3>
                <p>Our website for e-learning is compatible with popular cources like java programming, Software
                    Engineering and more</p>
            </div>


            <div class="box">
                <h3>Process Automation</h3>
                <p>We reduced the burden on teachers and Students by Automating a number of process by going with
                    E-learners</p>
            </div>

        </section>


        <!-- ========================================== About section =========================================== -->

        <section class="about" id="about">

            <div class="image" data-aos="fade-out">
                <img src="images\PNG\About us page-pana.svg" alt="">
            </div>

            <div class="content" data-aos="fade-out">
                <h3>About us</h3>
                <p>E-learners, a platform dedicated to providing high-quality educational resources
                    to students and educators alike. Our mission is to make learning accessible, engaging, and enjoyable
                    for everyone.</p>
                <p>Thank you for choosing us as your go-to source for educational resources. We look forward to helping
                    you achieve your academic goals</p>
            </div>

        </section>

        <!-- ====================================== Courses ============================================= -->
        <div>
            <div data-aos="zoom-in">
                <h1 class="heading">your courses</h1>
            </div>
            <section class="course" id="course">
                <?php

                $query = mysqli_query($conn, "select years from users where  email='$useremail' || enrollment_no='$useremail'");

                $string = mysqli_fetch_assoc($query);
                $getyear = implode("_", $string);

                $sql = "SELECT c_id, c_name, c_decs, c_img FROM courses where years = '$getyear'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $c_id = $row["c_id"];
                        $c_name = $row["c_name"];
                        $c_decs = $row["c_decs"];
                        $c_img = $row["c_img"];
                        ?>
                        <div class="box"
                            onclick="window.location.href='https://gpnagpur.tk/units.php?c_id=<?php echo $c_id; ?>';"
                            data-aos="zoom-in">
                            <img src="<?php echo $c_img ?>" alt="">
                            <h3>
                                <?php echo $c_name ?>
                            </h3>
                            <p>
                                <?php echo $c_decs ?>
                            </p>

                        </div>
                        <?php
                    }
                } else {
                    echo "No courses found";
                }

                // Close the database connection
                
                ?>

            </section>
            <section class="feedback" id="feedback">

                <h1 class="heading">Give Feedback</h1>

                <div class="row">

                    <form action="" method="post">
                        <ul class='choices'>
                            Give Enrollment:
                            <div class="opti">
                                <label for="yes">
                                    <input type="radio" id="yes" name="option" value="
                                 <?php
                                
                                 $query = mysqli_query($conn, "select enrollment_no from users where email='$useremail' || enrollment_no='$useremail'");
                                 $string = mysqli_fetch_assoc($query);
                                 $getname = implode("_", $string);
                                 echo $getname;
                                 ?>" required>Yes
                                </label>
                                <label for="no">
                                    <input type="radio" id="no" name="option" value="555" required>No
                                </label>
                            </div>
                        </ul>
                        <br>
                        <div class="feedback-course">
                            <label for="course">Select a course:</label>
                            <select id="course" name="course">
                                <option value="" selected disabled hidden>Select Course</option>
                                <?php
                                // Retrieve user's year from session
                               
                                $query = mysqli_query($conn, "SELECT years FROM users WHERE email='$useremail' OR enrollment_no='$useremail'");
                                $result = mysqli_fetch_assoc($query);
                                $year = $result['years'];

                                // Retrieve courses assigned to the user's year
                                $query = mysqli_query($conn, "SELECT c_name FROM courses WHERE years='$year'");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    echo '<option value="' . $row['c_name'] . '">' . $row['c_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <textarea name="feedback" id="" cols="30" rows="10" class="box add"
                            placeholder="Give Feedback"></textarea>
                        <input type="submit" class="btn" value="Submit Feedback" name="submit">
                    </form>

                    <?php
                    if (isset($_POST['submit'])) {

                        $feedback = $_POST['feedback'];
                        $enrollment = $_POST['option'];
                        $course_name = $_POST['course'];


                        // Do something with the feedback and enrollment variables here
                    
                        $sql = "INSERT INTO feedback (enroll_no, feedback,course) VALUES ('$enrollment', '$feedback','$course_name')";
                        if (mysqli_query($conn, $sql)) {
                            echo '<script>alert("Feedback submitted successfully...!!!") </script>';
                        } else {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }
                    ?>

                </div>

            </section>
            
            
             <section class="footer">
            <h1>About Members</h1>
            <div class="footer-container">
                <div class="box">

                    <div class="share">
                        <a href="https://www.linkedin.com/in/vedant-chaudhari-b37723275" class="fab fa-linkedin"></a>
                    </div>
                    <h3>Vedant Chaudhari</h3>
                </div>

                <div class="box">
                    <div class="share">
                        <a href="https://www.linkedin.com/in/gajendra-naphade-513a54262" class="fab fa-linkedin"></a>
                    </div>
                    <h3>Gajendra Naphade</h3>
                </div>

                <div class="box">
                    <div class="share">
                        <a href="https://www.linkedin.com/in/rupesh-dhamane-b01b85210" class="fab fa-linkedin"></a>
                    </div>
                    <h3>Rupesh Dhamane</h3>
                </div>

                <div class="box">
                    <div class="share">
                        <a href="#" class="fab fa-linkedin"></a>
                    </div>
                    <h3>Bhavesh Adekar</h3>
                </div>

                <div class="box">
                    <div class="share">
                        <a href="#" class="fab fa-linkedin"></a>
                    </div>
                    <h3>Nandini Giri</h3>
                </div>
            </div>
        </section>
     

        </div>

        <script src="script.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

        <script>
            var icon = document.getElementById("icon");

            icon.onclick = function () {
                document.body.classList.toggle("dark-theme");
                if (document.body.classList.contains("dark-theme")) {
                    icon.src = "images/darktheme/sun.png";
                } else {
                    icon.src = "images/darktheme/moon.png";
                }
            }
        </script>
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
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>

</body>

</html>