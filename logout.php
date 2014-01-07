<?php
   session_start();
   if (isset($_SESSION['myusername']))  {
       unset($_SESSION['myusername']);
   }
   
   session_destroy();

   header("location:index.php");
?>