<?php
//Start the Sesion
session_start(); 
if (isset($_SESSION['myusername']))
    $session = true;
else
    $session=false;

require '_basic.php';

// Botar a SC_SIGNUP?
$jump=false;
if (isset($_GET['pg']))
    if ($_GET['pg']=="signup") {
        $jump=true;
    }
    
if (!$jump)
{
    //Has the session been started? If not, 
    if ( $session ) {
        include 'main.php'; 
    }
    else {
        include 'templates/login.php';
    }
}
else {
    require 'signup.php';
    include 'templates/signup.php';
}
?>