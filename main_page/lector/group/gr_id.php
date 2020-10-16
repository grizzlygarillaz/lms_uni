<?php
include $_SERVER['DOCUMENT_ROOT']. "/SQL/sql_connect.php";


$gr_id=$_POST['gr_id'];

$show_group=$sql->query("SELECT * from user_group WHERE group_id='".$gr_id."'")->fetch_assoc();
echo '
<button id="add_student" value="'.$gr_id.'"  type="button" style="margin: 5px;" data-toggle="modal" data-target="#exampleModal"
                        class="btn btn-success btn-sm mx-auto">Добавить студента
                </button>
                <button id="delgr" value="'.$gr_id.'"  type="button" style="margin: 5px;" data-toggle="modal" data-target="#delGroup"
                        class="btn btn-outline-danger btn-sm mx-auto">Удалить группу
                </button>
<div id="applications">
    <table class="table table-light table-bordered">
    <thead class="thead-dark ">
    <tr>
     
        <th scope="col"> Фамилия</th>
        <th scope="col">Имя</th>
        <th scope="col"> Почта</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>


'; $applications = $sql->query("SELECT * FROM user_group JOIN users ON user_group.user_id= users.id WHERE group_id= $gr_id ");

while ($add_app = $applications->fetch_assoc()) {
   
  echo ' <tr id= " '. $add_app['kod'] .' ">
        
        <th> '. $add_app['f_name'].'</th>
        <td>'.$add_app['l_name'].'</td>
        <td>'.$add_app['email'].'</td>
        <td>
            <div class="mx-auto">
                <button id="del" value="'. $add_app['idg'].'" type="button"
                        class="btn btn-outline-danger btn-sm mx-auto">Исключить
                </button>

            </div>
        </td>
    </tr>
';
} ?>

    </tbody>
    </table>
    </div>



