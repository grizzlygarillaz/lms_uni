<?php

$user_id = $_GET[id_lector];

include $_SERVER['DOCUMENT_ROOT'] . '/templates/Base.php';
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
session_start();
?>

<?php

$content = $sql->query("SELECT * FROM course WHERE lector = '$user_id'");
?>
<div class="row row-cols-1 row-cols-md-3  ">
    <?php
    while ($row = $content->fetch_assoc()) {
        $row["full_name"];
        $col_lecture = $sql->query("SELECT COUNT(*) FROM lecture WHERE course_id='" . $row['course_id'] . "         '");
        $applications = $sql->query("SELECT COUNT(*)FROM application WHERE course_id='" . $row['course_id'] . "' and 
            status=1");
        $col_appl = $applications->fetch_assoc();
        $col = $col_lecture->fetch_assoc();
        ?>
        <div id="lector_edit" class="col mb-4 " style="max-width: 10rem; height: 10rem; min-width: 20rem;">
            <div class="card h-100">
                <div class="p-4 bg-light rounded " style="height: 14rem;">
                    <rect width="100%" height="100%" fill="#55595c">
                        <div class="full_name"
                             style="">   <?php echo mb_strimwidth($row["full_name"], 0, 50, "...") ?>   </div>
                    </rect>
                </div>
                <div class=" justify-content-between align-items-center  ">
                    <a type="button" id="id_course" href="plan.php?course_id=<?php echo $row['course_id']?>" class="btn btn-outline-info" style="width: 100%; border-radius: inherit;">План занятий</a>
                </div>
            </div>
        </div>
    <?php }
    $sql->close();
    ?>

</div>


<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/Footer.php';
?>

