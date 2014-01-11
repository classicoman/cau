<?php
require_once '../_basic.php';
require_once '../model/Tables.php';

$tables = new Tables();

switch($_GET['op']) 
{

    //Create a New comment attached to $issue
    case "NEW":
        $name = htmlspecialchars($_GET['name'], ENT_QUOTES);
        $issue = $_GET['issue'];
        $member = $_GET['member'];
        $hour = date('Y-m-d H:i:s');
        $sql =  "INSERT INTO comments(hour,fkey_issue,description,bool_checked,fkey_member) ";
        $sql .= " VALUES('$hour','$issue','$name',0,$member)";
        $y = $tables->executaQuery($sql);
        
        include '../templates/issues_comments_sub.php';
        
        break;
    //Detach $cat from this $issue
    case "DEL":
        $comment = $_GET['comment'];
    	$result = $tables->executaQuery("DELETE FROM comments WHERE id='$comment'");
        break;
}
?>