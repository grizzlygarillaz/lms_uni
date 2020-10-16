<?php
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";
$course_id = $_GET['course_id'];
echo '<option disabled selected>Выберите лекцию</option>';
$lectureQuery = $sql->query("SELECT * FROM lecture WHERE course_id = '$course_id'");
while ($lecture = $lectureQuery->fetch_assoc())
{
    $testExist = $sql->query("SELECT * FROM test WHERE lecture_id = '" . $lecture['lecture_id'] . "'")->fetch_assoc();
    if (is_null($testExist))
        $existing = 'contain = "false"';
    else
        $existing = 'contain = "true"';
    echo "<option ".$existing." value='" . $lecture['lecture_id'] . "'>" . $lecture['title'] . "</option>";
}
