<?php include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
$test_id = $_GET['test'];
$test_title = $_GET['title'];

$sql->query("UPDATE test SET title = '$test_title' WHERE id = '$test_id'");
sleep(0.1);
$newTitle = $sql->query("SELECT * FROM test WHERE id = '$test_id'");
?>
<h3>"<?= $newTitle->fetch_assoc()['title'] ?>"
    <button id="editTitle" class="btn btn-outline-secondary">
        <span class="material-icons">
            create
        </span>
    </button>
</h3>
<button id="saveTest" class="btn btn-warning mr-5">Сохранить</button>