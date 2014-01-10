<link rel="stylesheet" type="text/css" href="css/added.css"/>  <!-- S'ha de posar al head de main - xtoni -->

<input id="js_changed" name="js_changed" type="hidden"/>

<div id="header_added">
    <div id="rotul"><?php echo $dic[$title][0] ?></div>
    <div id="btnBack"><a id="btnBack"><img src="images/back.png"/></a></div>
</div>

<div id="all">
      <div><?php echo $dic['titleissue'][0].":" ?></div>
      <div><strong><?php echo $name ?></strong></div>
      <div><?php echo $dic['description'][0].":" ?></div>
      <div> <strong><?php echo $row['descripcio'] ?></strong></div>
      <div class="fila">
          Data Inici:<strong><?php echo " ".toMyDate($date_start)."  " ?></strong>
<?php if ($location!="")  {  ?>
          Ubicació:<?php echo "<strong> $location</strong>" ?>
<?php } ?>
      </div>
</div>
<div id="issues_comments_box">
<?php  include 'templates/issues_comments.php';   ?>
</div>



<!-- Put the JQuery always at the bottom or it won't work! -->
<script type="text/javascript">    
//Activation of 'SAVE' mode
    $('#name, #descripcio, #date_start, #fkey_prioritat, #fkey_location').change ( function(e) {
        //Activa el mode SAVE
        document.getElementById('js_changed').value = 'SAVE';
    });
    

//Close Issue
    function onClickClose() {
        if (confirm('Segur que voleu tancar la Incidència?')) 
            loadXMLUpdateSyncOrNot(<?php echo "'reg_saved','issues_addedX.php?id=$id&op=CLOSE&state=$state'" ?>);
    }

    //Per a canviar el color de la icona quan és espitjada o s'hi passa per sobre
    $('a#btnBack img')
        .mouseover(function() { 
            var src = "images/back-b.png";
            $(this).attr("src", src);
        })
        .mouseout(function() {
            var src = "images/back.png";
            $(this).attr("src", src);
        });
        
    //En espitjar sobre fletxa de BACK
    $('a#btnBack').click ( function() { 
        if (document.getElementById('js_changed').value == 'SAVE')
            threebuttonsdialog('Si', 'No', 'Cancel·lar', $(this));
        else
            window.location ='index.php?pg=issues';
    });

/* coderefx: http://jsfiddle.net/CdwB9/3/ */
//Three buttons Dialog that is prompted after closing an issue without saving
function threebuttonsdialog(button1, button2, button3, element){
        var btns = {};
        btns[button1] = function(){
            //1.Yes -> Save data with SYNC
            loadXMLUpdateSyncOrNot(<?php echo "'reg_saved','issues_addedX.php?id=$id','$fields_s'" ?>,false);
            /* I need this code to: save first or it won't save, and to save before going to index.php */
            window.location ='index.php?pg=issues';
                $(this).dialog("close");
        };
        btns[button2] = function(){ 
            //2.No -> Jump.
            window.location ='index.php?pg=issues';
                $(this).dialog("close");
        };
        btns[button3] = function(){ 
            //3.Cancel -> Do nothing.
            $(this).dialog("close");
        };
        //Obre un diàlog amb tants botons com haguem definit
        //Per què utilitza <div></div>?...  xxxtoni
        $("<div></div>").dialog({
            autoOpen: true,
            resizeable: false,
            title: 'Voleu guardar els canvis en la incidència?',
            modal:true,   //Modal: en mode syncrònic, espera el clic de l'user.
            buttons:btns  //Botons
        });
    }
</script>