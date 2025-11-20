<?php
include 'config/Validate.php';
$validate = new Validate();
if (isset($_POST['submit'])) {
  $assetID = ((int)filter_var($_POST['assetID'], FILTER_SANITIZE_NUMBER_INT)) - 1000 ;
  $reg_number = $_POST['regNumber'];


  $sql = 'SELECT * FROM assets AS ass INNER JOIN students AS st ON ass.student_id = st.student_id WHERE ass.assets_id = '.$assetID.'';
  $num_rows = $validate->getNumRows($sql);
  if ($num_rows === 1) {
    $asset = $validate->getOneRow($sql);

    $output = $asset["assets_id"] . '#' . $asset["item_description"] . '#' . $asset["model"] . '#' . $asset["serial_number"] . '#' . $asset["student_id"] . '#' . $asset["missing"].'#'.$asset['qr_code'].'#'.$asset['student_username'];

    echo $output;
  } else {
    echo "No item found";
  }
}
