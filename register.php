<?php
include 'config/Validate.php';

if (isset($_POST['submit'])) {
  $validate =  new Validate();
  $username = $_POST['firstname'] . ' ' . $_POST['lastname'];
  $email = $_POST['email'];
  $pass = $_POST['password'];
  $dob = $_POST['dob'];
  $id_number = $_POST['idNumber'];
  $phone_number = $_POST['phoneNumber'];
  $address = $_POST['address'];
  $confirmpass = $_POST['confirmpassword'];
  $signature = $_POST['signature'];

  if (($username == '') || ($email == '') || ($pass == '') || ($dob == '') || ($id_number == '') || ($phone_number == '') || ($address == '') || ($signature == '')) {
    echo '<script> var files = `username: ' . $username . '\n
email: ' . $email . '\n
password: ' . $pass . '\n
dob: ' . $dob . '\n
id_number: ' . $id_number . '\n
phone_number: ' . $phone_number . '\n
address: ' . $address . '\n`
signature: ' . $signature . '\n`;
alert(files)
</script>';
  } else {
    if ($pass != $confirmpass) {
      echo '<script>alert("Wrong Password")</script>';
    }
    $validate->registerUsers($username, $email, $pass, $dob, $id_number, $phone_number, $address, $signature);
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="img/HITfavicon.jpg">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Asset Card Management - Register</title>
  <style>
    .error {
      color: red;
      font-size: 9px;
    }

    .success {
      color: green;
      font-size: 9px;
    }
  </style>

  <!-- Custom fonts for this template-->
  <?php include 'head.php'; ?>

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <form class="user" action="#" method="post">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="FirstName" name="firstname" placeholder="First Name">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="LastName" name="lastname" placeholder="Last Name">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6">
                    <input type="email" class="form-control form-control-user" id="Email" name="email" placeholder="Email Address">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="phone" name="phoneNumber" placeholder="Phone">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="date" class="form-control form-control-user" max="2006-01-01" name="dob" id="dob" placeholder="">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="idNumber" name="idNumber" placeholder="ID Number">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="inputPassword" name="password" placeholder="Password">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="repeatPassword" name="confirmpassword" placeholder="Repeat Password">
                    <span id="pass"></span>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col">
                    <input type="text" class="form-control form-control-user" id="address" name="address" placeholder="Enter your Address">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="signature" name="signature" placeholder="Signature">
                  </div>
                </div>
                <input type="submit" name="submit" id="submit" class="btn btn-primary btn-user btn-block" value="Register">
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="forgot-password.php">Forgot Password?</a>
              </div>
              <div class="text-center">
                <a class="small" href="login.php">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script>
    $(document).ready(function() {
      var repeat = $('#repeatPassword')
      var password = $('inputPassword')

      $("#repeatPassword").on('keyup', function() {
        var password = $("#inputPassword").val();
        var confirmPassword = $("#repeatPassword").val();
        if (password != confirmPassword) {
          $("#pass").html("Password does not match !").addClass("text-danger").removeClass('text-success');
          $('#submit').attr('disabled', true)
        } else {
          $("#pass").html("Password match !").addClass('text-success').removeClass('text-danger')
          $('#submit').attr('disabled', false)

        }
      });
    })
  </script>

</body>

</html>