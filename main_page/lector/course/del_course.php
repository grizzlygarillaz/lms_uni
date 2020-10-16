<?php

include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";

$idcourse=$_POST['id'];

$delite=$sql->query("DELETE FROM course WHERE course_id='".$idcourse."'");


