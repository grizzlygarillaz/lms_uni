<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";

$idGroup=$_POST['idGroup'];
$idCourse=$_POST['idCourse'];

$all_student=$sql->query("SELECT user_id FROM user_group WHERE group_id='".$idGroup."'");
while( $student=$all_student->fetch_assoc()){

    $add_st_apl=$sql->query("INSERT INTO application( course_id, user_id, status) VALUES ('".$idCourse."','".$student['user_id']."',2) ");
    $add_st_course=$sql->query("INSERT INTO student_list(stud_id, course_id) VALUES ('".$student['user_id']."','".$idCourse."')");
}

 echo '<p style="color: darkolivegreen">Студенты группы зачислены на курс </p>';