<?php
session_start();
$user = $_SESSION["user_id"];
$_SESSION['role']='1';
include $_SERVER['DOCUMENT_ROOT'].'/templates/Base.php';

?>

<div class="row row-cols-1 row-cols-md-3  ">
<div id="plan_lesson" class="col mb-4 " style="max-width: 10rem; height: 10rem ;min-width: 20rem;">
    <a class="card h-100 " href="plan/plan_lesson.php?id_lector=<?php echo $user?>">
        <button type="button_add" class="btn btn-outline-success h-100" >
       <h4 > План занятий </h4>
   </button>
    </a>
</div>

<div id="all_course" class="col mb-4 " style="max-width: 10rem; height: 10rem ;min-width: 20rem;">
    <a class="card h-100 " href="course/lector_course.php?id_lector=<?php echo $user?>">
        <button type="button_add" class="btn btn-outline-success h-100" >
            <h4 > Мои курсы </h4>
        </button>
    </a>
</div>
    <div id="all_course" class="col mb-4 " style="max-width: 10rem; height: 10rem ;min-width: 20rem;">
        <a class="card h-100 " href="group/group.php?id_lector=<?php echo $user?>">
            <button type="button_add" class="btn btn-outline-success h-100" >
                <h4 > Мои группы </h4>
            </button>
        </a>
    </div>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/templates/Footer.php';
?>
