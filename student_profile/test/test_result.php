<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
$quest = $_REQUEST['quest'];
$answer = $_REQUEST['answer'];
$test = $_REQUEST['test_id'];
$user = $_SESSION['user_id'];

$questType = $sql->query("SELECT * FROM question WHERE id = '$quest'")->fetch_assoc();
$questType = $questType['question_type'];
sleep(0.1);


function recursiveRemoval(&$array, $val)
{
    if (is_array($array)) {
        foreach ($array as $key => &$arrayElement) {
            if (is_array($arrayElement)) {
                recursiveRemoval($arrayElement, $val);
            } else {
                if ($arrayElement == $val) {
                    unset($array[$key]);
                }
            }
        }
    }
}

switch ($questType) {
    case "1":
        $jsonArray = array(
            'id' => $quest,
            'answer' => array(
                0 => $answer
            )
        );
        $json = json_encode($jsonArray, JSON_UNESCAPED_UNICODE);
        if ($sql->query("SELECT * FROM user_answer WHERE question_id = '$quest' AND user_id = '$user'")->fetch_row()) {
            sleep(0.1);
            $sql->query("UPDATE user_answer SET result = '$json' WHERE question_id = '$quest' AND user_id = '$user'");
        } else {
            sleep(0.1);
            $sql->query("INSERT INTO user_answer(result,question_id,test_id,user_id) VALUES ('$json','$quest','$test','$user')");
        }
        break;
    case "2":
        $answerCheck = $sql->query("SELECT * FROM user_answer WHERE question_id = '$quest' AND user_id = '$user'")->fetch_row();
        sleep(0.1);
        if ($answerCheck < 1) {
            $jsonArray = array(
                'id' => $quest,
                'answer' => array()
            );
            array_push($jsonArray["answer"], $answer);
            $json = json_encode($jsonArray, JSON_UNESCAPED_UNICODE);
            $sql->query("INSERT INTO user_answer(result,question_id,test_id,user_id) VALUES ('$json','$quest','$test','$user')");
        } else {
            $jsonArray = $sql->query("SELECT * FROM user_answer WHERE question_id = '$quest' AND user_id = '$user'")->fetch_assoc()['result'];
            sleep(0.1);
            $jsonArray = json_decode($jsonArray, true);
            if (in_array($answer, $jsonArray["answer"])) {
                recursiveRemoval($jsonArray, $answer);
            } else
                array_push($jsonArray["answer"], $answer);
            sleep(0.1);
            $jsonArray["answer"] = array_values($jsonArray["answer"]);
            sleep(0.1);
            $json = json_encode($jsonArray, JSON_UNESCAPED_UNICODE);
            $sql->query("UPDATE user_answer SET result = '$json' WHERE question_id = '$quest' AND user_id = '$user'");
        }
}

sleep(0.1);

$sql->close();