<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
session_start();
$user = $_SESSION['user_id'];
$course_id = $_GET['course_id'];
$course = $sql->query("SELECT * FROM course WHERE course_id ='$course_id'");
?>
    <div id="fine-uploader-manual-trigger"></div>
    <div id="lector_add_course" class="jumbotron p-4 mb-3 p-md-2 text-white d-flex align-items-center"
         style="background: #2D3142 !important;">
        <button id="goBack" class="btn btn-outline-light d-flex" style="align-self: stretch" title="Назад">
        <span class="material-icons d-flex warning">
            backspace
        </span>
        </button>
        <div class="col-md-8 px-0 pl-2 font-italic">
            <h1 class="display-6">Новый тест</h1>
        </div>
    </div>
    <div class="container">
        <div class="p-3 bg-white rounded shadow-sm">
            <div class="">
            <h5 class="">Тестирование</h5>

            </div>
            <div class="form-group">
                <?php
                if (is_null($course_id)) {
                    echo '<label for="course">Курс:</label>
                <select id="course" required class="form-control mb-1">
                    <option disabled selected>Выберите курс</option>';
                    $courseQuery = $sql->query("SELECT * FROM course WHERE lector = '$user'");
                    while ($course = $courseQuery->fetch_assoc()) {
                        $testExist = $sql->query("SELECT * FROM test WHERE course_id = '" . $course['course_id'] . "'")->fetch_assoc();
                        if (is_null($testExist))
                            $existing = 'contain = "false"';
                        else
                            $existing = 'contain = "true"';
                        echo "<option " . $existing . " value='" . $course['course_id'] . "'>" . $course['short_name'] . "</option>";
                    }
                    echo '</select>
                    <script>
                        $(document).ready(function() {
                          $(document).on("change","#course",function() {
                             $.ajax({
                             url: "test_ajax/add_lecture.php",
                             data: "course_id="+$("#course option:selected").attr("value"),
                             success: function(html) {
                               $("#lecture").html(html);
                             }
                             })
                          })
                        })
                    </script>
                    ';
                }
                    ?>
                <label for="lecture">Тест для лекции:</label>
                <select id='lecture' required class="form-control">
                    <option disabled selected>Выберите лекцию</option>
                    <?php $lectureQuery = $sql->query("SELECT * FROM lecture WHERE course_id = '$course_id'");
                    while ($lecture = $lectureQuery->fetch_assoc())
                    {
                        $testExist = $sql->query("SELECT * FROM test WHERE lecture_id = '" . $lecture['lecture_id'] . "'")->fetch_assoc();
                        if (is_null($testExist))
                            $existing = 'contain = "false"';
                        else
                            $existing = 'contain = "true"';
                        echo "<option ".$existing." value='" . $lecture['lecture_id'] . "'>" . $lecture['title'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="testTitle">Название теста:</label>
                <textarea required class="form-control" id="testTitle" rows="2"></textarea>
            </div>


            <div class="container">
                <div class="row align-items-center">
                    <div class="col-sm">
                        <input type="text" class="form-control" id="startTime" style="align-self: self-start; width: 155px"/>
                        <div class="btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-outline-warning">
                                <input type="checkbox" autocomplete="off">Начало
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <input type="text" class="form-control" id="endTime" style="align-self: self-start; width: 155px"/>
                        <div class="btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-outline-warning">
                                <input type="checkbox" autocomplete="off">Завершение
                            </label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <label for="answerTime">Укажите время</label>
                        <input type="range" class="form-control-range mb-1" id="answerTime" min="0.5" max="3" step="0.1" value="1.5">
                        <label for="answerTime" id="time"></label>
                    </div>
                </div>
            </div>

            <div id="addTest_form" class="bg-white rounded shadow-sm mt-3 p-3 addTest_form" value="1">
            <h5 class="">Вопрос</h5>
            <div id="questionForm" class="form-group">
                <label for="question">Введите вопрос:</label>
                <textarea required class="form-control" id="question" rows="2"></textarea>
            </div>

            <div id="TypeForm" class="form-group">
                <label for="questionType">Тип вопроса:</label>
                <select id='questionType' required class="form-control">
                    <option disabled selected>Выберите тип</option>
                    <?php $questionType = $sql->query("SELECT * FROM question_type");
                    while ($type = $questionType->fetch_assoc())
                    {
                        echo "<option value='" . $type['id'] . "'>" . $type['type'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div id="answers">

            </div>
        </div>

        <div class="m-3 d-flex" style="justify-content: space-between;">
            <button id="addQuestion" class="btn btn-outline-success mr-2">Добавить вопрос</button>
            <button id="saveTest" class="btn btn-warning" data-toggle="modal" data-target="#loadTestSpinner">Сохранить</button>
        </div>
    </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Данная лекция уже содержит тест!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Хотите перейти к редактированию?</h5>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary mr-5" data-dismiss="modal">Нет</button>
                    <button id="goEdit" type="button" class="btn btn-warning">Да</button>
                </div>
            </div>
        </div>
    </div>
    <div id="checkPost"></div>
    <div class="modal fade" id="loadTestSpinner" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Пожалуйста, подождите</h5>
                </div>
                <div class="modal-body" style="height: 8rem">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="height: 2rem">
                </div>
            </div>
        </div>
    </div>
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

            $.datetimepicker.setLocale('ru');

            $('#time').text("Времени на один ответ : "+t);
            $(document).on('input','#answerTime',function () {
            timer = parseFloat($('#answerTime').val()) * 60;
            date.setSeconds(timer);
            date.setMinutes(timer / 60);
            mm = date.getMinutes();
            ss = date.getSeconds();
            if (mm < 10) {mm = "0"+mm;}
            if (ss < 10) {ss = "0"+ss;}
            let t = mm+":"+ss;
            $('#time').text("Времени на один ответ : "+t);
        })
            $('#startTime').datetimepicker({
                format:'Y/m/d H:i',
                onShow: function () {
                    this.setOptions({
                        maxDate: $('#endTime').val()
                    })
                }
            });


            $('#trigger-upload').click(function() {
                $('#fine-uploader-manual-trigger').fineUploader('uploadStoredFiles');
            });

            $('#endTime').datetimepicker({
                format:'Y/m/d H:i',
                onShow: function () {
                    this.setOptions({
                        minDate:$('#startTime').val()
                    })
                }
                });


            let done = '';
            $(document).on('click', '#goBack', function () {
                $("#main").html("" +
                    "        <div id=\"loadPage\" class=\"spinner-grow text-dark\" role=\"status\" style=\"margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;\">\n" +
                    "            <span class=\"sr-only\">Loading...</span>\n" +
                    "        </div>");
                window.location.replace("course_test.php?course_id=<?=$course_id?>&success="+done);
            })

            $(document).on('click','#goEdit',function () {
                window.location.replace("edit/test_edit.php?course=<?=$course_id?>");
            })

            $(document).on('change','#lecture',function () {
                if ($("#lecture option:selected").attr('contain') == "true") {
                    $("#exampleModal").modal();
                    $('#lecture option:first').prop('selected', true);
                }
            })

            $(document).on('click','#addQuestion', function () {
                $.ajax({
                    url:"test_ajax/add_test_form.php",
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
                    url: "test_ajax/selected_type.php",
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
                    url: "test_ajax/selected_type.php",
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
                $.get(
                    'test_ajax/save_test.php',
                {
                    lecture: $('select#lecture option:selected').attr('value'),
                    testTitle: $('#testTitle').val()
                },
                    function (html) {
                        $('#check').html(html);
                    }
                )

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
                    let lectureId = parseInt($('select#lecture option:selected').attr('value'));

                    $.get(
                        'test_ajax/save_question.php',
                    {
                        lectureId: lectureId,
                        question: $("#question",this).val(),
                        questionType: questionType,
                        answer: answer
                    },
                        function (json) {
                            console.log(json);
                        }
                    );
                    done = 'done';
                })
                $('#goBack').click();
            });
        });
    </script>
<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Footer.php";
