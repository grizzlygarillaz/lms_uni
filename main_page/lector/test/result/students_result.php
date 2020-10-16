<?php
include $_SERVER['DOCUMENT_ROOT'] . "/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/sql_connect.php";
session_start();
$course_id = $_GET['course'];
$user = $_SESSION['user_id'];
$test_id = $_GET['test_id'];

$course = $sql->query("SELECT * FROM course WHERE course_id ='$course_id'");
$test = $sql->query("SELECT * FROM test WHERE id = '$test_id'");
?>
<div id="lector_add_course" class="jumbotron p-1 mb-1 p-md-2 text-white d-flex align-items-center " style="background: #2D3142 !important;">
    <button id="goBack" class="btn btn-outline-light " style="align-self: stretch" title="Назад">
            <span class="material-icons d-flex warning">
                backspace
            </span>
    </button>
    <div class="col-md-8 px-0 pl-2 font-italic">
        <h1 class="display-6">Результаты студентов</h1>
        <h2>Тест : "<?echo $test->fetch_assoc()['title']?>"</h2>
    </div>
</div>
<div class="d-flex bg-dark rounded mb-1" style="background: #2D3142 !important;">
    <div class="input-group m-2 w-75">
        <input id="search" type="text" class="form-control" placeholder="Поиск студентов" aria-label="Поиск студентов" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <span class="input-group-text" id="basic-addon2">
                <span class="material-icons">
                search
                </span>
                Поиск
            </span>
        </div>
    </div>
</div>

<div class="d-flex p-2 rounded" style="background: #2D3142 !important">
    <table class="table m-0 table-hover" style="background: #2D3142 !important; color: #2D3142 !important; font-family: 'Montserrat', sans-serif">
        <thead>
        <tr class="table-light">
            <th scope="col">Имя</th>
            <th scope="col">Фамилия</th>
            <th scope="col">Результат</th>
        </tr>
        </thead>
        <tbody class="table-light table-hover" style="font-weight: bold" ">
        <? $student_id = $sql->query("SELECT * FROM user_result WHERE test_id = '$test_id' GROUP BY user_id");
            while ($student = $student_id->fetch_assoc()){
            $studentName = $sql->query("SELECT * FROM users WHERE id = '".$student['user_id']."'")->fetch_assoc();
            echo ' 
                <tr>
                  <td>'.$studentName["f_name"].'</td>
                  <td id="name">'.$studentName["l_name"].'</td>
                  <td style="font-size: large">'.$student['result'].'</td>
                </tr>
            ';
            }?>
        </tbody>
    </table>
</div>

<?php
$applications=$sql->query("SELECT * FROM application JOIN users ON application.user_id= users.id 
WHERE application.status=2 and application.course_id= '$course_id'");
?>

    <script>
        $(document).ready(function () {
            $('#search').on('input keyup',function () {
                let val = this.value.trim().toLowerCase();
                let courseitem = document.querySelectorAll('#name ');
                console.log(courseitem);
                if (val != '') {
                    courseitem.forEach(function (elem) {
                        if (elem.innerText.toLowerCase().search(val) == -1) {
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
            });
            $(document).on('click','#goBack',function () {
                $("#main").html("" +
                    "        <div id=\"loadPage\" class=\"spinner-grow text-dark\" role=\"status\" style=\"margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;\">\n" +
                    "            <span class=\"sr-only\">Loading...</span>\n" +
                    "        </div>");
                window.location.href = "all_test.php?course_id=<?=$course_id?>";
            })

        });
    </script>

<?php
include $_SERVER['DOCUMENT_ROOT']."/templates/Footer.php";
