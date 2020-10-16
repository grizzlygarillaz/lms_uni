<?php
include $_SERVER['DOCUMENT_ROOT']."/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";
session_start();
$user = $_SESSION['user_id'];

$test_id = $_GET['t_id'];
$CheckUserAnswers = 0;
$test = $sql->query("SELECT * FROM test WHERE id = '$test_id'")->fetch_assoc();
$questionQuery = $sql->query("SELECT * FROM question JOIN test_question ON test_id = '$test_id' WHERE id = question_id");
while ($row = $questionQuery->fetch_assoc()) {
    $userAnswerExist = $sql->query("SELECT * FROM user_answer WHERE question_id = '" . $row['id'] . "' AND user_id = '$user'")->fetch_assoc()['result'];
    if (!is_null($userAnswerExist)){
        $CheckUserAnswers += 1;
    }
}

if ($CheckUserAnswers == 0)
    $result = 0;
else {
    $questionQuery = $sql->query("SELECT * FROM question JOIN test_question ON test_id = '$test_id' WHERE id = question_id");
    $correct = 0;
    while ($row = $questionQuery->fetch_assoc()) {
        $userAnswerArray = $sql->query("SELECT * FROM user_answer WHERE question_id = '" . $row['id'] . "' AND user_id = '$user'")->fetch_assoc()['result'];
        $userAnswerArray = json_decode($userAnswerArray, true);
        $userAnswerArray = $userAnswerArray['answer'];
        sleep(0.1);
        $userAnswerCol = 0;
        $userAnswerCorrect = 0;
        $answersJSON = $sql->query("SELECT answers FROM answer WHERE id = '" . $row['answer_id'] . "'")->fetch_assoc()['answers'];
        $parse = json_decode($answersJSON, true);
        foreach ($userAnswerArray as $uAAItem) {
            $check = 0;
            $correctCheck = 0;
            foreach ($parse as $parsItem) {
                $check += (int)$parsItem['answer']['correct'];
                if ($parsItem['answer']['text'] == $uAAItem)
                    $correctCheck += (int)$parsItem['answer']['correct'];

            }
            $userAnswerCol += 1;
            $userAnswerCorrect += $correctCheck;
        }
        if ($check == $userAnswerCol and $check == $userAnswerCorrect)
            $correct += 1;
        sleep(0.1);
    }
}
$result = (int)($correct/($questionQuery->num_rows)*100);

$sql->query("INSERT INTO user_result VALUES ('$user','$test_id','$result')");

if ($result >= 86 && $result <= 100)
    $gratz = "Отл.";
elseif ($result >= 71 && $result < 86)
    $gratz = "Хор.";
elseif ($result >= 60 && $result < 71)
    $gratz = "Удов.";
elseif ($result < 60)
    $gratz = "Неуд.";
?>
    <div class="bg-white border shadow"
         style="border-radius: 20px 20px 20px 20px;
            margin: 1% 2%;
            border-color:#cecfd3;
            position:relative;
            padding: 1vw 2vw;">

        <h2 class="d-flex">Результаты тестирования</h2>
        <h3 class="border-bottom border-grey pb-2 d-flex" style="place-content: space-between; color: #393939">
            "<? echo $test['title'] ?>":
        </h3>


        <div class="bg-white border shadow-sm"
             style="border-radius: 20px 20px 20px 20px;
            margin: 3% 10%;
            border-color:#cecfd3;
            position:relative;
            padding: 1vw 2vw;">
            <h4 class="border-bottom border-grey pb-2 d-flex">Вопросов в тесте: <?echo $questionQuery->num_rows?></h4>
            <h4 class="border-bottom border-grey pb-2 d-flex">Правильных ответов : <?echo $correct?></h4>
            <h2>Баллы за тест : <?echo $result?> (<?echo $gratz?>)</h2>

        </div>

    </div>
<?php
$sql->close();
include $_SERVER['DOCUMENT_ROOT']."/templates/Footer.php";