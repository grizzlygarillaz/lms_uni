<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
?>

<?php

?>

    <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="modal-body " style="text-align: center;">
                    Вы действительно хотите удалить эту лекцию?
                </div>
                <div class="modal-footer mx-auto " style="text-align: center;">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Нет</button>
                    <button type="button" id="del" class="btn btn-outline-danger">Да</button>
                </div>
            </div>
        </div>
    </div>


    <div id="lector_mod" value="<?php echo $_GET['id'] ?>" class=" mb-3" role="group" aria-label="Basic example">
        <button id="editc" type="button" class="btn btn-warning ">Редактировать</button>
        <button id="save" type="button" class="btn btn-secondary ">Сохранить</button>
        <a href="./course/student_control.php?idm=<?php echo $_GET['id'] ?> " type="button" class="btn btn-outline-dark">
            Управление участниками </a>
    </div>

<?php
//$course_content = $sql->query("SELECT * FROM " );
$rest = $sql->query("SELECT * FROM course where course_id= 2");
$con = $rest->fetch_assoc();

$id_category = @$sql->query("SELECT category_title FROM category WHERE code_category ='" . $con['category'] . "'  ");
$category = $id_category->fetch_assoc();


$id_lector = $sql->query("SELECT f_name, l_name FROM users WHERE id = '" . $con['lector'] . "' ");
$course_lector = $id_lector->fetch_assoc();
?>

    <div id="lector_edit" class="jumbotron p-4 mb-2 p-md-2 text-white bg-dark">
        <!--    <img alt="Описание изображения" src="course/cover/2.png" >-->
        <div id="content" class="col-md-8 px-0">
            <h1 id="full_name" class="display-6 font-italic"> <?php echo $con['full_name']; ?>    </h1>
            <hr class="my-4">
            <p id="description" class="text-muted"> <?php echo $con['description']; ?>    </p>

        </div>
        <p class="font-weight-normal"><a href="#"
                                         class="text-white font-weight-light"> <?php echo $category['category_title']; ?>     </a>
        </p>
        <!------------------------------------------------------------------     КНОПКА ТЕСТА ДЛЯ КУРСА    ------------------------------------------------------------------>
        <?php
        function courseTest($testId, $testTitle, $testEndTime = null)
        {
            echo '
            <div class="bg-light rounded-lg d-flex p-0">
                <a class="btn btn-outline-secondary pl-4 w-100 d-flex justify-content-between" href="lector_test.php?t_id=' . $testId . '" style="text-align: left">
                <div>
                    <p class="h3">Тест курса:</p>
                    <p class="h2">"' . $testTitle . '"</p>';
            if (!is_null($testEndTime))
                echo '<p class="mb-1">Завершается: ' . DateTime::createFromFormat('Y-m-d H:i:s', $testEndTime)->format('d.m.y H:i') . '</p>';
            echo ' </div>
                <button class="btn text-light" style="width: 15%; background: #6C757D">Пройти</button>
                </a>
            </div>';
        }

        $courseId = $_GET["id"];
        $testCourse = $sql->query("SELECT * FROM test WHERE course_id = '$courseId'");
        $testC = $testCourse->fetch_assoc();
        if (($testCourse)->num_rows > 0)
            if (strtotime($testC['startDate']) == false and strtotime($testC['endDate']) == false)
                courseTest($testC['id'], $testC['title']);

            elseif (strtotime($testC['startDate']) == true and (strtotime($testC['startDate']) <= strtotime($_SESSION['time']))
                and strtotime($testC['endDate']) == false)
                courseTest($testC['id'], $testC['title']);

            elseif (strtotime($testC['endDate']) == true and (strtotime($testC['endDate']) >= strtotime($_SESSION['time']))
                and strtotime($testC['startDate']) == false) {
                courseTest($testC['id'], $testC['title'], $testC['endDate']);
            } elseif (strtotime($testC['endDate']) == true and (strtotime($testC['endDate']) >= strtotime($_SESSION['time']))
                and strtotime($testC['startDate']) == true and (strtotime($testC['startDate']) <= strtotime($_SESSION['time'])))
                courseTest($testC['id'], $testC['title'], $testC['endDate']);
        ?>
        <!-------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    </div>

    <!-- Кнопочка зеленая-->
    <div class="list-group list-group-horizontal-sm">

        <div class="list-group   w-100 mr-md-3">
            <h4 style="margin-left: 10px"> Лекции: </h4>
            <a href="course/add_lecture.php?id=<?php echo $_GET[id] ?>" class="list-group list-group-horizontal m-2">
                <button type="button_add" class="btn btn-outline-success d-flex " title="Добавить лекию"
                        style="width: 100%" onclick="">
                    <div class="text-center mx-auto">
                        <svg id="i-plus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="40" height="40"
                             fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round"
                             stroke-width="2">
                            <path d="M16 2 L16 30 M2 16 L30 16"/>
                        </svg>
                    </div>
                </button>

            </a>
            <!--  Темы      -->

            <?php
            $topic = $sql->query("SELECT * from lecture  Where course_id =2 ");
            while ($row = $topic->fetch_assoc()) {

                ?>

                <div class="list-group list-group-horizontal m-2">
                    <button type="button" id="del_lecture" data-toggle="modal"
                            data-target="#staticBackdrop" class="btn btn-link"
                            value="<? echo $row['lecture_id'] ?>"
                            title="Удалить курс" style="padding: 1px;">
                            <span class="material-icons" style="color: #cc0000">delete_forever
                                </span>
                    </button>

                    <a id="lector_edit_left" href="lecture.php?idl=<?php echo $row['lecture_id'] ?> "
                       class="list-group-item list-group-item-action ">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"> <?php print $row['title'] ?>      </h5>

                        </div>
                        <p class="mb-1"> <?php echo $row['description'] ?>    </p>
                    </a>


                    <?php

                    function testInfo($testId, $testTitle, $testEndTime = null)
                    {
                        echo '
                        <a class="list-group-item list-group-item-action w-25 bg-light" methods="get" href="lector_test.php?t_id=' . $testId . '" style="padding: 12px 12px!important">
                           <h5 class="mb-1">Тест</h5>
                           <p>"' . $testTitle . '"</p>';
                        if (!is_null($testEndTime))
                            echo '<p class="m-0 text-sm"><small>Завершается: ' . DateTime::createFromFormat('Y-m-d H:i:s', $testEndTime)->format('d.m.y H:i') . '</small></p>';
                        echo '</a>';
                    };
                    $testQuery = $sql->query("SELECT * FROM test WHERE lecture_id ='" . $row['lecture_id'] . "'");
                    $test = $testQuery->fetch_assoc();
                    if ($testQuery->num_rows > 0) {
                        if (strtotime($test['startDate']) == false and strtotime($test['endDate']) == false)
                            testInfo($test['id'], $test['title']);

                        elseif (strtotime($test['startDate']) == true and (strtotime($test['startDate']) <= strtotime($_SESSION['time']))
                            and strtotime($test['endDate']) == false)
                            testInfo($test['id'], $test['title']);

                        elseif (strtotime($test['endDate']) == true and (strtotime($test['endDate']) >= strtotime($_SESSION['time']))
                            and strtotime($test['startDate']) == false)
                            testInfo($test['id'], $test['title'], $test['endDate']);

                        elseif (strtotime($test['endDate']) == true and (strtotime($test['endDate']) >= strtotime($_SESSION['time']))
                            and strtotime($test['startDate']) == true and (strtotime($test['startDate']) <= strtotime($_SESSION['time'])))
                            testInfo($test['id'], $test['title'], $test['endDate']);

                    } ?>

                </div>
            <?php } ?>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(document).on('click', '#editc', function () {
                let full_name = document.getElementById('full_name').textContent,
                    description = document.getElementById('description').textContent,
                    id = $('#lector_mod').attr('value');


                $.ajax({
                    method: "POST",
                    url: "edit_course.php",
                    data: 'full_name=' + full_name + '&description=' + description + '&idcourse=' + id,
                    success: function (html) {
                        $('#content').html(html);
                        $('#editc').prop('disabled', true);
                        $('#save').prop('disabled', false);
                        $('#save').addClass('btn btn-success');
                    }
                })
            });
            $(document).on('click', '#save', function () {
                let course_name = $('#course_name').val(),
                    desc = $('#desc').val(),
                    course_id = document.getElementById('idc').textContent;
                console.log(course_name, desc);
                $.ajax({

                    method: "POST",
                    url: "course/save_course.php",
                    data: 'full_name=' + course_name + '&des=' + desc + '&course_id=' + course_id,
                    success: function (html) {
                        console.log('OK');
                        $('#content').html(html);
                        $('#save').addClass('btn btn-secondary');
                        $('#editc').prop('disabled', false);
                        $('#save').prop('disabled', true);

                    }
                })
            });
            $(document).on('click', '#del_lecture', function () {
                let id = $(this).attr('value');
                console.log(id);
                $(document).on('click', '#del', function () {
                    $.ajax({
                        method: "POST",
                        data: 'id=' + id,
                        url: "course/del_lecture.php",
                        success: function () {
                            $('#staticBackdrop').modal('hide');
                            window.location.reload();
                            console.log(id);
                        }

                    })
                })

            });
        })
    </script>


<?php

include $_SERVER['DOCUMENT_ROOT'] . "/templates/Footer.php"; ?>