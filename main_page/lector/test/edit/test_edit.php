<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
session_start();

$course_id = $_GET['course'];
if (is_null($_GET['test_id']))
    $test_id = $sql->query("SELECT * FROM test WHERE course_id = '$course_id'")->fetch_assoc()['id'];
else
    $test_id = $_GET['test_id'];
sleep(0.2);
$user = $_SESSION['user_id'];


$closeButton = "
            <button id=\"deleteAnswer\" type=\"button\" class=\"close ml-2\" aria-label=\"CloseAnswer\">
                <span aria-hidden=\"true\">&times;</span>
            </button>";

function checkbox($text,$check = '',$checked,$close = "") {
    echo '  <div class="btn-group d-flex w-100 m-1 Answer">          
                <label id="correctAnswer" class="input-group-prepend btn btn-outline-success '.$check.'">
                    <input type="checkbox" name="correctAnswer" autocomplete="off" '.$checked.'>
                    <span class="material-icons">
                        done
                    </span>
                </label>
                    <input type="text" class="outline-light form-control textAnswer" value="'.$text.'">
                ' .$close.'
                </div>
            ';
}
function radiobutton($text,$check = '',$checked,$close = "") {
    echo '<div class="btn-group d-flex w-100 m-1 Answer">   
                <label id="correctAnswer" class="input-group-prepend btn btn-outline-success '.$check.'">
                    <input type="radio" name="correctAnswer" autocomplete="off" '.$checked.'>
                    <span class="material-icons">
                        done
                    </span>
                </label>
                    <input type="text" class="outline-light form-control textAnswer"  value="'.$text.'">
                    ' .$close.'
                </div>
            ';
}

function questionHeader () {
    echo '<div id="addAnswer_form" class="bg-white rounded shadow-sm mt-3 p-3 addAnswer" >
                <p>Введите варианты ответа и отметьте правильные</p>
            <div id="radiobuttonAnswer" class="input-group btn-group-toggle d-flex w-100 mt-2" data-toggle="buttons">
             ';
}

function firstCheckbox($type) {
        echo'<button id="add_answer" value="'.$type.'" class="btn btn-success mt-2 w-100" title="Добавить вариант ответа" style="height: 38px">
                    <span class="material-icons">
                    add
                    </span>
                </button>        
            </div>
            </div>';
}
function firstRadiobutton($type) {
        echo '<button id="add_answer" value="'.$type.'" class="btn btn-success mt-2 w-100" title="Добавить вариант ответа" style="height: 38px">
                    <span class="material-icons">
                    add
                    </span>
                </button>    
            </div>
            </div>';
}




$test = $sql->query("SELECT * FROM test WHERE id ='$test_id'");
?>

    <div id="lector_edit_test" value ="<?=$test_id?>" class="jumbotron p-1 mb-3 p-md-2 text-white d-flex align-items-center"
         style="background: #2D3142 !important;">
        <button id="goBack" class="btn btn-outline-light d-flex" style="align-self: stretch" title="Назад">
        <span class="material-icons d-flex warning">
            backspace
        </span>
        </button>
            <div class="col justify-content-between px-0 pl-2 font-italic d-flex">
                <p class="h2">Редактирование теста</p>
            </div>
    </div>
    <div class="container">
        <div class="p-3 bg-white rounded shadow-sm">
            <div class="">
                <h4 id="testTitleHeader" class="">Тест:</h4>
                <div class="d-flex justify-content-between align-items-baseline">
                    <h3>"<?= $test->fetch_assoc()['title']?>"
                        <button id="editTitle" class="btn btn-outline-secondary">
                        <span class="material-icons">
                        create
                        </span>
                        </button>
                    </h3>
                    <button id="saveTest" class="btn btn-warning mr-5">Сохранить</button>
                </div>
            </div>
            <script>
                let title = "<?= $sql->query("SELECT * FROM test WHERE id = '$test_id'")->fetch_assoc()['title']?>";
                $(document).on('click','#editTitle',function () {
                    $('#testTitleHeader').parent('div').children('div').html('<div id="saveTitleHeader" class="input-group btn-group">'+
                                    '<input type="text" class="form-control form-control-lg" id="newTestTitle">' +
                                    '<button id="saveTitle" class="btn btn-outline-warning" style="max-inline-size: fit-content">' +
                            '                        <span class="material-icons">' +
                            '                        save' +
                            '                        </span>' +
                            '                    </button>'+
                                '</div>');
                    $('#newTestTitle').val(title);
                })

                $(document).on('click','#saveTitle',function () {
                    title = $('#newTestTitle').val();
                    $.get(
                        "change_title.php",
                        {test: <?= $test_id?>,
                         title: title},
                        function (html) {
                            $('#testTitleHeader').parent('div').children('div').html(html);
                        }
                    )
                    $("#saveTitleHeader").remove();
                })

            </script>

<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
            <div class="d-flex justify-content-between">
                <div class="form-group">
                    <label for="answerTime">Укажите время</label>
                    <input type="range" class="form-control-range mb-1" id="answerTime" min="0.5" max="3" step="0.1" value="1.5">
                    <label for="answerTime" id="time"></label>
                </div>
            </div>
<?php
    $questionId = $sql->query("SELECT * FROM test_question WHERE test_id = '$test_id'");
    while ($testQuestion = $questionId->fetch_assoc())
    {
        $question = $sql->query("SELECT * FROM question WHERE id = '".$testQuestion["question_id"]."'")->fetch_assoc();
        $answer
?>
            <div id="addTest_form" class="bg-white rounded shadow-sm mt-3 p-3 addTest_form" value="<?= $question['id']?>">
                <h5 class="">Вопрос</h5>
                <div id="questionForm" class="form-group">
                    <label for="question">Введите вопрос:</label>
                    <textarea required class="form-control" id="question" rows="2"><?=$question['title']?></textarea>
                </div>

                <div id="TypeForm" class="form-group">
                    <label for="questionType">Тип вопроса:</label>
                    <select id='questionType' required class="form-control">
                        <?php $questionType = $sql->query("SELECT * FROM question_type");
                        while ($type = $questionType->fetch_assoc())
                        {
                            if ( $type['id'] == $question['question_type'])
                                $qType = 'selected';
                            else
                                $qType = '';
                            echo "<option value='" . $type['id'] . "' ".$qType.">" . $type['type'] . "</option>";
                        }
                        ?>
                    </select>

                <div id="answers">
                    <?php
                    $qType = $question['question_type'];
                    $answer = $sql->query("SELECT * FROM answer WHERE id = '".$question['answer_id']."'")->fetch_assoc()['answers'];
                    $answer = json_decode($answer,true);
                    questionHeader();
                    foreach ($answer as $key => $item){
                        $text = ($answer[$key]['answer']['text']);
                        if ($answer[$key]['answer']['correct'] == true) {
                            $check = "active";
                            $checked = "checked";
                        }
                        else {
                            $check = "";
                            $checked = "";
                        }
                        if ($key < 2)
                            $close = '';
                        else
                            $close = $closeButton;
                            switch ($qType) {
                                case 2:
                                    checkbox($text,$check,$checked ,$close);
                                    break;
                                case 1:
                                    radiobutton($text,$check,$checked,$close);
                                    break;
                            }
                    }
                    switch ($qType){
                        case 2:
                            firstCheckbox($qType);
                            break;
                        case 1:
                            firstRadiobutton($qType);
                            break;
                    }

                    ?>
                </div>
                </div>
            </div>

    <?php }?>
            <div class="m-3 d-flex" style="justify-content: space-between;">
                <button id="addQuestion" class="btn btn-outline-success mr-2">Добавить вопрос</button>
                <button id="saveTest" class="btn btn-warning">Сохранить</button>
            </div>
        </div>
    </div>

    <div id="checkPost"></div>

    <script>

        let lastQuestion;
        var testId;
        let timer = parseFloat($('#answerTime').val()) * 60 * 1000;
        let date = new Date(timer);
        let mm = date.getUTCMinutes();
        let ss = date.getSeconds();
        if (mm < 10) {mm = "0"+mm;}
        if (ss < 10) {ss = "0"+ss;}
        let t = mm+":"+ss;
        $(document).ready(function () {
            $('#time').text("Времени на ответ : "+t);

            $(document).on('input','#answerTime',function () {
                timer = parseFloat($('#answerTime').val()) * 60;
                date.setSeconds(timer);
                date.setMinutes(timer / 60);
                mm = date.getMinutes();
                ss = date.getSeconds();
                if (mm < 10) {mm = "0"+mm;}
                if (ss < 10) {ss = "0"+ss;}
                let t = mm+":"+ss;
                $('#time').text("Времени на ответ : "+t);
            })

            let done = '';
            $(".addTest_form #questionType").each(function (e) {
                let element = this;
                let questionSum = $(this).parent().parent().attr('value');
                let elementValue = $('option:selected',this).attr('value');
                console.log(questionSum);
                $.ajax({
                    url: "../test_ajax/selected_type.php",
                    data: "type="+elementValue,
                    success: function (html) {
                        $(element).parent().next("#answers").html(html);
                    },
                    error:  function (jqXHR, textStatus, errorThrown) {
                        console.log('Ответ не получен ' + jqXHR + " " + textStatus + " " + errorThrown);
                    }
                })

            });

            $(document).on('click', '#goBack', function () {
                $("#main").html("" +
                    "        <div id=\"loadPage\" class=\"spinner-grow text-dark\" role=\"status\" style=\"margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;\">\n" +
                    "            <span class=\"sr-only\">Loading...</span>\n" +
                    "        </div>");
           window.location.replace("../course_test.php?course_id=<?=$course_id?>&success="+done);
            })


            $(document).on('click','#addQuestion', function () {
                $.ajax({
                    url:"../test_ajax/add_test_form.php",
                    success: function (html) {
                        $("#addQuestion").parent().before(html);
                    }
                })
            })

            $(document).on('click','#close',function () {
                $(this).parent("h5").parent("div #addTest_form").remove();
            })

            $(document).on('change','#questionType',function (e) {
                $.ajax({
                    url: "../test_ajax/selected_type.php",
                    data: "type="+$("option:selected",this).attr('value'),
                    success: function (html) {
                        $(e.target).parent().next("#answers").html(html);
                    },
                    error:  function (jqXHR, textStatus, errorThrown) {
                        console.log('Ответ не получен ' + jqXHR + " " + textStatus + " " + errorThrown);
                    }
                })
            })

            $(document).on('click','#add_answer',function (e) {
                let answerType = $(this).attr('value');
                $.ajax({
                    url: "../test_ajax/selected_type.php",
                    data: "addAnswer="+answerType,
                    success: function (html) {
                        $(e.target).before(html);
                    },
                    error:  function (jqXHR, textStatus, errorThrown) {
                        console.log('Ответ не получен ' + jqXHR + " " + textStatus + " " + errorThrown);
                    }
                })
            })

            $(document).on('click','#deleteAnswer',function (e) {
                $(this).parent(".Answer").remove();
            })



            $(document).on('click','#saveTest',function () {

                /* ------------------------- цикл для ввода всех вопросов --------------------------- */
                $(".addTest_form").each(function () {

                    let iter = 0;
                    let answer = [];

                    $(".Answer",this).each(function(){
                        answer [iter] = {
                            id : iter,
                            answer : {
                                img: null,
                                text: $(".textAnswer",this).val(),
                                correct: $("#correctAnswer",this).hasClass("active")
                            }
                        }
                        iter++;
                    })
                    answer = JSON.stringify(answer);
                    let questionType = parseInt($("#questionType option:selected",this).attr('value'));
                    let testId = parseInt($('#lector_edit_test').attr('value'));
                    let questionId = parseInt($(this).attr('value'));
                    if (isNaN(questionId)) questionId = null;
                    console.log(answer);
                    $.get(
                        'save_changes.php',
                        {
                            questionId: questionId,
                            testId: testId ,
                            question: $("#question",this).val(),
                            questionType: questionType,
                            answer: answer
                        },
                        function (json) {
                            console.log(json);
                        }
                    );
                })
                done = 'done';
                $("#goBack").click();
            });
        });
    </script>
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Footer.php";

