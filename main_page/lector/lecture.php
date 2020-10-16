<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php"; ?>
    <div id="" class="btn-group mb-3" role="group" aria-label="Basic example">
        <button id="edit" type="button" class="btn btn-warning "  >Редактировать</button>
        <button id="save" type="button" class="btn btn-secondary "  >Сохранить</button>

    </div>
<?php
$topic = $sql->query("SELECT * FROM page WHERE lecture_id= '" . $_GET[idl] . "' ");
$page = $topic->fetch_assoc();

$col_topic = $sql->query("SELECT * FROM page where lecture_id='" . $_GET[idl] . "' ");

$i = 1;

?>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
        <nav id="topic" aria-label="Page navigation example">
            <p class="text-center"> Выбери тему лекции </p>
            <ul class="pagination justify-content-center">

                <?php while ($row = $col_topic->fetch_assoc()) { ?>
                    <li id="id_page" value="<?php echo $row['page_id'] ?>" class="page-item ">
                        <a id="nav_col" class="page-link" > <?php echo $i++ ?></a></li>
                <?php } ?>
            </ul>
        </nav>
        <div id="content">
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#edit').prop('disabled', true);
            $('#save').prop('disabled', true);

            $(document).ready(function () {
                $('#id_page').first().click();
            })

            $(document).on('click', '#id_page', function () {
                let id = $(this).val();

                $.ajax({
                    method: "POST",
                    url: "topic_page.php",
                    data: 'id_topic=' + $(this).val(),
                    success: function (html) {
                        $('#content').html(html);
                        $('#edit').prop('disabled', false);
                        $('#save').prop('disabled', true);

                    }
                })
            });
            $(document).on('click', '#edit', function () {
                let title = document.getElementById('title').textContent,
                    description = document.getElementById('description').textContent;
                id = document.getElementById('id').textContent;


                $.ajax({
                    method: "POST",
                    url: "course/lector_mod.php",
                    data: 'title=' + title + '&description=' + description + '&idlm=' + id,
                    success: function (html) {
                        $('#content').html(html);
                        $('#edit').prop('disabled', true);
                        $('#save').prop('disabled', false);
                        $('#save').addClass('btn btn-success');
                    }
                })
            });
            $(document).on('click', '#save', function () {
                let title = $('#lecture_name').val(),
                    desc = $('#desc').val(),

                    page_id = document.getElementById('idlm').textContent;
                $.ajax({
                    method: "POST",
                    url: "course/edit_query.php",
                    data: 'title=' + title + '&des=' + desc + '&page_id=' + page_id,
                    success: function (html) {
                        $('#content').html(html);
                        $('#save').addClass('btn btn-secondary');
                        // $('#edit').prop('disabled', false);
                        $('#save').prop('disabled', false);

                    }
                })
            });
            $(document).on('click', '#del_topic', function () {
                let idTopic= $(this).val();

                $.ajax({
                    method: "POST",
                    url: "del_topic.php",
                    data: 'id='+idTopic,
                    success: function () {
                        window.location.reload();
                    }


                })
            })
        })

    </script>


<?php
print $_GET[id];
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Footer.php";

?>