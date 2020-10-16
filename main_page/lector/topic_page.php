<?php
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";
$id_topic=$_POST[id_topic];


$col_topic=$sql->query("SELECT * FROM page where page_id='".$id_topic."' ");
$content=$col_topic->fetch_assoc();
$title=$content['title'];
$description=$content['description'];


 echo " <div class=\"row\">
    <div class=\"col-md-4\">
        <h6 class=\"border-bottom border-gray pb-2 mb-0\">   ТЕМА: </h6>
    </div>
    <div class=\"col-md-4 offset-md-4\">
        <button type=\"button\" id=\"del_topic\" data-toggle=\"modal\"
                data-target=\"#staticBackdrop\" style=\"padding: 4px;\" class=\"btn btn-danger\"
        value=\" $id_topic \"
        title=\"Удалить курс\" style=\"padding: 1px;\"> Удалить тему лекции
        <span class=\"material-icons\" style=\"vertical-align: middle;
    color: #f8f9fa;\">delete_forever
        </span> 
        </button>
    </div>
</div>
<h6 id='title' class=\"border-bottom border-gray pb-2 mb-0\">$title</h6>
        <div class=\"media text-muted pt-3\">
        <p id='description' class=\"media-body pb-3 mb-0 small lh-125 border-bottom border-gray\">$description</p>
        <h6 id=\"id\" style=\"display: none\"  > $id_topic</h6>
";


?>






