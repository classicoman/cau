<link rel="stylesheet" type="text/css" href="css/signup.css"/>
    
<div id="login-header"> Notify Issue </div>
<div id="signup-fields">
    <form id="signup-form" name="signupForm" method="post" action="signupCheck.php">
        <div class="row">
            <input name="name" type="text" autofocus="autofocus"
                   placeholder="Nom" value="<?php echo $name ?>"/> 
        </div>
        <div class="row">
            <input name="surname" type="text" autofocus="autofocus"
                   placeholder="Llinatges" value="<?php echo $surname ?>"/> 
        </div>
        <div class="row">
            <input id="email" name="email" type="text" autofocus="autofocus"
                   placeholder="E-mail" value="<?php echo $email ?>"/><span id="domainname">@escoladisseny.com</span>
        </div>
        <div class="row">
            <input placeholder="Password" id="password" name="password"/>
        </div>
        <div class="row">
            <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
        </div>
        <div class="row" id="captcha_code">
            <input type="text" name="captcha_code" size="10" maxlength="6" />
            <a href="#" 
               onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
        </div>    
        <div class="row">
            <button type="submit">Acceptar</button>
        </div>
    </form>	
</div>