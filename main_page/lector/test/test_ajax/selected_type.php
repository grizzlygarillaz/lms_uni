<?php
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";
$type = $_GET["type"];
$addAnswer = $_GET["addAnswer"];
$closeButton = "
            <button id=\"deleteAnswer\" type=\"button\" class=\"close ml-2\" aria-label=\"CloseAnswer\">
                <span aria-hidden=\"true\">&times;</span>
            </button>";

function checkbox($close = "") {
    echo '  <div class="btn-group d-flex w-100 m-1 Answer">          
                <label id="correctAnswer" class="input-group-prepend btn btn-outline-success ">
                    <input type="checkbox" name="correctAnswer" autocomplete="off">
                    <span class="material-icons">
                        done
                    </span>
                </label>
                    <input type="text" class="outline-light form-control textAnswer" placeholder="Введите вариант ответа">
                ' .$close.'
                </div>
            ';
    }
function radiobutton($close = "") {
echo '<div class="btn-group d-flex w-100 m-1 Answer">   
                <label id="correctAnswer" class="input-group-prepend btn btn-outline-success ">
                    <input type="radio" name="correctAnswer" autocomplete="off" checked>
                    <span class="material-icons">
                        done
                    </span>
                </label>
                    <input type="text" class="outline-light form-control textAnswer" placeholder="Введите вариант ответа">
                    ' .$close.'
                </div>
            ';
}


function firstCheckbox($type) {
    echo '<div id="addAnswer_form" class="bg-white rounded shadow-sm mt-3 p-3 addAnswer" >
                <p>Введите варианты ответа и отметьте правильные</p>
            <div id="radiobuttonAnswer" class="input-group btn-group-toggle d-flex w-100 mt-2" data-toggle="buttons">
             ';
    echo checkbox("");
    echo checkbox("").'
                <button id="add_answer" value="'.$type.'" class="btn btn-success mt-2 w-100" title="Добавить вариант ответа" style="height: 38px">
                    <span class="material-icons">
                    add
                    </span>
                </button>        
            </div>
            </div>';
}
function firstRadiobutton($type) {
    $empty = "";
    echo '<div id="addAnswer_form" class="bg-white rounded shadow-sm mt-3 p-3 addAnswer">
                <p>Введите варианты ответа и отметьте правильный</p>
            <div id="radiobuttonAnswer" class="input-group btn-group-toggle d-flex w-100 mt-2" data-toggle="buttons">';
    echo radiobutton($empty);
    echo radiobutton($empty).'
                  <button id="add_answer" value="'.$type.'" class="btn btn-success mt-2 w-100" title="Добавить вариант ответа" style="height: 38px">
                    <span class="material-icons">
                    add
                    </span>
                </button>    
            </div>
            </div>';
}

switch ($type){
    case '2':
        firstCheckbox($type);
        break;
    case '1':
        firstRadiobutton($type);
        break;
}


switch ($addAnswer) {
    case '2':
        checkbox($closeButton);
        break;
    case '1':
        radiobutton($closeButton);
        break;
}

sleep(0.2);