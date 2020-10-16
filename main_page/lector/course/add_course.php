<?php

include $_SERVER['DOCUMENT_ROOT'] . "/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
session_start();
$user = $_SESSION["user_id"];
$title = $_POST['title'];
$description = $_POST['description'];
$page_id = 0;
$id = $sql->insert_id;
?>
<div class="alert alert-success" id="ok" style="display: none" role="alert">
    Новый курс создан<br>
</div>
<form class="addcourse" name="add_course" id="add_course" enctype="multipart/form-data">
    <div name="about_course"
         id="about_course" class="my-3 p-3 bg-white rounded shadow-sm mx-auto">
        <h4 class="mb-3">Новый курс</h4>
        <form id="add" class="needs-validation" novalidate="">
            <!-- Данные о курсе-->
            <div id="fname" class=" mb-3">
                <label>Полное название курса</label>
                <input id="full_name" type="text" class="form-control" name="full_name" value="">
            </div>

            <div id="sname" class=" mb-3">
                <label>Краткое название курса</label>
                <input type="text" id="short_name" class="form-control" name="short_name" value="">

            </div>
            <div class="input-group" style="width: max-content;">

                <div style="    margin-right: 14px;
    margin-top: 7px;">
                    <label>Обложка курса(не обязательно):</label>
                </div>

                <div class="custom-file">
                    <input id="fileupload" type="file" name="files[]"  multiple>


                    <script src="libraries/jquery.fileupload.js"></script>
                    <script>
                        $(function () {
                            $('#fileupload').fileupload({
                                dataType: 'json',
                                done: function (e, data) {
                                    $.each(data.result.files, function (index, file) {
                                        $('<p></p>').text(file.name).appendTo(document.body);
                                    });
                                }
                            });
                        });
                    </script>
                </div>
                <div class="input-group-append">

                    <button class="btn btn-outline-secondary"  type="button" id="save_cover"> Загрузить</button>
                </div>
                <div class="ajax-reply" id="ajax-reply"></div>

            </div>
            <!--                <div id="cover" class=" mb-3">-->
            <!--                    <label >Обложка курса(не обязательно): </label><br>-->
            <!--                        -->
            <!--                    <input type = "file"  name = "somename" />-->
            <!--                    <input type = "submit" class="btn btn-secondary btn-sm " value = "Загрузить" />-->
            <!--                </div>-->

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label> Категория </label>
                    <select class="custom-select d-block w-100" id="category" name="category">
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

            <div class=" mb-3">
                <label>Описание курса</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <hr class="mb-4">
            <!--       Кнопки     -->
            <div id="btn_course">
                <button name="save_course" id="save_course" class="btn btn-outline-success"> Сохранить курс</button>
            </div>

    </div>
    <script>


        $(document).ready(function () {

            var files; // переменная. будет содержать данные файлов

            //
            // $('input[type=file]').on('change', function(){
            //     files = this.files;
            // });



            $('#save_cover').on( 'click', function( event ){

                event.stopPropagation(); // остановка всех текущих JS событий
                event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега

                // ничего не делаем если files пустой
                if( typeof files == 'undefined' ) return;

                // создадим объект данных формы
                var data = new FormData();
                $.each( files, function( key, value ){
                    data.append( key, value );
                });
                data.append( 'my_file_upload', 1 );

                $.ajax({
                    url         : './add_image.php',
                    type        : 'POST', // важно!
                    data        : data,
                    cache       : false,
                    dataType    : 'json',
                    // отключаем обработку передаваемых данных, пусть передаются как есть
                    processData : false,
                    // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
                    contentType : false,
                    // функция успешного ответа сервера
                    success     : function( respond, status, jqXHR ){

                        //  ОК - файлы загружены
                        if( typeof respond.error === 'undefined' ){
                            //  выведем пути загруженных файлов в блок '.ajax-reply'
                            var files_path = respond.files;
                            var html = '';
                            $.each( files_path, function( key, val ){
                                html += val +'<br>';
                            } );
                            console.log('OK');
                            $('.ajax-reply').html( html );
                        }
                        // ошибка
                        else {
                            console.log('ОШИБКА: ' + respond.data );
                        }
                    },
                    // функция ошибки ответа сервера
                    error: function( jqXHR, status, errorThrown ){
                        console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
                    }

                });

            });




            $(document).on('click', '#save_course', function () {
                // alert($('#description').val());
                $('#ok').css('display', 'block');
                $('#about_course').css('display', 'none');
                var e = document.getElementById("ajax-reply");
                var ajaxreply  = e.textContent ;

                console.log($('#category').val());
                $.ajax({
                    method:"POST",
                    url: "app.php",
                    data: 'full_name=' + $('#full_name').val()   + '&short_name=' + $('#short_name').val() + '&category=' + $('#category').val() + '&type_course=' + $('#type_course').val() + '&description=' + $('#description').val(),
                    success: function (html) {
                        $("#ok").append(html);
                        console.log(ajaxreply);
                    }
                    ,
                    error: function () {
                        console.log('jbnjbnjk');
                    }
                });
                return false;
            })

        });

    </script>
</form>

<?

include $_SERVER['DOCUMENT_ROOT'] . "/templates/Footer.php"; ?>
