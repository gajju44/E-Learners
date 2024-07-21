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
        <h1 class="logo">E-<span>Learners FACULTY
             
            </span></h1>
        <div id="menu" class="fas fa-bars"></div>
                  <nav class="navbar">
            <a href="facultydashboard.php#home">home</a>

            <a href="logout.php">Logout</a>
                        <a onclick="window.history.back()">Back</a>
        </nav>
    </header>

    <!-- ============================= add_content section starts ==================================== -->

    <section class="add_content" id="add_content">
        <div class="row">
            <form action="add_content_faculty.php" method="post" enctype="multipart/form-data">
                <h2>theory Section</h2>
                <div class="selectwcourse">
                    <label for="course">Course:</label>
                    <select id="course" name="course" class="selectcourse" required>
                        <option value="" selected disabled hidden>Select a course</option>
                        <?php
                        $courses = $conn->query("SELECT c_id, c_name FROM courses where f_id = '$fid'");
                        while ($row = $courses->fetch_assoc()) {
                            ?>
                            <option value='<?php echo $row["c_id"]; ?>'><?php echo $row["c_name"]; ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
                <input type="text" placeholder="Enter Unit Name" class="un1" name="unitName" required>
                <input type="text" placeholder="Enter Unit Description" class="un1" name="unitDescription" required>
                <p>Enter unit Description</p>
                <textarea cols="80" id="editor1" name="editor1" rows="10"></textarea>
                <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
                <script>
                    var editor = CKEDITOR.replace('editor1', {
                        height: '400',
                        width: '700',
                        contentsCss: '',
                        //removePlugins : 'pastefromword',
                        extraAllowedContent: 'h1;div{border,background-color};table[align,cellspacing]{margin,width,border,border-*};tr;td{border-color,height,vertical-align,width};tbody;th;span{background-color,background,color,font-size,font-family};p{margin-left,margin-right,margin-top,margin-bottom};pre{background-color,font-size,font-family}'
                    });

                    editor.on('pluginsLoaded', function (evt) {
                        evt.editor.filter.addTransformations([
                            [{
                                element: 'td',
                                left: function (el) {
                                    return el.name == 'td';
                                },
                                right: function (el, tools) {
                                    if (el.attributes && el.attributes.valign) {
                                        el.styles['vertical-align'] = el.attributes.valign;
                                        delete el.attributes.valign;
                                    }
                                }
                            }],
                            [{
                                element: 'div',
                                left: function (el) {
                                    return el.name == 'div';
                                },
                                right: function (el, tools) {
                                    if (el.styles && el.styles['background']) {
                                        el.styles['background-color'] = el.styles['background'];
                                        delete el.styles['background'];
                                    }
                                }
                            }],
                        ]);
                    });
                </script>
                <input type="submit" class="btn" value="Final Submit" name="submit">

            </form>
        </div>
    </section>
</body>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>


<script src="script.js"></script>

<?php

if (isset($_POST["submit"])) {
    $data = $_POST["editor1"]; // Get the data from CKEditor textarea
    $unitName = $_POST['unitName'];
    $unitDescription = $_POST['unitDescription'];
    $c_id = $_POST['course'];
    $sql = "INSERT INTO units (content, unit_name, unit_description, c_id) VALUES ('$data', '$unitName', '$unitDescription','$c_id')";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Content inserted successfully into database."); window.location.href = "facultydashboard.php";</script>';
    } else {
        echo "Error";
    }
}

?>
