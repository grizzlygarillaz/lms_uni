<?php
include $_SERVER['DOCUMENT_ROOT']."/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT']. "/SQL/sql_connect.php";
include "lector_tool.php";
session_start();
//$course_content = $sql->query("SELECT * FROM " );



$rest =$sql-> query( "SELECT * FROM course where course_id= '".$_GET['id']."'");
$con = $rest->fetch_assoc();

$id_category = @$sql->query("SELECT category_title FROM category WHERE code_category ='". $con['category']  . "'  ");
$category=$id_category->fetch_assoc();


$id_lector =$sql->query("SELECT f_name, l_name FROM users WHERE id = '". $con['lector'] ."' ");
$course_lector=$id_lector->fetch_assoc();
?>

    <div id="lector_edit" class="jumbotron p-4 p-md-2 text-white bg-dark">
        <div class="col-md-8 px-0">
            <h1 class="display-6 font-italic"> <?php echo $con['full_name']; ?>    </h1>
            <hr class="my-4">
            <p class="text-muted"> <?php echo $con['description']; ?>    </p>

        </div>
        <p class="font-weight-normal"><a href="#" class="text-white font-weight-bold"> <?php echo $category['category_title']; ?>     </a></p>
        <?php
        function testInfo($testId,$testTitle,$testEndTime = null){
            echo'
                    <a class="list-group-item list-group-item-action w-25 bg-light" methods="get" href="test.php?t_id='.$testId.'" style="padding: 12px 12px!important">
                       <h5 class="mb-1">Тест</h5>
                       <p>"'.$testTitle.'"</p>';
            if (!is_null($testEndTime))
                echo '<p class="m-0 text-sm"><small>Завершается: '.DateTime::createFromFormat('Y-m-d H:i:s',$testEndTime)->format('d.m.y H:i').'</small></p>';
            echo '</a>';
        }
        function courseTest($testId,$testTitle,$testEndTime = null) {
            echo'
            <div class="bg-light rounded-lg d-flex p-0">
                <a class="btn btn-outline-secondary pl-4 w-100 d-flex justify-content-between" href="test.php?t_id='.$testId.'" style="text-align: left">
                <div>
                    <p class="h3">Тест курса:</p>
                    <p class="h2">"'.$testTitle.'"</p>';
                if (!is_null($testEndTime))
                    echo '<p class="mb-1">Завершается: '.DateTime::createFromFormat('Y-m-d H:i:s',$testEndTime)->format('d.m.y H:i').'</p>';
              echo ' </div>
                <button class="btn text-light" style="width: 15%; background: #6C757D">Пройти</button>
                </a>
            </div>';
        }

        $courseId = $_GET["id"];
        $testCourse = $sql->query("SELECT * FROM test WHERE course_id = '$courseId'");
        $testC = $testCourse->fetch_assoc();
        if (($testCourse)->num_rows != 0)
            if (strtotime($testC['startDate']) == false and strtotime($testC['endDate']) == false)
                courseTest($testC['id'],$testC['title']);

            elseif (strtotime($testC['startDate']) == true and (strtotime($testC['startDate']) <= strtotime($_SESSION['time']))
                and strtotime($testC['endDate']) == false)
                courseTest($testC['id'], $testC['title']);

            elseif (strtotime($testC['endDate']) == true and (strtotime($testC['endDate']) >= strtotime($_SESSION['time']))
                and strtotime($testC['startDate']) == false) {
                courseTest($testC['id'], $testC['title'],$testC['endDate']);
            }

            elseif (strtotime($testC['endDate']) == true and (strtotime($testC['endDate']) >= strtotime($_SESSION['time']))
                and strtotime($testC['startDate']) == true and (strtotime($testC['startDate']) <= strtotime($_SESSION['time'])))
                courseTest($testC['id'],$testC['title'],$testC['endDate']);
        ?>
    </div>


    <div class="list-group list-group-horizontal-sm">



        <div class="list-group   w-100 mr-md-3">
            <h4 style="margin-left: 10px"> Лекции: </h4>
            <!--  Темы      -->


            <?php
            $topic=$sql->query("SELECT * from lecture JOIN course_lecture ON course_lecture.lecture_id= lecture.lecture_id 
            Where course_lecture.course_id =' ".$_GET['id']. "' ");
            while ($row = $topic->fetch_assoc()) {
                ?>
                <div class="list-group list-group-horizontal m-2">
                    <a id="lector_edit_left" href="topic.php?idc=<?php echo $row['lecture_id'] ?> " class="list-group-item list-group-item-action ">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"> <?php print $row['title']   ?>      </h5>
                            <small></small>
                        </div>
                        <p class="mb-1"> <?php print $row['description']   ?></p>
                        <small></small>
                    </a>
                    <?php



                    $testQuery = $sql->query("SELECT * FROM test WHERE lecture_id ='".$row['lecture_id']."'");
                    $test = $testQuery->fetch_assoc();
                    $questionCheck = $sql->query("SELECT * FROM test_question WHERE test_id = '".$test["id"]."'");
                    if ($testQuery->num_rows > 0 and $questionCheck->num_rows > 0){
                    if (strtotime($test['startDate']) == false and strtotime($test['endDate']) == false)
                        testInfo($test['id'],$test['title']) ;

                        elseif (strtotime($test['startDate']) == true and (strtotime($test['startDate']) <= strtotime($_SESSION['time']))
                            and strtotime($test['endDate']) == false)
                                testInfo($test['id'], $test['title']);

                        elseif (strtotime($test['endDate']) == true and (strtotime($test['endDate']) >= strtotime($_SESSION['time']))
                            and strtotime($test['startDate']) == false)
                                testInfo($test['id'],$test['title'],$test['endDate']) ;

                        elseif (strtotime($test['endDate']) == true and (strtotime($test['endDate']) >= strtotime($_SESSION['time']))
                            and strtotime($test['startDate']) == true and (strtotime($test['startDate']) <= strtotime($_SESSION['time'])))
                                testInfo($test['id'],$test['title'],$test['endDate']) ;
                    }?>
                </div>
            <?php    }  ?>
        </div>
    </div>
<?php

include $_SERVER['DOCUMENT_ROOT'] . "/templates/Footer.php"; ?>