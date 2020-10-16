<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
session_start();
$user = $_SESSION['user_id'];

$question = $_REQUEST['question'];
$questionQuery   = $sql->query("SELECT * FROM question WHERE id = '$question'")->fetch_assoc();
$answers = $questionQuery["answer_id"];
sleep(0.1);
$answersJSON = $sql->query("SELECT answers FROM answer WHERE id = $answers")->fetch_assoc()['answers'];
$parse = json_decode($answersJSON, true);
sleep(0.1);

$jsonArray = [];
$jsonArray = $sql->query("SELECT * FROM user_answer WHERE question_id = '$question' AND user_id = '$user'");
sleep(0.1);
if ($jsonArray) {
    $jsonArray = $jsonArray->fetch_assoc()['result'];
    $jsonArray = json_decode($jsonArray, true);
}

function radioButtons($checked, $data)
{
    echo '  
        <label id="answer"  class="btn btn-outline-secondary ' . $checked . '" style="text-align: left">
            <input type="radio" autocomplete="off" id="answerInput" name="' . $data . '">
            ' . $data . '
        </label>';
}

function checkBox($checked, $data)
{
    echo '<button id="answerInput" name="' . $data . '"  class="btn btn-outline-secondary ' . $checked . '" 
    autocomplete="off" style="text-align: left">' . $data . '</button>';
}


echo '<p class="lead d-flex" id="questionTitle">' . $questionQuery['title'] . '</p>';
switch (intval($questionQuery['question_type'])) {
    case 1:
        echo "<div id='answerBlock' class='btn-group-vertical btn-group-toggle w-75 shadow-sm bg-white rounded' data-toggle='buttons' role='group'>";
        foreach ($parse as $i => $el) {
            if (in_array($el["answer"]['text'], $jsonArray['answer']))
                $check = 'active';
            else
                $check = '';
            radioButtons($check, $el["answer"]['text']);
        }
        echo "</div>";
        break;
    case 2:
        echo "<p  class='lead d-flex' style='margin-left: 12.4%; align-self: baseline'>Выберите несколько вариантов ответа:</p>";
        echo "<div id='answerBlock' class='btn-group-vertical btn-group-toggle w-75 shadow-sm bg-white rounded' data-toggle='buttons' role='group'>";
        foreach ($parse as $i => $el) {
            if (in_array($el["answer"]['text'], $jsonArray['answer']))
                $check = 'active';
            else
                $check = '';
            checkBox($check, $el["answer"]['text']);
        }
        echo "</div>";
        break;
}


sleep(0.1);
$sql->close();
