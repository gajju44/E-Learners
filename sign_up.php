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
<!-- register html -->
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign-up</title>
  <link rel="stylesheet" href="style.css">
    <!--faicon code start -->
 <link rel="icon" type="image/svg+xml" href="favicon.svg">
<link rel="icon" type="image/png" href="Phoenix.png">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div class="container1">

    <div class="main-div">
      <h1>Create New Account</h1>
      <form method="post" class="form-div" name="register" >
        <input type="text" name="name" placeholder="Username" required="true" style="text-transform: capitalize;">
        <input type="email" name="email" placeholder="Email address" required="true">
        <input type="number" name="enrollment_no" placeholder="En.roll no" required="true">
        <input type="password" id="pass" name="password" placeholder="Password" required="true">
        <input type="password" id="confpass" name="confirm_pass" placeholder="Confirm Password" required="true">

        <select class="selectbranch" id="Branch" name="branch">
          <option value="" selected disabled hidden>Select Branch</option>
          <option value="Computer Engineering">Computer Engineering</option>
          <option value="Mechanical Engineering">Mechanical Engineering</option>
          <option value="Information Technology">Information Technology</option>
          <option value="Civil Engineering">Civil Engineering</option>
        </select>
        <select class="selectyear" id="year" name="year">
          <option value="" selected disabled hidden>Select Year</option>
          <option value="1">1st Year</option>
          <option value="2">2nd Year</option>
          <option value="3">3rd Year</option>
        </select>
        <div class="password-box">
          <input type="checkbox" onclick="myFunction()">Show Password</input>
        </div>
        <button class="btn" type="submit" name="submit">Submit</button>
        <p>Already have an account?
          <a href="login.php">login</a>
        </p>

      </form>

    </div>
  </div>
</body>
<script src="script.js"></script>

<Style>
  body {
    min-height: 100vh;
    width: 100%;
    height: 100%;
    /* background: url(back5.png); */
    background: url(https://static.vecteezy.com/system/resources/previews/005/948/321/large_2x/back-to-school-banner-with-hand-drawn-line-art-icons-of-education-science-objects-and-office-supplies-school-supplies-concept-of-education-background-free-vector.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
  }
</Style>


<?php

require_once('Config.php');
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendmail($email, $v_code)
{
  
  require('PHPMailer/PHPMailer.php');
  require('PHPMailer/SMTP.php');
  require('PHPMailer/Exception.php');

  $mail = new PHPMailer(true);

  try {
    //Server settings
    $mail->SMTPDebug = 0; //Enable verbose debug output
    $mail->isSMTP(); //Send using SMTP
    $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through here it is gmail on server we have to set as example:mail.gpnagpur.tk
    $mail->SMTPAuth = true; //Enable SMTP authentication
    $mail->Username = 'elearnersgp@gmail.com'; //SMTP username
    $mail->Password = 'dxvtxsctiippvaf'; //SMTP password for server or app password for gmail as example given for gmail
    $mail->SMTPSecure ='ssl'; //Enable implicit ssl encryption
    $mail->Port = 465; //TCP port to connect to;

    //Recipients
    $mail->setFrom('elearnersgp@gmail.com', 'E-Learners');
    $mail->addAddress($email); //Add a recipient

    //Content
    $mail->isHTML(true); //Set email format to HTML
    $mail->Subject = 'Email verification for E-learners';
    $mail->Body =  "Your Registration In Successful
    Click the button below to verify the email address 

    <html >
    <head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
      <meta http-equiv='X-UA-Compatible' content='IE=edge' />
      <meta name='viewport' content='width=device-width, initial-scale=1.0' />
      <title>Email Verification by E-Learners</title>
      <style type=''>
        body {
          margin: 0;
          color: white;
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .course {
          display: flex;
          flex-wrap: wrap;
          gap: 2.5rem;
          margin-top: 5rem;
          justify-content: center;
          align-items: center;
        }
        .course .box {
          flex: 1 1 39rem;
    align-items: center;
          background:url(https://png.pngtree.com/background/20210714/original/pngtree-doodles-on-green-chalkboard-background-back-to-school-background-picture-image_1207855.jpg);
          border-radius: .5rem;
          border: .1rem solid grey;
          padding: 2.5rem;
          position: relative;
          box-shadow: 0 0.1rem grey;
          transition: 0.2s;
          cursor: pointer;
          max-width: 43rem;
        }

        table {
        border-spacing: 0;
        padding: 12px;
        text-align: center;
        width:100%;
        max-width:600px;
        margin:0 auto;
        
      }
      td {
        padding: 0;
      }
      img {
        border: 0;
      }
      a{
        color:white;
      }
      a:visited{
        color:white;
      }
      
        h3 {
          width: 100%;
          max-width: 150px;
          height: auto;
          margin-bottom: 20px;
          color:white;
        }
        h2,
        .code {
          font-weight: bold;
          font-size: 24px;
          margin-bottom: 60px;
          color:white;
        }
       
        .code {
          border: 3px solid #8774e1;
          padding: 7px 12px;
          border-radius: 10px;
        }
        p{
          color:white;
        }
        .desc {
          margin-top: 60px;
          font-size: 18px;
          line-height: 30px;
        }
        .verifybtn{
          background-color: white;
          border: none;
    text-decoration: none;
          padding: 15px 32px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          margin: 4px 2px;
          cursor: pointer;
          border-radius: 16px;
          transition: 0.3s;
          font-size: 16px;
          color:white;
      }
        
        .verifybtn:hover {
          background: #ff7f41;
          transform: scale(1.1);
        }
      </style>
  </head>
  <body>
  <section class='course'>
  <div class='box'>
    <table>
      <tbody>
        <tr>
          <td>
            <h3>E-learners</h3>
          </td>
        </tr>
        <tr>
          <td><h2>Verify your Email account</h2></td>
        </tr>
        <tr>
          <td>
          <a  class='verifybtn' href='verify.php?v_code=$v_code&vemail=$email'>Verify
            </a>

          </span>
          </td>
        </tr>
        <tr>
          <td>
            <p class='desc'>
            <h2>
              PLEASE CLICK ON THE ABOVE BUTTON TO VERIFY THE EMAIL
             </h2>
            </p>
          </td>
        </tr>
      </tbody>
    </table>
    </div>
    </section>

  </body>
</html>
";


    $mail->send();
    return true;

  } catch (Exception $e) {
    return false;


  }


}

//register php
if (isset($_POST['submit'])) {
  $name = strip_tags($_POST['name']);
  $email = $_POST['email'];
  $enroll = $_POST['enrollment_no'];
  $password = str_replace(' ','',$_POST['password']);
  $confirm_pass = str_replace(' ','',$_POST['confirm_pass']);
  $branch = $_POST['branch'];
  $year = $_POST['year'];
  $ret = mysqli_query($conn, "select email from users where email='$email' || enrollment_no='$enroll'");
  $result = mysqli_fetch_array($ret);
  if ($result > 0) {
    echo '<script>
    Swal.fire({
        icon: "error",
        title: "This email or enrollment no. already associated with another account.",
    });
  </script>';
    
  } else if (strlen((string) $enroll) != 7) //check enrollemt is of 7 numbers or not
  { 
    echo '<script>
    Swal.fire({
        icon: "error",
        title: "Enrollment no. should be of 7 numbers",
    });
  </script>';

  } else if ($password != $confirm_pass) //check password and confirm pass word is same or not
  {
    echo '<script>
    Swal.fire({
        icon: "error",
        title: "Password and confirm password does not match",
    });
  </script>';
  } else if (sendmail($email, $v_code) > 0) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $v_code = rand(999999, 111111);
    $query = mysqli_query($conn, "insert into users(name, email, enrollment_no, password, verification_code, verification_status, branch, years) value('$name', '$email','$enroll', '$password', ' $v_code', '0', ' $branch', '$year')");

    if ($query) {
        echo '<script>
        Swal.fire({
            icon: "success",
            title: "verification code sent successfully!",
            timer: 1000,
            showConfirmButton: false,
        }).then(function() {
            window.location.href = "login.php";
        });
      </script>';
    } else {
        echo '<script>
    Swal.fire({
        icon: "error",
        title: "Server Down!!!!",
    });
  </script>';
    }
  } else {
    echo '<script>
    Swal.fire({
        icon: "error",
        title: "network problem",
    });
  </script>';
  }
}

//end register php



?>

</html>

<script>
  function myFunction() {
    var x = document.getElementById("pass");
    var y = document.getElementById("confpass");
    if (x.type && y.type == "password") {
      x.type = "text";
      y.type = "text";
    } else {
      x.type = "password";
      y.type = "password";
    }
  }
</script>

