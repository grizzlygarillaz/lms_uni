<?php


include $_SERVER['DOCUMENT_ROOT'] . '/templates/Base.php';
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
session_start();
$id_course = $_GET['course_id'];

?>
<div id="" class="btn-group mb-3" role="group" aria-label="Basic example">
    <button id="add_plan" type="button" class="btn btn-warning ">Редактировать</button>
    <button type="button" id="save_plan" style="display: none" class="btn btn-outline-success">
        Сохранить
    </button>
</div>


<div class="list-group">
    <div id="new_plan" style="display: none"><label> Запланировать занятие</label>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label> Дата </label>
                <input type="date" id="datenew" name="date" class="custom-select d-block w-100">
            </div>

            <div class="col-md-6 mb-3">
                <label> Лекция курса </label>

                <select class="custom-select d-block w-100" id="lecture" name="lecture">
                    <option value="">Выбрать</option>
                    <?php $lectureplan = $sql->query("SELECT title,lecture_id FROM lecture WHERE course_id='" . $id_course . "' ");
                    while ($lecture = $lectureplan->fetch_assoc()) { ?>
                        <option
                                name="cat" id="lecture_id"
                                value="<?php echo $lecture['lecture_id'] ?>"> <?php echo $lecture['title'] ?> </option>
                    <?php } ?>
                </select>
            </div>

        </div>
    </div>
    <a class="list-group-item ">План курса:</a>

    <?php
    $plan = $sql->query("SELECT * FROM lecture JOIN lesson_plan on lecture.lecture_id=lesson_plan.lecture_id WHERE lesson_plan.course_id='" . $id_course . "' ORDER BY datel DESC");
    while ($plan_item = $plan->fetch_assoc()) {
        ?>


        <!-- id="itembac"   <a href="#" class="list-group-item list-group-item-action list-group-item-success">Элемент группы списка успешных действий</a>-->
        <!--    <a href="#" class="list-group-item list-group-item-action list-group-item-danger">Элемент группы списка опасности</a>-->
        <li value="<?php echo $plan_item['datel'] ?>" id="planItem" class="list-group-item "
            style="">
            <button id="del_item" data-toggle="modal"
                    data-target="#staticBackdrop" class="btn btn-link"
                    value="<? echo $plan_item['plan_id'] ?>"
                    title="Удалить курс" style="padding: 1px;">
                            <span class="material-icons" style="color: #cc0000">delete_forever
                                </span>
            </button>

            <?php echo $plan_item['datel'] . '  Лекция: ' . $plan_item['title'] ?>

            <!--    <a href="#" class="list-group-item list-group-item-action list-group-item-light">Элемент группы с легким списком</a>-->
            <?php
            $datelec = $plan_item['datel'];
            ?>


        </li>


    <?php }

    ?>

    <a class="stop"> </a>
</div>


<script>
    $('.list-group-item').each(function (i, elem) {
        let date1 = new Date().toISOString().slice(0, 10);
        let date2 = $(this).attr('value');
        if (date1 > date2) {
            $(this).addClass('list-group-item-info');
            console.log('stooooop');
        }
    });
    $(document).on('click', '#add_plan', function () {
        $('#new_plan').css('display', 'block');
        $('#save_plan').css('display', 'block');
        $(this).prop('disabled', true);
    });

    $(document).on('click', '#del_item', function () {
        let plan_item = $(this).val();
        $.ajax({
            data: 'plan_item=' + plan_item,
            method: "POST",
            url: "del_item.php",
            success: function () {
                window.location.reload();
            }

        })
    });


    $(document).on('click', '#save_plan', function () {
        $(this).prop('disabled', false);
        console.log(document.getElementById('datenew').value);
      console.log($('#lecture').val());
        $.ajax({
            method: "POST",
            url: "query_add.php",
            data: 'date=' + document.getElementById('datenew').value + '&title=' + $('#lecture').val() + '&course_id=' + '<? echo $id_course?>',

            success: function (html) {
                
                window.location.reload();
            }

        })

    })


</script>


<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/Footer.php';
?>

