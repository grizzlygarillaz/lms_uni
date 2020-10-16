<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
$question = $_GET['question'];
$lectureId = $_GET['lectureId'];
$courseId = $_GET['courseId'];
$questionType = $_GET['questionType'];
$answer = $_GET['answer'];
if (is_null($courseId)) {
    $testId = $sql->query("SELECT * FROM test WHERE lecture_id = '$lectureId'")->fetch_assoc()['id'];
    sleep(0.1);
}else{
    $testId = $sql->query("SELECT * FROM test WHERE course_id = '$courseId'")->fetch_assoc()['id'];
    sleep(0.1);
}


    $sql->query("INSERT INTO answer(answers) VALUES ('$answer')");
    sleep(0.1);
    $answer_id = mysqli_insert_id($sql);
    $sql->query("INSERT INTO question(title,question_type,answer_id) VALUES ('$question','$questionType','$answer_id')");
    sleep(0.2);
    $question_id = mysqli_insert_id($sql);
    $sql->query("INSERT INTO test_question VALUES ('$testId','$question_id')");
    sleep(0.1);