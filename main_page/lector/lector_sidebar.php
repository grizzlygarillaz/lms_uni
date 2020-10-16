<?php
session_start();
$id=$_SESSION['user_id'];
echo "
<a act='1' href='/main_page/lector/course/lector_course.php' >Курсы</a>
<a act='2' href='/main_page/lector/lector_test.php'>Управление тестами</a>
<a act='3' href='/main_page/lector/test/result/test_list.php' >Результаты студентов</a>
<a act='4' href='/main_page/lector/group/group.php?id_lector=$id' >Группы</a>
<a act='5' href='/main_page/lector/plan/plan_lesson.php?id_lector=$id' >План занятий</a>
";