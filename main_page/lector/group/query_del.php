<?php
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";
$idg=$_POST['idg'];

$del_group=$sql->query("DELETE FROM user_group WHERE idg='".$idg."'");
echo '<a>Участник удален </a>';