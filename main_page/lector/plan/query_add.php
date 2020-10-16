<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
$date=$_POST['date'];
$title=$_POST['title'];
$course_id=$_POST['course_id'];


$query=$sql->query("INSERT INTO lesson_plan (lecture_id, datel, course_id) VALUES ('".$title."','".$date."','".$course_id."') ");
echo "<a>Успешно </a> ";

