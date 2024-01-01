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
$email=$_GET['cemail'];
$encryption_key ="khulja-sim-sim";//key to encrypt and decrypt string
$iv =0201304413140124;//Initialization Vector (IV) for encrypting data here it is 16 characters for AES-128-CTR algo
$decrypted_email = openssl_decrypt($email, 'AES-128-CTR', $encryption_key, 0, $iv);//decrypt email using openssl_encrypt syntax
?>
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
        <h1 class="text-center">Create New Account</h1>
        <form method="post" class="form-div" name="change_pass">
            <input type="email" name="email" placeholder="Email address" required="true" value="<?php echo $decrypted_email; ?>" disabled>
            <input type="password" id="npass" name="new_pass" placeholder="Password" required="true">
            <input type="password" id="confirm_npass" name="confirm_new_pass" placeholder="Confirm Password" required="true">
            <div class="password-box">
            <input type="checkbox" onclick="myFunction()">Show Password</input>
            </div>
            <button class="btn btn-info" type="submit" name="change">Submit</button>

            </div>
</div>

<script>
    function myFunction() {
        var x = document.getElementById("npass");
        var y = document.getElementById("confirm_npass");
        if (x.type && y.type== "password") {
            x.type= "text";
            y.type= "text";
        } else {
            x.type= "password";
            y.type= "password";
        }
    }
</script>
        
</body>
<?php
require_once('Config.php');

if (isset($_POST['change'])) {
    $npassword = str_replace(' ','',$_POST['new_pass']);
    $nconfirm_pass = str_replace(' ','',$_POST['confirm_new_pass']);
    $select = mysqli_query($conn, "select email from users where email='$decrypted_email'");
    $new = mysqli_fetch_array($select);

    if($npassword!=$nconfirm_pass) //check password and confirm pass word is same or not
    {
        echo '<script>
    Swal.fire({
        icon: "error",
        title: "Password and confirm password does not match",
    });
  </script>';

    }
    
    else if ($new > 0)
     {
        $npassword = password_hash($npassword, PASSWORD_DEFAULT);

        
        $change=mysqli_query($conn,"UPDATE users SET `password`='$npassword'where  email='$decrypted_email'");
       
        echo '<script>
        Swal.fire({
            icon: "success",
            title: "Password changed successfully!!",
            timer: 2000,
            showConfirmButton: false,
        }).then(function() {
            window.location.href = "login.php";
        });
      </script>'; 
    } 

    else{
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "This email is not registered please signup",
        }).then(function() {
            window.location.href = "sign_up.php";
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
</Style>
</html>
