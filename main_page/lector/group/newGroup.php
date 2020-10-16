<?php
include $_SERVER['DOCUMENT_ROOT']. "/SQL/sql_connect.php";

$name=$_POST['name'];
$id=$_POST['id'];

$saveNewGroup=$sql->query(" INSERT INTO groups( group_name, lecture_id) VALUES ( '".$name."','".$id."' )");
echo('Создано');