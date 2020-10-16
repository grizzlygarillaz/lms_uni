<?php

include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
$id=$_POST['id'];
$email=$_POST['email'];

$student=$sql->query("SELECT id FROM users WHERE email='".$email."'");
    $stud=$student->fetch_assoc();
$count=mysqli_num_rows($student);
if($count!==0  ){

    $addstudent=$sql->query("INSERT INTO student_list(stud_id, course_id) VALUES ('".$stud['id']."', '".$id."')");
    $addAplication=$sql->query("INSERT INTO application ( course_id, user_id, status) VALUES ('".$id."','".$stud['id']."',2)");
    echo '<p style="color: darkolivegreen">Студент зачислен на курс </p>';
} else {
    echo '<p style="color: darkred"> Студент с таким логином не найден</p>';
}

