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

//Captcha.
include_once 'securimage/securimage.php';
//Object Securimage
$securimage = new Securimage();
//Comprova si l'usuari ha escrit el codi Captcha
if ($securimage->check($_POST['captcha_code']) == false) {  $error = 1;  }

/*Validar Formulari*/

//Si el Password és massa curt...
if (strlen($_POST["password"]) < 5)
    $error = 2;      

// Define variables and set to empty values
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
        //Open emails file
        $handle = fopen("emails.txt", "r");
        if ($handle) {
            //Look for user in the table
            $trobat=false;
             while (($line = fgets($handle)) !== false) {
                /* Test_input elimina la porquerieta d'inici i final de linia */
                if (test_input($line) == $email."@escoladisseny.com") {
                    $trobat=true;
                    break;
                } 
            }
            if ($trobat) {  
                // // Email introduit és correcte -> donar d'alta user
                // Donar d'alta usuari en BDD
                $encPswd = crypt($_POST["password"]);
                $sql  = "INSERT INTO members(username,password,blocked,type) ";
                $sql .= "VALUES ('$email','$encPswd',0,'Vo')";
                $result = $tables->executaQuery($sql);
                
                // Fill the email fields.
                $direccio = /*$email*/"informatic"."@escoladisseny.com"; //xxtoni
                $subject = "Dades accés notifyIssue";
                $message = "Usuari = ".$email.", psd = ".$_POST['password'];
                
                //Send the email
                mail($direccio, $subject, $message, "From:noreply@toniamengualsalas.com");
                
                //Set Session Username.
                session_start();
                $_SESSION['myusername'] = $email;
                //Creo una cookie amb el nom d'usuari. Aquesta cookie s'enviarà al browser amb la primera pàgina de contingut. Després, cada vegada que l'usuari
                //demani la  pagina main.php durà la cookie establerta.
                $value = 'OK';
                setcookie("usuari", $value, time() + 3600);  /* expire in 1 hour */

                /* El codi és incomplet, he de controlar que aquest usuari té una sessió oberta.. 
                 * no se com fer-ho mirar més codi...!! xxxtoni*/
                include 'index.php';
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