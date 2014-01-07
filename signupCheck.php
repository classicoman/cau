<?php
session_start();

include '_basic.php';
include 'model/Tables.php';
$tables = new Tables();

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));;
}

$error = 0;
/* VALIDAR CAPTCHA */    
/* Necessari per a que funcioni el codi de la Captcha, seguint indicacions
 * de http://www.phpcaptcha.org/documentation/quickstart-guide/ */

/* xtoni Aquesta ruta, que s'ha de configurar depenent de la estruct de directoris del Servidor! */
include_once 'securimage/securimage.php';
//Object Securimage.
$securimage = new Securimage();
if ($securimage->check($_POST['captcha_code']) == false) {
    $error = /*1*/0; 
}

/*Validar Formulari*/
/* Aquest codi l'he agafat de http://www.w3schools.com/php/php_form_validation.asp */

if (strlen($_POST["password"]) < 5)
    $error = 2;      

// Define variables and set to empty values
$name = $email = $gender = $comment = $website = "";
$email   = test_input($_POST["email"]);
$surname = test_input($_POST["surname"]);
$name    = test_input($_POST["name"]);

if ($email=="")     $error = 3;
if ($surname=="")   $error = 4;
if ($name=="")      $error = 5;

if (!$error)
{
    // Check is the username is already in use
    if (!dbIsQueryResultNull($tables->executaQuery("SELECT id FROM members WHERE username='$email';")))
       $error = 6;
    else {
        $handle = fopen("emails.txt", "r");
        if ($handle) {
            $trobat=false;
             while (($line = fgets($handle)) !== false) {
                /* Test_input elimina la porquerieta d'inici i final de linia */
                if (test_input($line) == $email."@escoladisseny.com") {
                    $trobat=true;
                    break;
                } 
            }
            if ($trobat) {  // Email introduit és correcte -> donar d'alta user
                // Donar d'alta usuari en BDD
                $encPswd = crypt($_POST["password"]);
                $sql  = "INSERT INTO members(username,password,blocked,type) ";
                $sql .= "VALUES ('$email','$encPswd',0,'Vo')";
                $result = $tables->executaQuery($sql);
                
                // Enviar email - http://www.w3schools.com/php/php_mail.asp
                $direccio = /*$email*/"informatic"."@escoladisseny.com";
                $subject = "Dades accés notifyIssue";
                $message = "Usuari = ".$email.", psd = ".$_POST['password'];
      //xxxtoni          mail($direccio, $subject, $message, "From:noreply@toniamengualsalas.com");
                
      session_start();
                //Set Session Username.
                $_SESSION['myusername'] = $email;
                //Creo una cookie amb el nom d'usuari. Aquesta cookie s'enviarà al browser amb la primera pàgina de contingut. Després, cada vegada que l'usuari
                //demani la  pagina main.php durà la cookie establerta.
                $value = 'OK';  
                setcookie("usuari", $value, time() + 3600);  /* expire in 1 hour */

                /* El codi és incomplet, he de controlar que aquest usuari té una sessió oberta.. 
                 * no se com fer-ho mirar més codi...!! xxxtoni*/
                header('location:index.php?pg=issues');    
            } else  {
                $error = 7;
            }
        } else {
            echo "Error Opening the File";  //xxx toni Errors que he de tabular.
        }
        }
}

if ($error!=0) {
    //header("location:");
    $location = "signup.php?error=$error&name=$name&surname=$surname&email=$email";
?>
<script>window.location ='<?php echo $location ?>';</script>
<?php } ?>