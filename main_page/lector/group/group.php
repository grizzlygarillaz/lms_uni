<?php
session_start();
$user = $_SESSION["user_id"];
$_SESSION['role'] = '1';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/Base.php';
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";

$id = $_GET['id_lector'];
?>

<div class="modal fade bd-example-modal-sm" id="delGroup" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">

        <div class="modal-content" style="padding: 9px;">
            Вы действительно хотите удалить этот курс?
            <button type="button" style="margin: 5px;" class="btn btn-secondary" data-dismiss="modal">Отмена
            </button>
            <button type="button" style="margin: 5px;" id="deleteGroup" class="btn btn-danger">Удалить</button>
        </div>

    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавление студента</h5>
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
                    <button type="button" id="add" class="btn btn-primary">Добавить</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="new_group" data-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Новая группа</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label>Введите наименование группы </label>
                <input id="newGroup" type="text" class="form-control" name="newGroup" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" id="saveGroup" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>


<div class="list-group">

    <div class="row">

        <div class="col-4">
            <button id="new_group" data-toggle="modal" data-target="#new_group" type="button" style="margin: 5px;"
                    data-toggle="modal" data-target="#exampleModal"
                    class="btn btn-success btn-sm mx-auto">Создать новую группу
            </button>
            <?php
            $group = $sql->query("SELECT * FROM groups WHERE lecture_id='" . $id . "'");
            while ($lecture_gr = $group->fetch_assoc()) {
                ?>
                <button type="button" id="group" value="<?php echo $lecture_gr['group_id'] ?>"
                        style="width: 80%; margin-top: 8px;" class="list-group-item list-group-item-action">
                    Группа: <?php echo $lecture_gr['group_name'] ?> </button>

            <?php } ?>

        </div>
        <div class="col-8" id="content">
        </div>

    </div>

    <script>

        $(document).on('click', '#group', function () {
            let gr_id = $(this).val();

            $.ajax({
                url: "gr_id.php",
                data: 'gr_id=' + gr_id,
                method: "POST",
                success: function (html) {
                    $('#content').html(html)
                }
            })
        });


        $(document).on('click', '#del', function () {
            let str = $(this).val();
            console.log(str);
            $.ajax({
                url: "query_del.php",
                // dataType: "json", // Для использования JSON формата получаемых данных
                method: "POST", // Что бы воспользоваться POST методом, меняем данную строку на POST
                data: 'idg=' + str,
                success: function () {


                }
            });
            $(this).remove();
        });
        $(document).on('click', '#add_student', function () {
            let add = $(this).val();

            $(document).on('click', '#add', function () {
                let
                    email = $('#email').val();
                console.log(email);
                $.ajax({
                    data: 'email=' + email + '&group=' + add,
                    url: "add_student.php",
                    method: "POST",
                    success: function (html) {
                        $('#email').after(html);
                        window.location.reload();
                    }
                })
            })
        })
        $(document).on('click', '#saveGroup', function () {

            let gr_name = $('#newGroup').val();
            console.log(gr_name);
            $.ajax({
                data: 'name=' + gr_name + '&id=' + '<?php  echo $id?>',
                url: "newGroup.php",
                method: "POST",
                success: function (html) {
                    $('#saveGroup').html(html);
                    window.location.reload();
                }
            })
        });


        $(document).on('click', '#deleteGroup', function () {
            let gr_id = $('#delgr').val();
            console.log(gr_id);
            $.ajax({

                method: "POST",
                data: 'id=' + gr_id,
                url: "delGroup.php",
                success: function () {
                    window.location.reload();

                }
            })
        })
    </script>


    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/Footer.php';
    ?>
