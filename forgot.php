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

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

  <div class="container1">
    <div class="main-div">
      <h1>Forgot Password?</h1>
      <p>Enter your registered email and we'll send you a link to change your password.</p>
      <form method="post" class="form-div" name="forgot" onsubmit="login.php">
        <input type="email" name="email" placeholder="Email" required="true">
        <button class="btn btn-info" type="submit" name="submit">Submit</button>
      </form>
    </div>
  </div>

</body>

<?php
require_once('Config.php');
session_start();
error_reporting(0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendmail($email)
{
$encryption_key ="khulja-sim-sim";//key to encrypt and decrypt string
$iv =0201304413140124;//Initialization Vector (IV) for encrypting data here it is 16 characters for AES-128-CTR algo
$encrypted_email = openssl_encrypt($email, 'AES-128-CTR', $encryption_key, 0, $iv);//encrypt email using openssl_encrypt syntax

  require('PHPMailer/PHPMailer.php');
  require('PHPMailer/SMTP.php');
  require('PHPMailer/Exception.php');

  $mail = new PHPMailer(true);

  try {
   //Server settings
    $mail->SMTPDebug = 0; //Enable verbose debug output
    $mail->isSMTP(); //Send using SMTP
    $mail->Host = 'mail.gpnagpur.tk'; //Set the SMTP server to send through
    $mail->SMTPAuth = true; //Enable SMTP authentication
    $mail->Username = 'e-learners@gpnagpur.tk'; //SMTP username
    $mail->Password = '2013044gajju'; //SMTP password
    $mail->SMTPSecure ='ssl'; //Enable implicit ssl encryption
    $mail->Port = 465; //TCP port to connect to;

    //Recipients
    $mail->setFrom('e-learners@gpnagpur.tk', 'E-Learners');
    $mail->addAddress($email); //Add a recipient

   //Content
   $mail->isHTML(true); //Set email format to HTML
    $mail->Subject = 'Change Password for E-learners';
    $mail->Body = "Change your password for E-Learners account by clicking button below
   
<html xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta http-equiv='X-UA-Compatible' content='IE=edge' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <title>Email Verification by E-Learners</title>
    <style type=''>
      body {
        margin: 0;

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
        background:url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQuHgt-ivI9vfemve9V3P4tXbtXDFJmE2KJXg&usqp=CAU);
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
      h3 {
        width: 100%;
        max-width: 150px;
        height: auto;
        margin-bottom: 20px;
      }
      h2,
      .code {
        font-weight: bold;
        font-size: 24px;
        margin-bottom: 60px;

      }
     
      .code {
        border: 3px solid #8774e1;
        padding: 7px 12px;
        border-radius: 10px;
      }
      .desc {
        margin-top: 60px;
        font-size: 18px;
        line-height: 30px;
      }
      .changebtn{
        background-color: #eb2a7a;;
        border: none;
        color: inherit;
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
            
    }
      
      .changebtn:hover {
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
          <td><h2>Change Your E-learners Account's Password</h2></td>
        </tr>
        <tr>
          <td>
         <a  class='changebtn' href='https://gpnagpur.tk/change_pass.php?cemail=$encrypted_email'>change
         </a>
          </span>
          </td>
        </tr>
        <tr>
          <td>
            <p class='desc'>
             please Click above button to change your password
            </p>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>
";


    $mail->send();
    return true;

  } catch (Exception $e) {
    return false;


  }


}

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $ret = mysqli_query($conn, "select email from users where email='$email'");
  $query = mysqli_fetch_array($ret);
  if ($query) {
    if (sendmail($email)) {
      echo '<script>
        Swal.fire({
            icon: "success",
            title: "Mail sent successfully!",
            timer: 2000,
            showConfirmButton: false,
        }).then(function() {
            window.location.href = "login.php";
        });
      </script>';

    } else {
      echo '<script>
      Swal.fire({
          icon: "error",
          title: "Network Error",
      });
    </script>';
    }
  } else {
    echo '<script>
    Swal.fire({
        icon: "error",
        title: "no such email is registered",
    });
  </script>';
  }
}

?>


<Style>
  body {
    min-height: 100vh;
    width: 100%;
    height: 100%;
    background: url(https://static.vecteezy.com/system/resources/previews/005/948/321/large_2x/back-to-school-banner-with-hand-drawn-line-art-icons-of-education-science-objects-and-office-supplies-school-supplies-concept-of-education-background-free-vector.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
  }

  p {
    margin-top: 1rem;
    font-size: 1.5rem;
  }
</Style>

</html>