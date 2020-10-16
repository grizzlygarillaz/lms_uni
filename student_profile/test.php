<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/templates/Base.php';
include $_SERVER['DOCUMENT_ROOT'] . '/SQL/sql_connect.php';
$test_id = $_GET["t_id"];

$sql->query("DELETE FROM user_answer WHERE user_id = '".$_SESSION['user_id']."' AND test_id = '$test_id'");

$test = $sql->query("SELECT * FROM test WHERE id = '$test_id'")->fetch_assoc();
$questionQuery = $sql->query("SELECT * FROM question JOIN test_question ON question_id = question.id WHERE test_id = '$test_id'");
?>
<div class="bg-white border shadow clearfix"
     style="border-radius: 20px 20px 20px 20px;
            margin: 15px 3%;
            border-color:#cecfd3;
            position:relative;
            padding: 1vw 2vw;
            min-height: 24rem">
    <h3 class="border-bottom border-grey pb-2 d-flex" style="place-content: space-between"><? echo $test['title'] ?>
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#TestAccept">Завершить тестирование</button>
    </h3>

    <?php
    $questionIdArray = [];
    while ($row = $questionQuery->fetch_array())
        array_push($questionIdArray, (int)$row['id']);
    ?>
    <div class="btn-group btn-group-toggle border-bottom border-grey pb-2 d-flex" data-toggle="buttons">
        <?php
        $i = count($questionIdArray) - 1;
        while ($i >= 0) {
            echo '
              <label id="Page" class="btn btn-outline-warning pb-3 ">
                    <input type="radio" autocomplete="off" id="testPage" name="' . $questionIdArray[$i] . '">
              </label>
                ';
            $i--;
        }
        ?>
    </div>
    <div id="answers" class="list-group m-4 align-items-center" style="min-height: 13rem;justify-content: space-around">
        <div id="spinnerInTest" class="spinner-grow text-dark" role="status">
            <span class="sr-only" >Loading...</span>
        </div>
    </div>

    <div class="d-flex" style="justify-content: center">
        <button class="btn btn-outline-secondary mr-4" id="prevQuestion">Назад</button>
        <button class="btn btn-outline-secondary" id="nextQuestion">Далее</button>
    </div>
<!--    <div id="controlButton" style="text-align: center" class="mb-2">-->
<!--        <button id="prevQuestion" type="button" class="btn btn-primary mr-2" style="width: 20%">Назад</button>-->
<!--        <button id="nextQuestion" type="button" class="btn btn-primary" style="width: 20%">Далее</button>-->
<!--    </div>-->
    <div class="modal fade" id="TestAccept" tabindex="-1" role="dialog" aria-labelledby="TestAcceptTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TestAcceptTitle">Внимание!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Вы уверены, что хотите завершить тест?</p>
                </div>
                <div class="modal-footer">
                    <button id="goToTest" type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button id="cancelTest" type="button" class="btn btn-warning">Завершить</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            test = <?echo $test_id?>;
            var quest;

            $(document).on('click','#nextQuestion',function () {
                $('#Page.active').next().click()
                                        .children().click();
            })

            $(document).on('click','#prevQuestion',function () {
                $('#Page.active').prev().click()
                    .children().click();
            })

            $(document).on('click', '#testPage', function () {
                $.ajax({
                    url: "test/test_question.php",
                    data: "question=" + $(this).attr('name') + "&test=" + test,
                    beforeSend: function () {
                        $("#answers").html(
                            '<div class="spinner-grow text-dark" role="status">' +
                            '<span class="sr-only">Loading...</span>' +
                            '</div>'
                        );
                    },
                    success: function (html) {
                        $("#answers").html(html);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Ошибка загрузки вопроса ' + jqXHR + " " + textStatus + " " + errorThrown);
                    }
                });
                quest = parseInt($(this).attr('name'));
                return false;
            });
            $("#testPage").first().click();

            $(document).on('click', '#answerInput', function () {
                console.log($(this).attr('name'));
                $.ajax({
                    url: "test/test_result.php",
                    data: "quest=" + quest + "&answer=" + $(this).attr('name') +
                        "&test_id=" + test,
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Ответ не получен ' + jqXHR + " " + textStatus + " " + errorThrown);
                    }
                });
            })

            $(document).on('click', '#answer', function () {
                if ($(this).hasClass('active'))
                    $(this).removeClass('active');
                else
                    $(this).addClass('active');
            })

            $(document).on('click','#cancelTest', function () {
                console.log('закончился тест');
                window.location.replace("test/user_result.php?t_id=<?echo $test_id?>");
            })
        });
    </script>


</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/Footer.php';
?>
