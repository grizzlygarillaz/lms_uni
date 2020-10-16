<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
$user = $_SESSION["user_id"];
?>

    <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">

                <button type="button" class="close" data-dismiss="modal"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="modal-body " style="text-align: center;">
                    Вы действительно хотите удалить этот курс?
                </div>
                <div class="modal-footer mx-auto " style="text-align: center;">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Нет</button>
                    <button type="button" id="delCourse" class="btn btn-outline-danger">да</button>
                </div>
            </div>
        </div>
    </div>


    <div class="row row-cols-1 row-cols-md-3  ">

        <div id="add" class="col mb-4 " style="max-width: 20rem; height: 23rem;min-width: 20rem;">
            <a class="card h-100 " href="add_course.php">
                <button type="button_add" title="Создать новый курс"  class="btn btn-outline-success h-100" onclick="">
                    <svg id="i-plus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="60" height="60"
                         fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round"
                         stroke-width="2">
                        <path d="M16 2 L16 30 M2 16 L30 16"/>
                    </svg>
                </button>
            </a>
        </div>
        <?php
        $content = $sql->query("SELECT * FROM course WHERE lector = '$user'");
        while ($row = $content->fetch_assoc()) {
            $row["full_name"];
            $col_lecture = $sql->query("SELECT COUNT(*) FROM lecture WHERE course_id='" . $row['course_id'] . "         '");
            $applications = $sql->query("SELECT COUNT(*)FROM application WHERE course_id='" . $row['course_id'] . "' and 
            status=1");
            $col_appl = $applications->fetch_assoc();
            $col = $col_lecture->fetch_assoc();
            ?>

            <div id="lector_edit" class="col mb-4 " style="max-width: 20rem; height: 23rem; min-width: 20rem;">
                <div class="card h-100">
                    <div class="p-1 bg-light rounded " style="height: 5rem;">
                        <div class="container">
                            <div class="row justify-content">
                                <div class=" col" style="padding: 5px; margin-left: 8px;">
                                    <rect width="100%" height="100%" fill="#55595c">
                                        <div class="full_name"
                                             style="">   <?php echo mb_strimwidth($row["full_name"], 0, 50, "...") ?>   </div>
                                    </rect>
                                </div>
                                <div class="col col-md-2">
                                    <button type="button" id="del_course" data-toggle="modal"
                                            data-target="#staticBackdrop" class="btn btn-link"
                                            value="<? echo $row['course_id'] ?>"
                                            title="Удалить курс" style="padding: 1px;">
                                <span class="material-icons" style="color: #cc0000">delete_forever
                                </span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body  ">

            <span class="coursecontent " style="max-width: 100%; height: 100%; ">
                <?php echo mb_strimwidth($row["description"], 0, 150, "...") ?>
            </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-3 ">

                        <div class="btn-group">
                            <a type="button" class="btn btn-outline-success" methods="GET"
                               onclick="<?php $_SESSION['lecture'] = 0; ?>      "
                               href="../course.php?id=<? echo $row['course_id'] ?>" name="adres_lecture">Открыть </a>
                            <a type="button" class="btn btn-outline-info" methods="GET"
                               onclick="<?php $_SESSION['lecture'] = 0; ?>      "
                               href="applications.php?id=<? echo $row['course_id'] ?>" name="adres_applications"> Заявки
                                <span class="badge badge-pill badge-secondary">     <?php
                                    echo $col_appl['COUNT(*)'] . ' ';
                                    ?>           </span>
                            </a>

                        </div>
                        <small class="text-muted">
                            <?php
                            echo 'Лекций: ' . $col['COUNT(*)'];
                            ?>
                        </small>

                    </div>
                </div>
            </div>
        <?php }
        $sql->close();
        ?>
    </div>
    <script>


        $(document).on('click', '#del_course', function () {
            let id = $(this).attr('value');
            $(document).on('click', '#delCourse', function () {
                $.ajax({
                    method: "POST",
                    data: 'id=' + id,
                    url: "del_course.php",
                    success: function () {
                        $('#staticBackdrop').modal('hide');
                        window.location.reload();
                    }
            
            })
            })

        })

    </script>


<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Footer.php"; ?>