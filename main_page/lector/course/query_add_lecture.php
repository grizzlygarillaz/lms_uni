<?php
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";



    $title = $_POST['title'];
    $description = $_POST['description'];
    $id_course = $_POST['id_course'];

    $save_lecture = $sql->query(" INSERT INTO lecture(title, description,course_id)
  VALUES ('" . $title . "','" . $description . "','" . $id_course . "')");

    $id_lecture = $sql->query("SELECT LAST_INSERT_ID() as num ")->fetch_assoc();
    $lecture_id = $id_lecture['num'];
//$LIC=$sql->query("INSERT INTO course_lecture(course_id,lecture_id)
//VALUES('".$id_course."','".$id_lecture."') ");

    echo "<input style='display: none' id='id_lecture' value='$lecture_id' >   </input> ";



//$topic_title=$_POST['topic_title'];
//$topic_desc=$_POST['topic_desc'];
//$id_lectop=$_POST['id_lectop'];
//
//$save_topic=$sql->query(" INSERT INTO page( title,  description, lecture_id)
//  VALUES ( '".$topic_title."','".$topic_desc."','".$id_lectop."') ");