<?php


include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";


$arr = $_POST['arr'];
$col=$_POST['col'];

    $del_group = $sql->query("DELETE FROM application WHERE kod  = '".$arr."'");


