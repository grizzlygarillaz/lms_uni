<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
$i=0;
if( isset( $_POST['my_file_upload'] ) ){
    // ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно

    $uploaddir = './uploads'; // . - текущая папка где находится submit.php

    // cоздадим папку если её нет
    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

    $files      = $_FILES; // полученные файлы
    $done_files = array();

    // переместим файлы из временной директории в указанную
    foreach( $files as $file ){
        $file_name = $file['name'];

        if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
            $done_files[] = realpath( "$uploaddir/$file_name" );
        }
    }

    $data = $done_files ? array('files' => $done_files ) : array('error' => 'Ошибка загрузки файлов.');

    die( json_encode( $data ) );}

//echo "<a href=\"/main_page/lector/course.php?id=$id_course\"  id=\"add_lecture\" name=\"add_lecture\"
//             class=\"btn btn-outline-secondary btn-sm\" >Открыть страницу курса</a> ";
// echo "<span value='$id_course' id='id_c' class='id_c' ></span>";

//
//$blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm");
//foreach ($blacklist as $item)
//    if(preg_match("/$item\$/i", $_FILES['somename']['name'])) exit;
//$type = $_FILES['somename']['type'];
//$size = $_FILES['somename']['size'];
//if (($type != "image/jpg") && ($type != "image/jpeg")&& ($type != "image/png")) exit;
//if ($size > 102400) exit;
//
//
//$uploadfile = "images/".$_FILES['somename']['name'];
//move_uploaded_file($_FILES['somename']['tmp_name'], $uploadfile);
//
//
//$save_image=$sql->query("INSERT INTO file (namefile) VALUE ('".$uploadfile."')");}


