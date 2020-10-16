<?php
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";
//$add_student=$_POST['email'];
//$group=$_POST['group'];
//
//$search_st=$sql->query("SELECT email,id FROM users WHERE email='".$add_student."'")->fetch_assoc();
//if(mysqli_num_rows(( $search_st)) !==null){
//    $add=$sql->query("INSERT INTO user_group (user_id,group_id) VALUES ('".$search_st['id']."', '".$group."' )");
//    echo "<a>Успешно </a> ";
//} else {
//echo "Не найдено";}
$id=$_POST['group'];;
$email=$_POST['email'];

$student=$sql->query("SELECT id FROM users WHERE email='".$email."'");
$stud=$student->fetch_assoc();
$count=mysqli_num_rows($student);
if($count!==0 ){

    $addstudent=$sql->query("INSERT INTO student_list(stud_id, course_id) VALUES ('".$stud['id']."', '".$id."')");
    $add=$sql->query("INSERT INTO user_group (user_id,group_id) VALUES ('".$stud['id']."', '".$id."' )");
    $addAplication=$sql->query("INSERT INTO applications ( course_id, user_id, status) VALUES ('".$id."','".$stud['id']."',2)");
    echo '<a style="color: darkolivegreen;">Студент зачислен на курс'. $id.'</a>';
} else {
    echo '<a style="color: darkred"> Студент с таким логином не найден</a>';
}

