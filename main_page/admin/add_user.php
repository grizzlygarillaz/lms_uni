<?php
include $_SERVER['DOCUMENT_ROOT']."/templates/Base.php";
include $_SERVER['DOCUMENT_ROOT']."/SQL/sql_connect.php";
$login = $_POST['login'];
$pass = $_POST['password'];
$user = $_POST['user'];
$name = explode(' ', $user);
$mail = $_POST['mail'];
$role = $_POST['role'];
if (isset($_POST['submit']) && !empty($_POST['login'])){
    $check = $sql->query("SELECT * FROM users WHERE login = '$login'")->fetch_row();
    if ($check < 1) {
        $role_id = $sql->query("SELECT id FROM role WHERE acces_name = '$role'")->fetch_assoc()["id"];
        $sql->query("INSERT INTO users (login,pass,l_name,f_name,email) VALUES ('$login','$pass','$name[0]','$name[1]','$mail')");
        $sql->query("INSERT INTO user_role VALUES ('$role_id',LAST_INSERT_ID())");
    } else {
        echo '<script language="javascript">
            alert("Такой пользователь уже существует!!!")
            window.location.replace();
        </script>';
    }
}
//TODO сделать Post/Redirect/Get
?>
<!--TODO сделать Post/Redirect/Get-->
    <div class="bg-white border shadow p-3 pl-4 pr-4"
         style="border-radius: 20px 20px 20px 20px; margin: 15px 10%;  border-color:#cecfd3; position:relative">
    <form method="post">
        <div class="form-group">
            <label for="exampleFormControlSelect1">Пользователь:</label>
            <select name="role" class="form-control" id="exampleFormControlSelect1">
                <?php
                $query=$sql->query("SELECT * FROM role");
                while ($row = $query->fetch_array()){
                    echo "<option>"." ".$row ["acces_name"]."</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Фамилия Имя</label>
            <input required pattern="(^[A-Z]{1}[a-z]{1,14} [A-Z]{1}[a-z]{1,14}$)|(^[А-Я]{1}[а-я]{1,14} [А-Я]{1}[а-я]{1,14}$)"
                   title="Пример: Сергей Есенин"
                name='user' class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Логин</label>
            <input required name='login' class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Пароль</label>
            <input required name='password' class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Почтовый адрес</label>
            <input name='mail' type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <button name="submit" class="btn btn-success" type="submit">Добавить</button>
    </form>
    </div>
<?php
$sql->close();
include $_SERVER['DOCUMENT_ROOT']."/templates/Footer.php";