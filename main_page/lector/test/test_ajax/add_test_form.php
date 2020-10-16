<?php
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
?>
<div id="addTest_form" class="bg-white rounded shadow-sm mt-3 p-3 addTest_form" >
    <h5 class="">Новый вопрос
        <button id="close" type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </h5>
    <div id="questionForm" class="form-group">
        <label for="question">Введите вопрос:</label>
        <textarea required class="form-control" id="question" rows="2"></textarea>
    </div>

    <div id="TypeForm" class="form-group">
        <label for="questionType">Тип вопроса:</label>
        <select id='questionType' required class="form-control">
            <option disabled selected>Выберите тип</option>
            <?php $questionType = $sql->query("SELECT * FROM question_type");
            while ($type = $questionType->fetch_assoc())
            {
                echo "<option value='" . $type['id'] . "'>" . $type['type'] . "</option>";
            }
            ?>
        </select>

    </div>
    <div id="answers">

    </div>

</div>