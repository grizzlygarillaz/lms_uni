<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";

?>


<form class="my-3 p-3 bg-white rounded shadow-sm mx-auto">


    <div id="applications">
        <table class="table table-light table-bordered">

            <thead class="thead-dark ">
            <tr>
                <th scope="col"> Фамилия</th>
                <th scope="col">Имя</th>
                <th scope="col"> Почта</th>
                <th scope="col"> Статус</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $applications = $sql->query("SELECT * FROM application JOIN users ON application.user_id= users.id WHERE application.status=1 and 

    application.course_id= '" . $_GET[id] . "'    ");

            while ($add_app = $applications->fetch_assoc()) {


                ?>
                <tr class="tab" id="<?php echo $add_app['kod'] ?>">
                    <th> <?php echo $add_app['f_name'] ?>      </th>
                    <td><?php echo $add_app['l_name'] ?></td>
                    <td><?php echo $add_app['email'] ?></td>
                    <td>
                        <div class="mx-auto">
                            <button id="add" value="<?php echo $add_app['kod'] ?> " type="button"
                                    class="btn btn-outline-success btn-sm mx-auto">Принять
                            </button>
                            <button id="del" value="<?php echo $add_app['kod'] ?> " type="button"
                                    class="btn btn-outline-danger btn-sm mx-auto">Отклонить
                            </button>
                        </div>
                    </td>
                </tr>


            <?php } ?>


            <script>

                $(document).on('click', '#add', function () {

                    let str = $(this).val();
                    $(this).remove();
                    $.ajax({
                        url: "query_add.php",

                        method: "POST", // Что бы воспользоваться POST методом, меняем данную строку на POST
                        data: {kod: str, status: 2, id: '<?php echo  $_GET[id] ?> '},
                        success: function () {
                        }
                    })
                });

                $(document).on('click', '#del', function () {
                    let str = $(this).val();
                    $(this).remove();
                    $.ajax({
                        url: "query_add.php",

                        method: "POST", // Что бы воспользоваться POST методом, меняем данную строку на POST
                        data: {kod: str, status: 3, id: '<?php echo  $_GET[id] ?> '},
                        success: function () {
                        }
                    })
                });


            </script>
            </tbody>
        </table>
    </div>


</form>


<?

include $_SERVER['DOCUMENT_ROOT'] . "../templates/Footer.php"; ?>
