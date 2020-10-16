<?php include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
$testId = $_GET['testId'];
$question = $_GET['question'];
$questionType = $_GET['questionType'];
$answer = $_GET['answer'];
$questionId = $_GET['questionId'];

if ($questionId != ""){
    $sql->query("UPDATE question SET title = '$question', question_type = '$questionType' WHERE id = '$questionId'");
    sleep(0.1);
    $answerId = $sql->query("SELECT * FROM question WHERE id = '$questionId'")->fetch_assoc()['answer_id'];
    sleep(0.3);
    $sql->query("UPDATE answer SET answers = '$answer' WHERE id = '$answerId'");
    }
else
    {
    $sql->query("INSERT INTO answer(answers) VALUES ('$answer')");
    sleep(0.1);
    $answer_id = mysqli_insert_id($sql);
    $sql->query("INSERT INTO question(title,question_type,answer_id) VALUES ('$question','$questionType','$answer_id')");
    sleep(0.2);
    $question_id = mysqli_insert_id($sql);
    $sql->query("INSERT INTO test_question VALUES ('$testId','$question_id')");
    sleep(0.1);
}
echo var_dump($questionId);