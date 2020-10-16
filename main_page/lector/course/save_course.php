<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";

$full_name=$_POST['full_name'];
$description=$_POST['des'];
$course_id=$_POST['course_id'];
$save=$sql->query("UPDATE course SET full_name='". $full_name."' ,description= '".$description."'  WHERE  course_id='".$course_id."' ");
echo "<a>Успешно </a><div id=\"content\" class=\"col-md-8 px-0\">
    <h1 id=\"full_name\" class=\"display-6 font-italic\">$full_name</h1>
    <hr class=\"my-4\">
    <p id=\"description\" class=\"text-muted\">$description</p>

</div> ";
?>

