<?php
include $_SERVER['DOCUMENT_ROOT']."/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";

$idtp=$_GET[idtp];

$page_id=$sql->query("SELECT * FROM page JOIN lecture_topic ON 
lecture_topic.page_id=page.page_id WHERE lecture_topic.lecture_id= '".$idtp ."' ");

echo $_GET[idc];

?>

<div class="my-3 p-3 bg-white rounded shadow-sm">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true"> Тема: </a>
            </li>


<?php
$i=1;
while ( $row =$page_id->fetch_assoc()) {
?>
<li class="page-item "><a methods="GET" class="page-link"
                          href="/student_profile/topic_page.php?idt=<?php echo $row['page_id'] ?>&idtp= <?php echo $idtp ?>  "> <?php echo $i++ ?>  </a>
</li>
<li class="page-item">
    <?PHP
    }
    ?>
<?php
$topic=$sql->query("SELECT * FROM page WHERE page_id= '".$_GET[idt]. "' ");
$page=$topic->fetch_assoc();
?>

<!--    <a class="page-link" href="#"></a>-->


</li>
        </ul>
    </nav>





<h6 class="border-bottom border-gray pb-1 mb-0"> ТЕМА: <?php echo $page['title']   ?>  </h6>
<div class="media text-muted pt-3">
    <p class="media-body pb-3 mb-0  lh-200 border-bottom border-gray">
       <?php echo $page['description']   ?>
    </p>
</div>


</div>


<script>
    $(document).ready(function () {
        $('#id_page button').first().click();
    })
</script>


<?php

include $_SERVER['DOCUMENT_ROOT']."/templates/Footer.php";


?>
