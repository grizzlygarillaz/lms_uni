<?php
unset($_SESSION['user_id'],
    $_SESSION['user_fn'],
    $_SESSION['user_ln']);
include     $_SERVER['DOCUMENT_ROOT']."/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";
if (isset($_POST['enter'])){
    session_start();
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $result = $sql->query("SELECT * FROM users WHERE login ='" . $login . "'");
    $query = $result->fetch_assoc();
    if ($query['pass'] === $_POST['pass']) {
        $_SESSION['user_id'] = $query['id'];
        $_SESSION['user_fn'] = $query['f_name'];
        $_SESSION['user_ln'] = $query['l_name'];
        $id1= $query['id'];
        $id = $_SESSION['user_id'];
        $result = $sql->query("SELECT * FROM role JOIN user_role ON user_role.role_d = role.id WHERE user_role.user_id = '" . $id . "'");
        $query = $result->fetch_assoc();
        $_SESSION['role'] =  $query['id'];
        switch ($query['id']) {
            case '1':
                exit("<meta http-equiv='refresh' content='0; url=http://tisbi-lms.ru/main_page/lector/lector.php'>");
//                header("location: http://tisbi-lms.ru/main_page/lector.php");
                break;
            case '2':
                exit("<meta http-equiv='refresh' content='0; url=http://tisbi-lms.ru/main_page/student.php'>");
                break;
            case '3':
                exit("<meta http-equiv='refresh' content='0; url=http://tisbi-lms.ru/main_page/admin/admin.php'>");
                break;
        }
    } else {
        echo("Не правильный логин или пароль");
    }
    $sql->close();
}
?>
    <div class="container">
        <div class="card text-black-50 mb-3">
            <div class="card-header bg-light">Авторизация</div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Логин</label>
                        <input type="text" class="form-control" placeholder="Введите логин" name="login">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Пароль</label>
                        <input type="password" class="form-control" placeholder="Введите пароль" name="pass" id="exampleInputPassword1">
                    </div>
                    <button type="submit" name="enter" class="btn btn-warning">Войти</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <footer class="footer bottom">
        <div class="bg-light" style="height: 5rem">

        </div>
    </footer>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </html>
<?php
$sql->close();