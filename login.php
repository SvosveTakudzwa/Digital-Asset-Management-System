<?php

include 'config/Validate.php';

$validate = new Validate();
$login;
if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  ($validate->login($email, $password));
  if (!($_SESSION['status'])) {
    $login = "$('#confirmModal').modal('show')";
  };
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

  <title>Asset Card Management - Login </title>

  <!-- Custom fonts for this template-->
  <?php include 'head.php'; ?>

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <img src="img/HITfavicon.jpg" class="img-fluid" alt="Welcome Image">
                    <h1 class="h4 text-gray-900 mb-4">Digital Asset Card Management System - Login</h1>
                  </div>
                  <form class="user" method="post" action="#">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="exampleInputEmail" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="Submit">
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.php">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.php">Create an Account</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>

  <div class="modal fade" id="confirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-danger" id="confirmModalLabel">Login Error</h5>
          <button type="button" class="close btn btn-secondary" data-dismiss="modal" id="closeBtn" aria-label="Close">
            <span aria-hidden="true">X</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Wrong Username or Password ?</p>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>


  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>


  <script>
    $(document).ready(function() {
      <?php echo $login; ?>
    })
  </script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>