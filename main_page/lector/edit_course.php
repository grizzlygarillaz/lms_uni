<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";

$full_name=$_POST['full_name'];
$description=$_POST['description'];
$id=$_POST['idcourse'];


echo "<div id=\"title\" class=\" mb-3\">
    <label>Полное название курса</label>
    <input id=\"course_name\" type=\"text\" class=\"form-control\" name=\"course_name\" value=\"$full_name\">
    <label>Описание курса</label>
    <textarea name=\"description\" id=\"desc\" class=\"form-control\">$description</textarea>
    </div><a id='idc' style=\"display: none\">$id </a> 
";

