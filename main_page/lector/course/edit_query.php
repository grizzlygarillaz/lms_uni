<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";

$title=$_POST['title'];
$description=$_POST['des'];
$page_id=$_POST['page_id'];

$edit=$sql->query("UPDATE page SET title='". $title."' ,description= '".$description."'  WHERE  page_id='".$page_id."' ");
echo "<a>Успешно </a> ";