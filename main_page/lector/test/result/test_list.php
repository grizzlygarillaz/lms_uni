<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
session_start();

$user = $_SESSION['user_id'];
$userRole = $sql->query("SELECT * FROM role JOIN user_role ON role_d = role.id WHERE user_id = '$user'")->fetch_assoc()['id'];
$userRole = intval($userRole);
if ($userRole != 1 and $userRole != 3)
    exit("<meta http-equiv='refresh' content='0; url=http://tisbi-lms.ru/main_page/student.php'>");

?>
    <div id="lector_add_course" class="jumbotron p-4 mb-3 p-md-2 text-white" style="background: #2D3142 !important;)">
        <div class="col-md-8 px-0">
            <h1 class="display-6 font-italic pl-4">Список доступных тестов</h1>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 justify-content-sm-start justify-content-center">

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


    <script>
        $(document).ready(function () {
            $(document).on('click','#test_edit button',function () {
                window.location.href = "all_test.php?course_id="+$(this).val();
            })

        });
    </script>

<?php
$sql->close();
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Footer.php";