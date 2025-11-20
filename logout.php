<?php
include 'config/Validate.php';
$id = $_SESSION['user_id'];


// Unset all of the session variables
$_SESSION = array();
session_unset();
// Destroy the session.
session_destroy();

// Redirect to login page
$validate =  new Validate();
if (($validate->insertActivity($id, 'logout')) == 'Inserted') {
    header("location: login.php");
    exit;
}
