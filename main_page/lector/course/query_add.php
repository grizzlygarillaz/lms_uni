<?php 
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";
session_start();

    $kod = (int)$_POST['kod'];
    $status = $_POST['status'];
    $id=$_POST['id'];
    $del = $sql->query("UPDATE application SET status= '" . $status . "' WHERE  course_id='" . $id . "' and kod='".$kod."' ");
    if($status==2) {
        $course = $sql->query("INSERT INTO student_list (stud_id, course_id) VALUES ('" . $kod. "','" . $id . "') ");
    }
