<?php
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";
$course_id=$_POST['course_id'];
$user_id=$_POST['user_id'];
$type=$sql->query("SELECT method_regist FROM course where course_id='".$course_id."'");
$typecourse=$type->fetch_assoc();

if($typecourse['method_regist']=2){
    $sign_up=$sql->query("INSERT INTO application (course_id,user_id,status)
VALUES ('".$course_id."','".$user_id."',1)");
    echo "<button> Заявка отправлена</button>";
} elseif($typecourse['method_regist']=1){
   $add=$sql->query (" INSERT INTO student_list(stud_id, course_id) VALUES ('".$user_id."','".$course_id."' )");
    echo "Вы записаны на курс ";
}
?>

