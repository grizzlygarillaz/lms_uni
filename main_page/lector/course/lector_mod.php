<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";

    $title=$_POST['title'];
    $description=$_POST['description'];
$idlm=$_POST['idlm'];
 echo "<div id=\"title\" class=\" mb-3\">
    <label >Название темы </label>
    <input  id=\"lecture_name\" type=\"text\" class=\"form-control\" name=\"title\"  value=\"$title\">  
</div>
<div class=\" mb-3\">
    <label >Содержание</label>
    <textarea name=\"description\" id=\"desc\" class=\"form-control\" style=\"height: 10rem\"  >$description</textarea>
</div><a id='idlm'>$idlm </a>
";

?>
