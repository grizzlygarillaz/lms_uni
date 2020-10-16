<?php


include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
session_start();
$user = $_SESSION["user_id"];
$full_name = $_REQUEST['full_name'];
$short_name = $_REQUEST['short_name'];
$id_cat = $_REQUEST['category'];
$type = $_REQUEST['type_course'];
$description = $_REQUEST['description'];



//$files=$_REQUEST['file'];

//$way_file=stristr("$files", 'course');


$save_cou = $sql->query("INSERT INTO course ( full_name, short_name, category, description, method_regist, lector)
       VALUES ('" . $full_name . "','" . $short_name . "','" . $id_cat . "','" . $description . "','" . $type . "','" . $_SESSION['user_id'] . "' ) ");

$course_id = $sql->query(" SELECT LAST_INSERT_ID() as num ") ->fetch_assoc();


$id_course = $course_id['num'];
echo "Вы можете  <a href=\"/main_page/lector/course.php?id=$id_course\" class=\"alert-link\">перейти на страницу курса. </a> "
//echo "<a href=\"/main_page/lector/course.php?id=$id_course\"  id=\"add_lecture\" name=\"add_lecture\"
//             class=\"btn btn-outline-secondary btn-sm\" >Открыть страницу курса</a> ";
// echo "<span value='$id_course' id='id_c' class='id_c' ></span>";
?>




