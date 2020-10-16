<?php
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";


$topic_title=$_POST['topic_title'];
$topic_desc=$_POST['topic_desc'];
$id_lectop=$_POST['id_lectop'];

$save_topic=$sql->query(" INSERT INTO page( title,  description, lecture_id)
VALUES ( '".$topic_title."','".$topic_desc."','".$id_lectop."') ");