<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
session_start();
$course_id = $_GET['course_id'];
$user = $_SESSION['user_id'];

$course = $sql->query("SELECT * FROM course WHERE course_id ='$course_id'");
?>
    <div id="lector_add_course" class="jumbotron p-1 mb-3 p-md-2 text-white d-flex align-items-center" style="background: #2D3142 !important;">
        <button id="goBack" class="btn btn-outline-light " style="align-self: stretch" title="Назад">
            <span class="material-icons d-flex warning">
                backspace
            </span>
        </button>
        <div class="col-md-8 px-0 pl-2 font-italic">
            <h1 class="display-6">Управление тестами</h1>
            <h2>Курс : "<?echo $course->fetch_assoc()['short_name']?>"</h2>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 justify-content-sm-start justify-content-center">

        <div id="test_edit_add" class="col mb-4 " style="max-width: 17rem; height: 16rem; min-width: 17rem;">
            <a class="card h-100 ">
                <button id="addTest" class="btn btn-outline-success h-100" data-toggle="modal" data-target="#addTestChoose">

                    <svg id="i-plus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="60" height="60" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M16 2 L16 30 M2 16 L30 16" />
                    </svg>
                </button>
            </a>
        </div>

        <?php
        $lectorCourses = $sql->query("SELECT * FROM course WHERE lector = '$user' AND course_id='$course_id'");
        while ($lectorCourse = $lectorCourses->fetch_array()) {
            $lectorTests = $sql->query("SELECT * FROM test WHERE course_id ='$course_id'");
            if (!is_null($lectorTests->fetch_assoc()['id'])) {
                echo '
                      <div id="test_edit" class="col mb-4" style="max-width: 17rem; height: 16rem; min-width: 17rem;">
                            <button class="btn btn-outline-dark w-100 h-100" 
                            value="'.$sql->query("SELECT * FROM test WHERE course_id='".$lectorCourse["course_id"]."'")->fetch_assoc()['id'].'">
                                <div class=" bg-light rounded " style="padding: 1rem">
                                    <rect width="100%" height="100%" fill="#55595c">
                                        <div class="full_name">
                                            <h5 style="color: #2D3142">Тест курса:</h5>
                                        </div>
            
                                    </rect>
                                </div>
                                <div class="card-body  ">
                                    <h5 class="coursecontent " style="max-width: 100%; height: 100%; ">
                                    "' . mb_strimwidth($sql->query("SELECT * FROM test WHERE course_id = '$course_id'")->fetch_assoc()["title"],
                        0, 50, "...") . '"
                                    </h5>
                                </div>
                            </button>
                      </div>
                ';
                $lectorLectures = $sql->query("SELECT * FROM lecture WHERE course_id = '$course_id'");
                while ($lecture = $lectorLectures->fetch_assoc()) {
                    $lectureTest = $sql->query("SELECT * FROM test WHERE lecture_id = '" . $lecture['lecture_id'] . "'");
                    if (!is_null($lectureTest->fetch_assoc()['id'])) {
                        echo '
                      <div id="test_edit" class="col mb-4" style="max-width: 17rem; height: 16rem; min-width: 17rem;">
                            <button class="btn btn-outline-dark w-100 h-100" 
                            value="'.$sql->query("SELECT * FROM test WHERE lecture_id='".$lecture['lecture_id']."'")->fetch_assoc()['id'].'">
                                <div class=" bg-light rounded " style="padding: 1rem">
                                    <rect width="100%" height="100%" fill="#55595c">
                                        <div class="full_name"  style="color: #2D3142">
                                            <h5>Тест лекции:</h5>
                                            <h6>'.mb_strimwidth($lecture['title'],
                                0, 40, "...") .'</h6>
                                        </div>
                                    </rect>
                                </div>
                                <div class="card-body  ">
                                    <h5 class="coursecontent " style="max-width: 100%; height: 100%; ">
                                    "' . mb_strimwidth($sql->query("SELECT * FROM test WHERE lecture_id = '".$lecture['lecture_id']."'")->fetch_assoc()["title"],
                                0, 50, "...") . '"
                                    </h5>
                                </div>
                            </button>
                      </div>
                ';
                    }
                }
            }
            else {
                $lectorLectures = $sql->query("SELECT * FROM lecture WHERE course_id = '$course_id'");
                while ($lecture = $lectorLectures->fetch_assoc()) {
                    $lectureTest = $sql->query("SELECT * FROM test WHERE lecture_id = '" . $lecture['lecture_id'] . "'");
                    if (!is_null($lectureTest->fetch_assoc()['id'])) {
                        echo '
                      <div id="test_edit" class="col mb-4" style="max-width: 17rem; height: 16rem; min-width: 17rem;">
                            <button class="btn btn-outline-dark w-100 h-100" 
                            value="'.$sql->query("SELECT * FROM test WHERE lecture_id='".$lecture['lecture_id']."'")->fetch_assoc()['id'].'">
                                <div class=" bg-light rounded " style="padding: 1rem">
                                    <rect width="100%" height="100%" fill="#55595c">
                                        <div class="full_name"  style="color: #2D3142">
                                            <h5>Тест лекции:</h5>
                                            <h6>'.mb_strimwidth($lecture['title'],
                                0, 40, "...") .'</h6>
                                        </div>
                                    </rect>
                                </div>
                                <div class="card-body  ">
                                    <h5 class="coursecontent " style="max-width: 100%; height: 100%; ">
                                    "' . mb_strimwidth($sql->query("SELECT * FROM test WHERE lecture_id = '".$lecture['lecture_id']."'")->fetch_assoc()["title"],
                                0, 50, "...") . '"
                                    </h5>
                                </div>
                            </button>
                      </div>
                ';
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

    <div id="toast"  aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center fixed-top" style="min-height: 200px; margin-top: 1%">

        <!-- Then put toasts within -->
        <div class="toast" role="alert" aria-live="assertive" data-delay="1500" aria-atomic="true">
            <div class="toast-header">
                <strong class="mr-auto">Сохранение</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Данные успешно сохранены!!!
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let done = "<?=$_GET['success']?>";
            if (done == 'done'){
                $('.toast').toast('show');

                $('.toast').on('hidden.bs.toast',function () {
                    $('.toast').remove();
                    $('#toast').remove();
                })
            }else {
                $('.toast').remove();
                $('#toast').remove();
            }

            $(document).on('click','#addToCourse',function () {
                $("#main").html("" +
                    "        <div id=\"loadPage\" class=\"spinner-grow text-dark\" role=\"status\" style=\"margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;\">\n" +
                    "            <span class=\"sr-only\">Loading...</span>\n" +
                    "        </div>");
                window.location.href = "add_test_course.php?course_id=<?echo $course_id?>";
            })

            $(document).on('click','#addToLecture',function () {
                $("#main").html("" +
                    "        <div id=\"loadPage\" class=\"spinner-grow text-dark\" role=\"status\" style=\"margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;\">\n" +
                    "            <span class=\"sr-only\">Loading...</span>\n" +
                    "        </div>");
                window.location.href = "add_test_lecture.php?course_id=<?echo $course_id?>";
            })

            $(document).on('click','#goBack',function () {
                $("#main").html("" +
                    "        <div id=\"loadPage\" class=\"spinner-grow text-dark\" role=\"status\" style=\"margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;\">\n" +
                    "            <span class=\"sr-only\">Loading...</span>\n" +
                    "        </div>");
                window.location.href = "test_list.php";
            })

            $(document).on('click','#test_edit',function () {
                window.location.href="edit/test_edit.php?test_id="+$(this).children('button').attr('value')+"&course="+<?=$course_id?>;
            })
            setTimeout(function(){
                $('.toast').remove();
                $('#toast').remove();
            }, 3000);
        });
    </script>

<?php
include $_SERVER['DOCUMENT_ROOT']."/templates/Footer.php";
