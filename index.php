<?php
session_start();
$session = (isset($_SESSION['myusername'])) ?   true  :  false;
require_once '_basic.php';

//Has the session been started? If not, 
if ( $session )
    include 'main.php'; 
else {
    if ($pg=="signup") {
        include 'templates/signup.php';    
    } 
    else
    {
        include 'templates/login.php';        
    }
}
?>