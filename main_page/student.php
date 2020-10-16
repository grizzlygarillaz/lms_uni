<?php
session_start();
include '../templates/Base.php';
$user = $_COOKIE['user'];
//print_r($_COOKIE);
?>
    <div id="all_course" class="col mb-4 " style="max-width: 10rem; height: 10rem ;min-width: 20rem;">
        <a class="card h-100 " href="../student_profile/student_course.php?id=<?php echo $user?>">
            <button type="button_add" class="btn btn-outline-success h-100" >
                <h4 > Мои курсы </h4>
            </button>
        </a>
    </div>
<?php
include '../templates/Footer.php';