function TransformNav() {
    if ($("#mySidebar").width() == "0") {
        openNav();
    }else
    {
        closeNav();
    }
}

function openNav() {
    $("#mySidebar").width(250);
    if ($(document).width() >= 450){
        $("#main").css('margin-left',"250px");
    }
    $("#menu:active").css("color","white");
}

/* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
function closeNav() {
    $("#mySidebar").width(0);
    $("#main").css('margin-left',"0px");
    $("#MoveNav").blur();
    $("#menu:active").css("color","#F1C107");
}

$(document).ready(function () {
    var header = $('.header'),
        scrollPosition = $(window).scrollTop();
    $(window).scroll(function () {
        if ((scrollPosition - $(window).scrollTop()) >= 0) {
            header.removeClass('out');
        }
        else {
            header.addClass('out');
        }
        scrollPosition = $(window).scrollTop();
    });
});


function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}

