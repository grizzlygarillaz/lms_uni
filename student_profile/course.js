$(document).ready(function () {
    $(document).on('click', 'nav .page-item', function () {
        $(".pagination .page-item").removeClass("active");
        $(this).addClass("active");
    });
});
