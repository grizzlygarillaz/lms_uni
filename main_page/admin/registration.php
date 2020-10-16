<?php
$login = $_POST['login'];
$pass = $_POST['password'];
$user = $_POST['user'];
$name = explode(' ', $user);
$mail = $_POST['mail'];
$role = $_POST['role'];
if (isset($_POST['submit'])) {
$check = $sql->query("SELECT * FROM users WHERE login = '$login'")->fetch_row();
if ($check < 1) {
$role_id = $sql->query("SELECT id FROM role WHERE acces_name = '$role'")->fetch_assoc()["id"];
$sql->query("INSERT INTO users (login,pass,l_name,f_name,email) VALUES ('$login','$pass','$name[0]','$name[1]','$mail')");
$sql->query("INSERT INTO user_role VALUES ('$role_id',LAST_INSERT_ID())");
} else {
echo '<script language="javascript">';
    echo 'alert("Такой пользователь уже существует!!!")';
    echo '</script>';
}
}
$sql->close();
exit("<meta http-equiv='refresh' content='0; url=".$_SERVER['DOCUMENT_ROOT']."/main_page/admin/add_user.php'>");