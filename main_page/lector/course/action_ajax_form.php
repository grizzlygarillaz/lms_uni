<?php

session_start();
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";
$user = $_SESSION["user_id"];
$full_name = $_POST['full_name'];
$short_name = $_POST['short_name'];
$id_cat = $_POST['category'];
$type = $_POST['type_course'];
$description = $_POST['description'];
$lecture = '1';
if (isset($_POST['save_course'])) {
    $save_cou = $sql->query("INSERT INTO course ( full_name, short_name, category, description, method_regist, application, lector)
       VALUES ('".$full_name."','".$short_name."','".$id_cat."','".$description."','".$type."',0,'".$_SESSION['user_id']."' )
      ");

};
?>