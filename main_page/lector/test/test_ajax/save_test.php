<?php
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";
$lecture = $_GET['lecture'];
$course = $_GET['course'];
$testTitle = $_GET['testTitle'];

if (is_null($course))
{
    $sql->query("INSERT INTO test(title,lecture_id) VALUES ('$testTitle','$lecture')");
    sleep(0.1);
} else{
    $sql->query("INSERT INTO test(title,course_id) VALUES ('$testTitle','$course')");
    sleep(0.1);
}