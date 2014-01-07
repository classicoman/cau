<?php
function getFormErrorMessage($e)
{
    switch($e) {
        case 1:  return "Captcha is incorrect";
            break;
        case 2: return "Password is too short";
            break;
        case 3:  return "Email is empty";
            break;
        case 4: return "Surname is empty";
            break;
        case 5: return "Name is empty";
              break;
        case 6: return "Username is already in use";
            break;
        case 7: return "Username does not belong to Escola Virtual";
            break;
    }
}
/* If I'm coming back from a failed Sign Up, fill the fields */
$name = "";
$surname = "";
$email = "";
if (isset($_GET['name']))      $name = $_GET['name'];
if (isset($_GET['surname']))   $surname = $_GET['surname'];
if (isset($_GET['email']))     $email = $_GET['email'];
     
// Get and Show the error
if (isset($_GET['error']))
    if ($_GET['error']!=0)  // If there was an error in the Form..
        echo getFormErrorMessage($_GET['error']);
?>