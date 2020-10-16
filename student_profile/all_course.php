<?php

include $_SERVER['DOCUMENT_ROOT'] . "/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";

session_start();
$id = $_GET['idu'];


$array = [];
$student_course = $sql->query("SELECT * FROM student_list WHERE stud_id=$id")->fetch_all();
foreach ($student_course as $key => $value) {
    array_push($array, $student_course[$key][1]);
}

$course = $sql->query("SELECT * FROM course");

$col = count($array);
?>
<form method="post">
    <div class=" mb-3">
        <div>
            <label>Поиск: </label>
            <input type="text" id="search" aria-label="Sizing example input" class="form-control"
                   aria-describedby="inputGroup-sizing-default">
        </div>
    </div>
    <div class="row">

        <div class="col-md-6 mb-3">
            <label> Категория </label>
            <select class="custom-select d-block w-100" id="category" name="category[]">
                <option value="">Выбрать</option>
                <?php $id_category = $sql->query("SELECT * FROM category ");
                while ($category = $id_category->fetch_assoc()) {
                    ?>
                    <option
                            name="cat"
                            value="<?php echo $category['code_category'] ?>"> <?php echo $category['category_title'] ?> </option>
                <?php } ?>
            </select>

        </div>
        <div class="col-md-6 mb-3">
            <label> Тип курса: </label>
            <select name="type_course" id="type_course" class="custom-select  w-100" ">
            <option value="">Выбрать</option>
            <option id="1" value="1"> Открытый</option>
            <option id="2" value="2"> Закрытый</option>
            </select>
        </div>

    </div>
    <div class="mb-3">
        <button type="button" class="btn btn-danger" id="clearFilter"> Сбросить фильтры</button>
    </div>

</form>
<div id="applications">
    <table class="table table-light table-bordered">

        <thead class="thead-dark ">
        <tr>

            <th scope="col"> Название курса</th>
            <th scope="col">Категория</th>
            <th scope="col">Описание</th>
            <th scope="col">Тип курса</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($course_list = $course->fetch_assoc()) {

        if (!in_array((int)$course_list['course_id'], $array)) {
        //     while( $course_item=$all_course->fetch_assoc()  ){
        ?>
        <tr class="course" value="<?php echo $course_list['course_id'] ?>">
            <th id="name"> <?php echo $course_list['full_name'] ?>      </th>
            <th id="cat_name" class="catName" value="<?php echo $course_list['category'] ?>"> <?php
                $category_name = $sql->query("SELECT * FROM category WHERE code_category='" . $course_list['category'] . "'")->fetch_assoc();

                echo $category_name['category_title'] ?></th>
            <td><?php echo mb_strimwidth($course_list['description'], 0, 100, '...') ?></td>
            <th id="typeCourse" class="courseType" value="<?php echo $course_list['method_regist'] ?>"> <?php
                if ($course_list['method_regist'] == 1) {
                    echo "Открытый";
                } elseif ($course_list['method_regist'] == 2) {
                    echo "Закрытый";
                }
                ?></th>
            <td>
                <div class="mx-auto">
                    <button id="sign_up_course" value="<?php echo $course_list['course_id'] ?> " type="button"
                            class="btn btn btn-outline-info btn-sm mx-auto"><?php
                        if($course_list['method_regist']==1){
                            echo 'Записаться на курс';
                        }elseif ($course_list['method_regist']==2){ echo 'Отправить заявку';}



                        ?>
                    </button>
                    <?php }
                    } ?>
                </div>
            </td>
        </tr>


        <?php

        ?>
        <script>
            $(document).on('click', '#sign_up_course', function () {
                let a = $(this).attr("value");
                $.ajax({
                    method: "POST",
                    url: "query_sign_up.php",
                     data: 'course_id=' + a + '&user_id=' + '<?php echo $id?>',
                    success: function () {

console.log('OK');
                    }
                });
                $(this).removeClass('btn-outline-info');
                $(this).addClass('btn-success');



            });


            document.querySelector('#search').oninput = function () {
                let val = this.value.trim();
                let courseitem = document.querySelectorAll('#name ');

                if (val != '') {
                    courseitem.forEach(function (elem) {
                        if (elem.innerText.search(val) == -1) {
                            console.log(elem);
                            elem.closest("tr").classList.add('d-none');
                            // elem.closest("tr").remove();
                        } else {
                            // elem.closest("tr").remove();
                            elem.closest("tr").classList.remove('d-none');
                        }
                    });
                } else {
                    courseitem.forEach(function (elem) {
                        elem.closest("tr").classList.remove('d-none');
                    })
                }
            };
            $('#category').on('change', function cat() {
                    var a = $(this).val();



                    $('.catName').each(function () {
                        let b = $(this).attr("value");
                        console.log('Категория ' + $(this).attr("value") + 'Выбранно ' + a);
                        if (a !== b) {
                            $(this).parent('tr').addClass('d-none');
                            // $(this).parent('tr').add('d-none');
                            console.log('YES');
                            // $(this).parent('tr').addClass('d-none');
                        } else {
                            $(this).parent('tr').removeClass('d-none');
                        }

                        console.log($('.catName'));
                    });
                // $('#type_course').css('display', 'none');
                }
            );
            $('#type_course').on('change', function typec() {
                    var changeType = $(this).val();

                    $('.courseType').each(function () {
                        let b = $(this).attr("value");
                        console.log('Категория ' + $(this).attr("value") + 'Выбранно ' + changeType);
                        if (changeType !== b) {
                            $(this).parent('tr').addClass('d-none');
                            // $(this).parent('tr').add('d-none');
                            console.log('YES');
                            // $(this).parent('tr').addClass('d-none');
                        } else {
                            $(this).parent('tr').removeClass('d-none');
                        }
                    });
                    $('#category').css('display', 'none');
                }
            );
            $('#clearFilter').on('click', function () {
                let courseitem = document.querySelectorAll('#name ');
                courseitem.forEach(function (elem) {
                    elem.closest("tr").classList.remove('d-none');

                });
                $('#type_course').css('display', 'block');
                $('#category').css('display', 'block');
                }
            );





        </script>

    </table>
</div>


<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Footer.php"; ?>
