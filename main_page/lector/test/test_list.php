<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
session_start();

$user = $_SESSION['user_id'];

?>
    <div id="lector_add_course" class="jumbotron p-4 mb-3 p-md-2 text-white" style="background: #2D3142 !important;)">
        <div class="col-md-8 px-0">
            <h1 class="display-6 font-italic pl-4">Управление тестами</h1>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 justify-content-sm-start justify-content-center">

        <div id="addTest" class="col mb-4" style="max-width: 20rem; height: 12rem; min-width: 20rem;">
            <a class="card h-100 ">
                <button id="addTest" class="btn btn-outline-success h-100" data-toggle="modal" title="Добавить тестирование" data-target="#addTestChoose">

                    <svg id="i-plus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="60" height="60" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M16 2 L16 30 M2 16 L30 16" />
                    </svg>
                </button>
            </a>
        </div>

        <?php
        $lectorCourses = $sql->query("SELECT * FROM course WHERE lector = '$user'");
        while ($lectorCourse = $lectorCourses->fetch_array()) {
            $lectorTests = $sql->query("SELECT * FROM test WHERE course_id ='" . $lectorCourse['course_id'] . "'");
            if (!is_null($lectorTests->fetch_assoc()['id'])) {
                echo '
                      <div id="test_edit" class="col mb-4" style="max-width: 20rem; height: 12rem; min-width: 20rem;">
                            <button class="btn btn-outline-dark h-100" value="'.$lectorCourse['course_id'].'">
                                <div class=" bg-light rounded " style="padding: 1rem">
                                    <rect width="100%" height="100%" fill="#55595c">
                                        <div class="full_name">
                                            <h5 style="color: #2D3142">Тесты из курса:</h5>
                                        </div>
            
                                    </rect>
                                </div>
                                <div class="card-body  ">
                                    <h5 class="coursecontent " style="max-width: 100%; height: 100%; ">
                                    "' . mb_strimwidth($sql->query("SELECT * FROM course WHERE course_id = '" . $lectorCourse['course_id'] . "'")->fetch_assoc()["short_name"],
                                    0, 50, "...") . '"
                                    </h5>
                                </div>
                            </button>
                      </div>
                ';
            }
            else {
                $lectorLectures = $sql->query("SELECT * FROM lecture WHERE course_id = '" . $lectorCourse['course_id'] . "'");
                while ($lecture = $lectorLectures->fetch_assoc()) {
                    $lectureTest = $sql->query("SELECT * FROM test WHERE lecture_id = '" . $lecture['lecture_id'] . "'");
                    if (!is_null($lectureTest->fetch_assoc()['id'])) {
                        echo '
                      <div id="test_edit" class="col mb-4" style="max-width: 20rem; height: 12rem; min-width: 20rem;">
                            <button class="btn btn-outline-dark h-100" value="'.$lectorCourse['course_id'].'">
                                <div class=" bg-light rounded " style="padding: 1rem">
                                    <rect width="100%" height="100%" fill="#55595c">
                                        <div class="full_name">
                                            <h5 style="color: #2D3142">Тесты из курса:</h5>
                                        </div>
            
                                    </rect>
                                </div>
                                <div class="card-body  ">
                                    <h5 class="coursecontent " style="max-width: 100%; height: 100%; ">
                                    "' . mb_strimwidth($sql->query("SELECT * FROM course WHERE course_id = '" . $lectorCourse['course_id'] . "'")->fetch_assoc()["short_name"],
                                0, 50, "...") . '"
                                    </h5>
                                </div>
                            </button>
                      </div>
                ';
                        break;
                    }
                }
            }
        }



        ?>
    </div>

    <div class="modal fade" id="addTestChoose" tabindex="-1" role="dialog" aria-labelledby="testType" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="width: 90%">
                <div class="modal-header">
                    <h4 class="modal-title" id="testType">Добавить тест</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Куда хотите добавить тест?</h5>
                </div>
                <div class="modal-footer" style="justify-content: space-around;">
                    <div>
                        <button id="addToCourse" type="button" class="btn btn-warning mr-2">Курс</button>
                        <button id="addToLecture" type="button" class="btn btn-warning">Лекция</button>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
           $(document).on('click','#test_edit button',function () {
                window.location.href = "course_test.php?course_id="+$(this).val();
           })

            $(document).on('click','#addToCourse',function () {
                window.location.href = "add_test_course.php";
            })

            $(document).on('click','#addToLecture',function () {
                window.location.href = "add_test_lecture.php";
            })
        });
    </script>

<?php
$sql->close();
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Footer.php";