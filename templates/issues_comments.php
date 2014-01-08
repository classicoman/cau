<link rel="stylesheet" type="text/css" href="css/comments.css"/>

<div id="issues_comments">
    <div id="label"><b>Comentaris:</b></div>
    <div id="issues_comments_sub">
<?php        
        /* Print the list of Comments */
        include 'issues_comments_sub.php';       
?>
    </div>
</div>
<!-- Add a comment - Zone -->
<div id="add_comment">
    <div id="textarea"> <textarea id="comment_js"></textarea> </div>    
    <div id="sendBtn"></div>
</div>

<script>
//Add a New comment
$("#sendBtn").click( function(e) {
    loadXMLDoc('issues_comments_sub','<?php echo "issues_comments_subX.php?op=NEW&issue=$issue&member=".$rowmember['id'] ?>','NEWCOM');
});
</script>