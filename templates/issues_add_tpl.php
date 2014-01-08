<!-- ADD a new iSSUE  -  for users <> admin -->
<link rel="stylesheet" type="text/css" href="css/added.css"/>

<div id="reg_saved" name="reg_saved">
    <div id="updating" style="background:url(images/ajax-loader.gif) no-repeat left; height:50px; width:370px; display:none;">
        <p>Updating...</p>
    </div>
</div>    
<div id="header_added">
    <div id="rotul"><?php echo $dic[$title][0] ?></div>
    <div id="btnBack"></div>
    <input id="js_changed" name="js_changed" type="hidden"/><!-- Canviar de lloc xtoni -->
</div>

<div id="all">
    <div><?php echo $dic['titleissue'][0] ?></div>
    <div> <input id="name" type="text" autofocus="autofocus" value="<?php echo $name ?>"/> </div>
    <div><?php echo $dic['description'][0] ?></div>
    <div class="fila">
        <textarea id="descripcio" class="desc"><?php echo $description ?></textarea>
    </div>
    <div class="fila">Aula:
<?php   echo printListBox("fkey_location", "locations", $fkey_location); //Default Priority = Normal  ?> 
    </div>
    <div id="buttons">
        <button type="button" id="btnUpdate" onclick="onClickSave()"><?php echo $dic['save'][0] ?>
        </button>                 
    </div>
</div>

<!-- Put the JQuery always at the bottom or it won't work! -->
<script type="text/javascript">
        
//Activation of 'SAVE' mode
    $('#name, #descripcio, #date_start, #fkey_prioritat, #fkey_location').change ( function(e) {
        document.getElementById('js_changed').value = 'SAVE';
    });
    
//Save Data
    function onClickSave() {
        //Hi ha hagut algun canvi?
        if (document.getElementById('js_changed').value=='SAVE') {
            loadXMLUpdateSyncOrNot(<?php echo "'reg_saved','issues_addedX.php?id=$id&op=UPDATE','$fields_s'" ?>);
        }
        //Torna a l'estat inicial
        document.getElementById('js_changed').value = '';
    }

//En espitjar sobre fletxa de BACK
    $('#btnBack').click ( function(e) { 
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