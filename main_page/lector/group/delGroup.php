<?php
include $_SERVER['DOCUMENT_ROOT']. "/SQL/sql_connect.php";

$idGr=$_POST['id'];

$delete_group=$sql->query("DELETE FROM groups WHERE group_id ='".$idGr."'");