<?php
/* If I'm coming back from a failed Sign Up, fill the fields */
$name = "";
$surname = "";
$email = "";
if (isset($_GET['name']))      $name = $_GET['name'];
if (isset($_GET['surname']))   $surname = $_GET['surname'];
if (isset($_GET['email']))     $email = $_GET['email'];
?>