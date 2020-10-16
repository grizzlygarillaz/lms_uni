

$(document).ready(function () {
    // настройки для сайдбара
    var act = getCookie("a_state");
    $('a[act="'+act+'"]').addClass("active");
$(document).on('click', '#mySidebar a', function () {
    $("#mySidebar a").removeClass("active");
    $(this).addClass("active");
    setCookie("a_state",this.getAttribute("act"),1);


    init();
});

function editMode() {
    let newHeight = parseInt($('div #lector_edit').height())/16 + 3;
    $('div #lector_edit').height(newHeight+"rem");
    $('#lector_edit .card .p-4').prepend
    (
        '<div id="editMode" class="bg-light" style="text-align: end">' +
        '<button type="button" class="btn btn-secondary" style=" margin-bottom: 5px">' +
        '<span class="material-icons" style="vertical-align: bottom;">edit</span>' +
        '</button>' +
        '</div>'
    );
    $("#add").css("display","none");
}

function removeEditMode() {
    let undoHeight = parseInt($('div #lector_edit').height())/16 - 3;
    $('div #lector_edit').height(undoHeight+"rem");
    $('#lector_edit .card .p-4');
    $('#lector_edit .card #editMode').remove();
    $("#add").css("display","");
}

    //управление режимом редактирования у преподавателя
    $(document).on('click','#lector_mod #edit', function () {
        if ($("#lector_mod #edit").hasClass('btn-warning')){
            $("#lector_mod #edit")
                .removeClass('btn-warning')
                .addClass('btn-success')
                .text("Сохранить");
            editMode();
        }else {
            $("#lector_mod #edit")
                .removeClass('btn-success')
                .addClass('btn-warning')
                .text("Редактировать");
            removeEditMode();
        }
    })

});
