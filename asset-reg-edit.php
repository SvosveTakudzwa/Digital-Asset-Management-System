<?php

include 'config/Validate.php';
require_once './vendor/phpqrcode/qrlib.php';
if (!isset($_SESSION['user_id'])) {
  header('location: login.php');
}

$edit = '';
if (isset($_POST['submit'])) {

  $userID = $_POST['userID'];
  $regNumber = $_POST['regNumber'];
  $itemDescription = $_POST['itemDescription'];
  $itemModel = $_POST['itemModel'];
  $serialNumber = $_POST['serialNumber'];
  $missing = $_POST['missing'];

  $validate = new Validate();

  if (($validate->editAsset($userID, $regNumber, $itemDescription, $itemModel, $serialNumber, $_GET['aid'], $missing)) == 'Success') {
    $edit = '$("#confirmModalLabel").text("Update Sucessful").addClass("text-success"); 
          $("#message").text("Asset has been updated sucessfully");
           $("#confirmModal").modal("show")';
  } else {
    $edit = '$("#confirmModalLabel").text("Update Error").addClass("text-danger");
   $("#message").text("Update failed");
    $("#confirmModal").modal("show")';
  }
}


$assetID = $_GET['aid'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <script src="jSignature/jquery.js"></script>
  <script src="jSignature/jSignature.min.js"></script>
  <script src="jSignature/modernizr.js"></script>
  <link rel="icon" href="img/HITfavicon.jpg">
  <title>HIT ACMS - Edit Asset Info</title>

  <!-- Custom fonts for this template-->
  <?php include 'head.php'; ?>

  <style>
  </style>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
          <img src="img/HITfavicon.jpg" alt="" width="50" height="50">
        </div>
        <div class="sidebar-brand-text mx-3">Asset Card Management</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        MANAGEMENT
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-laptop"></i>
          <span>Asset Management</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="asset-reg.php">Asset Registration</a>
            <a class="collapse-item" href="blacklist.php">Blacklisted Assets</a>
            <a class="collapse-item" href="missing.php">Search Asset</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-user"></i>
          <span>User Management</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="register.php">User Registration</a>
            <a class="collapse-item" href="user-audit-logs.php">User Audit Logs</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        REPORTS
      </div>

      <!-- Nav Items -->
      <li class="nav-item">
        <a class="nav-link" href="asset-audit-trail.php">
          <i class="fas fa-fw fa-list"></i>
          <span>Asset Audit Trail</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="reports-analytics.php">
          <i class="fas fa-fw fa-tools "></i>
          <span>Reporting & Analytics</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar - Greeting Logged in user-->
          <!--  <a class="nav-link">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Good morning <?php echo $userDetails['username']; ?></span>
          </a>-->

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <!--<a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>-->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">
            <a href="index.php" class="btn btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Back</a>
            Update Asset Details
          </h1>
          <?php $sql = "SELECT * FROM assets WHERE assets_id = $assetID";
          $validate = new Validate();
          $asset = $validate->getOneRow($sql);
          ?>
          <form class="user" action="#" method="post">
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user" id="regNumber" name="regNumber" value="<?php echo $asset['student_id']; ?>" placeholder="Student Registration Number">
                <span id="regex"></span>
              </div>
              <div class="col-sm-6">
                <input type="text" class="form-control form-control-user" id="itemDescription" name="itemDescription" value="<?php echo $asset['item_description']; ?>" placeholder="Item Description">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-6">
                <input type="text" class="form-control form-control-user" id="itemModel" name="itemModel" value="<?php echo $asset['model']; ?>" placeholder="Device Model">
              </div>
              <div class="col-sm-6">
                <input type="text" class="form-control form-control-user" id="serialNumber" name="serialNumber" value="<?php echo $asset['serial_number']; ?>" placeholder="Serial Number">
              </div>
            </div>
            <input type="hidden" name="userID" value="<?php echo $_SESSION['user_id']; ?>">
            <div class="form-group row">
              <div class="col-6">
                <label for="Blacklist">Blacklist</label>
                <select name="missing" class="form-select">
                  <?php if ($asset['missing'] == 'Yes') {
                    echo '<option value="Yes">Yes</option>
                      <option value="No">No</option>';
                  } else {
                    echo '<option value="No">No</option>
                  <option value="Yes" >Yes</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-6">
                <input type="submit" value="Update" class="btn btn-success" id="submit" name="submit">
              </div>
            </div>
          </form>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-----Footer----->
      <footer>
        <?php include './footer.php' ?>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="confirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel"></h5>
          <button type="button" class="close btn btn-secondary" data-dismiss="modal" id="closeBtn" aria-label="Close">
            <span aria-hidden="true">X</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="message">Wrong Username or Password ?</p>
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

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script>
    $(document).ready(function() {
      <?php echo $edit; ?>
    })

    const regNumber = document.getElementById('regNumber');
    const regex = /^H\d{6}[A-Z]$/;

    regNumber.addEventListener('focusout', () => {
      var regexID = document.getElementById('regex')
      var submit = document.getElementById('submit');
      if (regex.test(regNumber.value)) {
        regexID.style.color = 'green'
        regexID.textContent = "Reg number is valid"
        regexID.style.fontSize = '10px';
        submit.removeAttribute('disabled')
      } else {
        submit.setAttribute('disabled', true)
        regexID.style.color = 'red'
        regexID.textContent = "Reg number should contain capital letter H followed by 6 digits and A capital letter"
        regexID.style.fontSize = '10px';
      }
    });
  </script>
</body>

</html>