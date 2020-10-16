<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
?>
    <div class="modal fade" id="add_student" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Добавление студента</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Введите email студента </label>
                    <input id="email" type="text" class="form-control" name="email" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" id="add_stud" class="btn btn-primary">Добавить</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_group" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Добавление группы</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Выберите группу </label>
                    <select class="custom-select d-block w-100" id="group" name="group">
                        <option value="">Выбрать</option>
                        <?php $id_group = $sql->query("SELECT * FROM groups WHERE lecture_id='" . $_SESSION['user_id'] . "'");
                        while ($lecture_group = $id_group->fetch_assoc()) {
                            ?>
                            <option
                                    name="grName"
                                    value="<?php echo $lecture_group['group_id'] ?>"> <?php echo $lecture_group['group_name'] ?> </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" id="addGroup" class="btn btn-primary">Добавить</button>
                </div>
            </div>
        </div>
    </div>



    <form id="form" class="my-3 p-3 bg-white rounded shadow-sm mx-auto">
        <div class="mx-auto">
            <button id="del_group" type="button" style="margin: 7px;"
                    class="btn btn-outline-danger btn-sm mx-auto">Исключить всех
            </button>
            <div class="btn-group">
                <button type="button" id="record" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Записать на курс
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <button id="rec_student" class="dropdown-item"  data-toggle="modal" data-target="#add_student" type="button">Студента</button>
                    <button id="rec_group" class="dropdown-item" data-toggle="modal" data-target="#add_group" type="button">Группу</button>
                </div>
            </div>
        </div>

        <div id="applications">
            <table class="table table-light table-bordered">

                <thead class="thead-dark ">
                <tr>
                    <th scope="col" style="width: 3rem"></th>
                    <th scope="col"> Фамилия</th>
                    <th scope="col">Имя</th>
                    <th scope="col"> Почта</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>

                <?php

                $applications = $sql->query("SELECT * FROM application JOIN users ON application.user_id= users.id WHERE application.status=2 and 

    application.course_id= '" . $_GET[idm] . "'    ");

                while ($add_app = $applications->fetch_assoc()) {


                    ?>
                    <tr class=" " id="<?php echo $add_app['kod'] ?>">
                        <th>
                            <div class="custom-control custom-checkbox ">
                                <input type="checkbox" value=" <?php echo $add_app['kod'] ?> " name="kod[]" >
                                <label for="list">
                                    <div val class="tick"></div>
                                </label>
                            </div>
                        </th>
                        <th> <?php echo $add_app['f_name'] ?>      </th>
                        <td><?php echo $add_app['l_name'] ?></td>
                        <td><?php echo $add_app['email'] ?></td>
                        <td>
                            <div class="mx-auto">
                                <button id="del" value="<?php echo $add_app['kod'] ?> " type="button"
                                        class="btn btn-outline-danger btn-sm mx-auto">Исключить
                                </button>

                            </div>
                        </td>
                    </tr>


                <?php } ?>

                <script>
                    $(document).on('click', '#del', function () {

                        let str = $(this).val();


                        $.ajax({
                            url: "query_add.php",
                            // dataType: "json", // Для использования JSON формата получаемых данных
                            method: "POST", // Что бы воспользоваться POST методом, меняем данную строку на POST
                            data: 'kod=' + str + '&status=' + 3 + '&id=' + '<?php echo $_GET[idm] ?>',
                            success: function () {

                            }
                        });
                        $(this).remove();
                    });


                    $(document).on('click', '#del_group', function () {
                        var arr = $(':checked').map(function (i, el) {
                            return $(el).val();
                        }).get();
                        arr.forEach(function (element) {
                            console.log(element);
                            $.ajax({
                                method: "POST",
                                url: "query/groupe_del.php",
                                data: 'arr=' + element,
                                success: function () {
                                    window.location.reload();
                                }
                            })
                        })
                        window.location.reload();
                    });

                    $(document).on('click', '#add_stud', function () {
                        let email = $('#email').val(),
                            idcourse='<?php echo $_GET[idm] ?>';
                        console.log(idcourse);
                        $.ajax({
                            data: 'email=' + email + '&id=' + idcourse,
                            url: "query/add_student.php",
                            method: "POST",
                            success: function (html) {
                                $('#email').after(html);
                                window.location.reload();
                            }
                        })
                    })
                    $(document).on('click', '#addGroup', function () {
                        let id_group=$('#group').val(),
                            id_course='<?php echo $_GET[idm] ?>'
                        $.ajax({
                            data: 'idGroup='+id_group+'&idCourse='+id_course,
                            method:"POST",
                            url: "query/add_group.php",
                            success:function () {
                                window.location.reload();
                            }
                        })

                    })


                </script>
                </tbody>
            </table>
        </div>
    </form>


<?php

include $_SERVER['DOCUMENT_ROOT'] . "/templates/Footer.php"; ?>