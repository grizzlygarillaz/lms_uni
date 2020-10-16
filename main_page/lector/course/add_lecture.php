<?php


include $_SERVER['DOCUMENT_ROOT'] . "/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";

session_start();
$cod = $_GET['id'];
$rest = $sql->query("SELECT * FROM course where course_id='" . $cod . "'");
$con = $rest->fetch_assoc();

?>
<form class="addcourse mx-auto" name="lecture" id="lecture" style="width: 75%">
    <!--   Сообщение об успешном добалвении лекции-->
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 80%">
                <div class="modal-header" style="border-bottom: 0px">
                    <h5 class="modal-title" id="staticBackdropLabel"><span class="material-icons "
                                                                           style="vertical-align: sub; color: #28a745">
                            done</span> Лекция успешно добавлена</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer" style="padding: .0rem; justify-content: space-around;">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Добавить тему лекции
                    </button>
                    <a href="../course.php?id=<?php echo $cod ?>" type="button" id="open_course"
                       class="btn btn-outline-dark">Выйти</a>
                </div>
            </div>
        </div>
    </div>
    <!--    Добавить файлы -->
    <div class="modal fade" id="add_file" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 80%">
                <div class="modal-header" style="border-bottom: 0px">
                    <h5 class="modal-title" id="staticBackdropLabel"><span class="material-icons "
                                                                           style="vertical-align: sub; color: #28a745">
                            done</span>Добавить файл</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="input-group" style="width: 100%;">
                    <form id="myform" method="post" enctype="multipart/form-data">
                        <input type="file" multiple="multiple" name="myfile" id="myfile" ">
                        <input id="addc" type="submit">
                        <div id="myform_at"></div>
                    </form>
                </div>


<div class="modal-footer" style="padding: .0rem; justify-content: space-around;">
    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Добавить тему лекции
    </button>
    <a href="../course.php?id=<?php echo $cod ?>" type="button" id="open_course"
       class="btn btn-outline-dark">Выйти</a>
</div>
</div>
</div>
</div>
<!--  Успешное добавление лекции     -->
<!--    Успешное добавление темы лекции-->


<div class="alert alert-success" role="alert" id="save_topic" style="display: none">
    Тема добавлена. Вы можете <a href="../course.php?id=<?php echo $cod ?>" class="alert-link">перейти на
        страницу лекции</a>.<br>
    Либо создать еще одну страницу.
</div>
<div>
    <div class="topic" id="topic" style="display: none">

        <h4 class="mb-3">Добавтье тему лекции</h4>
        <div id="title" class=" mb-3">
            <label>Наименование темы: </label>
            <input id="topic_title" type="text" class="form-control" name="topic_title" value="">
        </div>
        <div class=" mb-3">
            <label>Содержание:</label>
            <textarea name="topic_description" id="topic_description" class="form-control"
                      style="height: 10rem"></textarea>
        </div>
        <div style="    margin-right: 14px;
    margin-top: 7px;">
            <label> Материалы для курса:</label><br>
        </div>

        <button class="btn btn-outline-secondary" style="margin-top: 9px;" type="button" data-toggle="modal"
                data-target="#add_file" id="add_form"> Добавить файлы
        </button>
        <br>
    </div>


    <button type="button" name="add_topic" id="add_topic" class="btn btn-outline-success">Сохранить тему</button>

</div>
<!--    Тема лекции-->
<div name="about_course"
     id="about_course" class="my-1 p-3 bg-white  shadow-sm ">
    <h4 class="mb-3">Новая лекция</h4>

    <div id="title" class=" mb-3">
        <label>Название лекции </label>
        <input id="lecture_name" type="text" class="form-control" name="title" value="">
    </div>
    <div class=" mb-3">
        <label>Описание лекции</label>
        <textarea name="description" id="description" class="form-control" style="height: 10rem"></textarea>
    </div>

    <!--        <button type="button" id="add_lecture" class="btn btn-outline-success">Сохранить</button>-->
    <button type="button" id="add_lecture" class="btn btn-outline-success" data-toggle="modal"
            data-target="#staticBackdrop">
        Сохранить
    </button>
</div>

</form>
<script>

    $(document).ready(function () {
        $(document).on('click', '#topic_title', function () {
            $('#save_topic').css('display', 'none');
        });


            var files; // переменная. будет содержать данные файлов


            $('input[type=file]').on('change', function(){
                files = this.files;
            });



        $(document).on('click','#addc',function (event) {

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
                    type        : 'POST',
                    data        : data,
                    cache       : false,
                    dataType    : 'json',

                    processData : false,

                    contentType : false,
                    // функция успешного ответа сервера
                    success     : function( respond, status, jqXHR ){
                        $('#myfile').val('');
                        $('#myform_at').val('');

                        //  ОК - файлы загружены
                        if( typeof respond.error === 'undefined' ){
                            //  выведем пути загруженных файлов в блок '.ajax-reply'
                            var files_path = respond.files;
                            var html = '';
                            $.each( files_path, function( key, val ){
                                html += val +'<br>';
                            } );
                            console.log('OK');
                            $('#myform_at').append('Файл добавлен');
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


        $(document).on('click', '#add_lecture', function () {

            var $idcourse = "<?php print $cod ?>";
            var $action = "add_lecture";
            $.ajax({
                method: "POST",
                url: "query_add_lecture.php",
                data: 'title=' + $('#lecture_name').val() + '&description=' + $('#description').val() + '&id_course=' + $idcourse + '&btn_action=' + $action,
                success: function (html) {
                    $('#about_course').css('display', 'none');
                    $('#topic').css('display', 'block');

                    $("#staticBackdrop").append(html);
                },
            })
        })

        $(document).on('click', '#add_topic', function () {
            console.log(document.getElementById('id_lecture').value);

            $.ajax({
                url: "query_topic.php",
                method: "POST",
                data: 'topic_title=' + $('#topic_title').val() + '&topic_desc=' + $('#topic_description').val() + '&id_lectop=' + (document.getElementById('id_lecture').value),
                success: function (html) {

                    $('#save_success').css('display', 'none');
                    $('#save_topic').css('display', 'block');

                    $('#about_course').css('display', 'none');
                    $("#staticBackdrop2").append(html);
                    document.getElementById('topic_title').value = '';
                    document.getElementById('topic_description').value = '';
                }
            })
        })

    });


</script>


<?php


include $_SERVER['DOCUMENT_ROOT'] . "/templates/Footer.php"; ?>
