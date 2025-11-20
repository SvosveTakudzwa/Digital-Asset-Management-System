<?php 

$expiration_time_str = $_GET['expires'];
$expiration_time = date_create_from_format('Y-m-d H:i:s', urldecode($expiration_time_str));
$current_time = new DateTime();

if ($current_time > $expiration_time) {
   echo '<script>alert("Link has expired request a new one")</script>"';
} else {
    $qrcode = $_GET['qrcode'];
    
    header('location: ./image_viewer.php?qrcode='.$qrcode.'');
}