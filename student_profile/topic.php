<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php"; ?>

<?php
$topic = $sql->query("SELECT * FROM page WHERE lecture_id= '" . $_GET[idc] . "' ");
$page = $topic->fetch_assoc();

$col_topic = $sql->query("SELECT * FROM page where lecture_id='" . $_GET[idc] . "' ");

$i = 1;

?>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
        <nav id="topic" aria-label="Page navigation example">
            <p class="text-center"> Выбери тему лекции </p>
            <ul class="pagination justify-content-center">

                <?php while ($row = $col_topic->fetch_assoc()) { ?>
                    <span data-toggle="tooltip" data-placement="bottom" title="<?php echo $row['title'] ?>">
                    <li id="id_page" value="<?php echo $row['page_id'] ?>"  class="page-item " >
                        <a type="button" id="nav_col"  class="page-link" > <?php echo $i++ ?></a></li></span>
                <?php } ?>
            </ul>
        </nav>
     
        <div id="content">
        </div>
    </div>

    <script>
        $(document).ready(function () {

            $(document).ready(function () {
                $('#id_page').first().click();
            })

            $(document).on('click', '#id_page', function () {
                let id = $(this).val();

                $.ajax({
                    method: "POST",
                    url: "../main_page/lector/topic_page.php",
                    data: 'id_topic=' + $(this).val(),
                    success: function (html) {
                        $('#content').html(html);
                        $('#edit').prop('disabled', false);
                        $('#save').prop('disabled', true);

                    }
                })

            });


        })

    </script>


<?php
print $_GET[id];
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Footer.php";

?>