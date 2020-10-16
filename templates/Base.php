<?php       session_start();
$date_today = date("Y-m-d");
$today[1] = date("H:i:s");
$_SESSION['time'] = $date_today." ".$today[1];
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?include $_SERVER['DOCUMENT_ROOT'].'/templates/links.php'?>
</head>


<nav class="navbar navbar-expand-lg navbar-dark desktop fixed-top" style="z-index: 2" >
    <a class="navbar-brand material-icons md-light" id="menu" onclick="TransformNav()">menu</a>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav "  id="navbarNavAltMarkup">
            <a class="nav-item nav-link active d-flex mr-4" href="#">
                <span class="material-icons mr-1">home</span>
                Главная <span class="sr-only">(current)</span>
            </a>
            <a class="nav-item nav-link d-flex mr-4"   href="
            <?php
            switch ($_SESSION['role']){
                case '1':
                    echo "/main_page/lector/course/lector_course.php";
                    break;
                case '2':
                    echo "/student_profile/student_course.php";
                    break;
            }?>
            ">
                <span class="material-icons mr-1">book</span>
                Курсы
            </a>
            <a class="nav-item nav-link d-flex mr-4" href="#">
                <span class="material-icons mr-1">face</span>
                Преподаватели
            </a>

        </div>
    </div>
    <li class="nav justify-content-end">
        <?php
        if (!empty($_SESSION['user_id']))
            echo'
                <div class="btn-group">
                <a class="btn btn-link text-light" type="button" id="user" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display: inline-block">'.
                $_SESSION['user_fn']." ".$_SESSION['user_ln'].'</a>
                <a class="btn btn-link text-secondary" id="exit" href="#">Выйти</a>
                </div>';
        else echo '<a  class="nav-link text-light" href="/index.php">Войти</a>'
        ?>
    </li>
</nav>

<script>
    $(document).on('click','#exit',function () {
        window.location.replace("/index.php");
    })
</script>

<nav class="navbar navbar-expand-lg navbar-dark mobile header" style="z-index: 2">
    <div class="mob-nav">
        <a class="navbar-brand material-icons md-light pt-2" id="menu" onclick="TransformNav()">menu</a>
        <!--TODO бордер в спаен переделать,  форматировать по центру без лишнего пространства -->
        <div class="d-flex justify-content-between align-content-center w-100">
            <a class="nav-item nav-link active d-flex" href="#">
                <span class="material-icons">home</span>
                <span class="sr-only">(current)</span>
            </a>
            <a class="nav-item nav-link d-flex" href="
            <?php
            switch ($_SESSION['role']){
                case '1':
                    echo "/main_page/lector/course/lector_course.php";
                    break;
                case '2':
                    echo "/student_profile/student_course.php";
                    break;
            }?>
            ">
                <span class="material-icons">book</span>
            </a>
            <a class="nav-item nav-link d-flex" href="#">
                <span class="material-icons">face</span>
            </a>
            <a class="nav-item nav-link d-flex" href="#">
                <span class="material-icons">blur_on</span>
            </a>
        </div>
        <li class="nav justify-content-end">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">  </a>
        </li>
    </div>
</nav>



    <?php
    if (!empty($_SESSION['user_id'])) {
        echo '<div id="mySidebar" class="sidebar">';
    switch ($_SESSION["role"]) {
        case '1':                           //lector
            include $_SERVER['DOCUMENT_ROOT'] . "/main_page/lector/lector_sidebar.php";
            break;
        case '2':                           //student
            include $_SERVER['DOCUMENT_ROOT'] . "/student_profile/student_sidebar.php";
            break;
        case '3':                           //admin
            include $_SERVER['DOCUMENT_ROOT'] . "/main_page/admin/admin_sidebar.php";
            break;
        default:
            echo "
            <a>About</a>
            <a>Services</a>
            <a>Clients</a>
            <a>Contact</a>
        ";
            break;
    }
echo '</div>';
    }?>

<div id="main" class="content ">