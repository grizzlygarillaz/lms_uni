<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/templates/Base.php";
$id = $_SESSION['user_id'];
$host = 'localhost';
$database = 'gr1zzly_tisbi';
$user = 'gr1zzly_tisbi';
$password = '11QazSe44';
$sql = new mysqli($host, $user, $password, $database);
//$course_id=$sql->query("SELECT * FROM student_list WHERE stud_id ='" . $_SESSION['user_id'] . "'"   );
//$query = $course_id->fetch_assoc();
//$code_course=$query['course_id'];
?>
    <div class="row row-cols-1 row-cols-md-3  ">

        <div id="add" class="col mb-4 " style="max-width: 20rem; height: 23rem;min-width: 20rem;">
        <a class="card h-100 " href="all_course.php?idu=<?php echo $id?>">
            <button type="button_add" class="btn btn-outline-success h-100" onclick="">

                <svg id="i-plus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="60" height="60"
                     fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round"
                     stroke-width="2">
                    <path d="M16 2 L16 30 M2 16 L30 16"/>
                </svg>
            </button>
        </a>
    </div>


        <?php
        $course_content = $sql->query("SELECT COUNT(*) FROM student_list where stud_id ='$id'");
        $query = $course_content->fetch_assoc();

        $content = $sql->query("SELECT * FROM course JOIN student_list ON student_list.course_id = course.course_id WHERE student_list.stud_id='$id'");
        //$course_id=$content->fetch_assoc();
        while ($row = $content->fetch_assoc()) {
            $row["full_name"];
            $col_lecture = $sql->query("SELECT COUNT(*) FROM course_lecture WHERE course_id='" . $row['course_id'] . "         '");
            $col = $col_lecture->fetch_assoc();
            ?>


            <div class="col mb-4 " style="max-width: 20rem; height: 23rem">
                <div class="card h-100">
                    <div class="p-4 mb-3  bg-light rounded ">
                        <rect width="100%" height="100%" fill="#55595c">
                            <div class="full_name" style="">   <?php printf($row["full_name"]) ?>   </div>

                        </rect>
                    </div>
                    <div class="card-body  ">

            <span class="coursecontent " style="max-width: 100%; height: 100%; ">
                <?php  echo mb_strimwidth($row["description"], 0, 190, "...") ?>
            </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-3 ">
                        <div class="btn-group">
                            <a type="button" class="btn btn-outline-success" methods="GET" onclick="<?php $_SESSION['lecture']= 0;    ?>      "
                               href="/student_profile/course.php?id=<?echo $row['course_id']?>" name="adres_lecture"> Читать </a>
                            <!--                <button type="button" class="btn btn-sm btn-outline-danger">Удалить</button>-->
                        </div>

                        <small class="text-muted">
                            <?php


                            echo $col['COUNT(*)'] . ' лекци(и/й)';
                            ?>
                        </small>
                    </div>
                </div>
            </div>
            <?php  } $sql->close();
        ?>
    </div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Footer.php"; ?>