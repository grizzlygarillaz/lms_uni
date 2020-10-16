<?php

include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
$id=$_POST['group'];;
$email=$_POST['email'];

$student=$sql->query("SELECT id FROM users WHERE email='".$email."'")->fetch_assoc();
$count=mysqli_num_rows($student);
if($count!==0 ){

    $addstudent=$sql->query("INSERT INTO student_list(stud_id, course_id) VALUES ('".$student['id']."', '".$id."')");
    $addAplication=$sql->query("INSERT INTO applications ( course_id, user_id, status) VALUES ('".$id."','".$student['id']."',2)");
    echo '<a style="color: darkolivegreen;">Студент зачислен на курс </a>';
} else {
    echo '<a style="color: darkred"> Студент с таким логином не найден</a>';
}

