<?php
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";

$id= $_POST['id'];


$delTopic=$sql->query(" DELETE FROM page WHERE page_id='".$id."'");