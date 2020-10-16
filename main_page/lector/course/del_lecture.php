<?php

include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";

$idlecture=$_POST['id'];


$delite=$sql->query("DELETE FROM lecture WHERE lecture_id='".$idlecture."'");