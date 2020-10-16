<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";

$item=$_POST['plan_item'];

$delete=$sql->query("DELETE FROM lesson_plan WHERE plan_id='".$item."'");