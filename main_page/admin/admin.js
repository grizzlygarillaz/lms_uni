$(document).ready(function () {
    document.getElementById("addUser").onclick = function () {
        var re = new RegExp(/^.*\//);
        window.location.href = re + "/main_page/admin/add_user.php";
        alert("ss");
    };
});