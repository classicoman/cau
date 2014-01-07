<link rel="stylesheet" type="text/css" href="css/issues.css"/>

<div id="header">
    <div id="logo">
        <img src="images/logo.png" alt="Logo"/>
    </div>
    <div id="title"><?php echo $dic['issues'][0]?></div>
    <div id="username"><?php echo $username ?></div>
</div>
<div id="menubar">
    <div id="menu">
        <div class="dropdown">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
              <?php echo $dic['menu'][0] ?>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="index.php?pg=issues&amp;class=0">Obertes</a></li>
                <li><a href="index.php?pg=issues&amp;class=1">Tancades</a></li>
                <li class="divider"></li>
                <li><a href="logout.php"><?php echo $dic['signout'][0] ?></a></li>
          </ul>
        </div>
    </div>
    <a href="index.php?pg=added&amp;id=0"><div id="add"></div></a>
</div>

<div id="all">
    <div id="div_rows">

<?php  foreach ($rows as $row) {
    
        if ($count++==$maxRows)
            break;
        $id = $row['id'];
        
        //Determinar si hi ha incidències que s'han de marcar
        $markIt= false;
        //Perque és nova, creada per un Membre i jo sóm l'administrador
        if (($row['bool_checked']==0) && isUserAdmin($rowmember['id']))
            $markIt = true;
        else
        {
            //Si tenc comentaris per llegir...
            if (in_array($row['id'], $issuesWithComments)) {
                $markIt = true;
            }
            /*
            // Pq hi ha comments d'un Membre (si sóc admin) o bé de l'Admin (si sóc un Membre)
            $sqlUsuari = " fkey_member". ( (isUserAdmin($rowmember['id'])) ? " <>3 " : "=3"); 
            $unchecked = $tables->executaQuery("SELECT id FROM comments WHERE fkey_issue='".$row['id']."' AND bool_checked=0 AND $sqlUsuari");
            $markIt = (dbIsQueryResultNull($unchecked)) ? false : true;
            */
        }   
?>	
        <div class="fila" onclick="javascript:location.href='<?php echo "index.php?pg=added&maxrows=$maxRows&id=$id" ?>'">
            <div class="date">
                <?php echo (isUserAdmin($rowmember['id'])) ? $row['username'].", " : "" ?>
                <?php echo toWrittenDate($row['date_start']) ?>
            </div>
            <div class="<?php echo ($markIt) ? 'name_new' : 'name' ?>">
                <?php echo $row["name"] ?>
            </div>
            <div class="<?php echo ($markIt) ? 'desc_new' : 'desc' ?>">
                <?php echo (strlen($row["descripcio"])<80) ? $row["descripcio"] : substr($row["descripcio"],0,100)." [...]" ?>
            </div>
        </div>
<?php   
    }  
?>  
    </div>
</div>