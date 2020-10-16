<form name="myform" action="#" method="post" onsubmit="return save()">
    <p>
        <input type="hidden" id="content" name="content" value="" />
    </p>
    <script type="text/javascript">
        // Вывод кнопок редактирования
        document.write("<input type='button' value='B' onclick='setBold()' />");
        document.write("<input type='button' value='I' onclick='setItal()' />");
        document.write("<br />");
        document.write("<iframe scrolling='no' frameborder='no' src='#' id='frameId' name='frameId'></iframe>"); // Добавляем iframe
        /* В зависимости от браузера получаем доступ к созданному фрейму */
        var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;
        var iframe = (isGecko) ? document.getElementById("frameId") : frames["frameId"];
        var iWin = (isGecko) ? iframe.contentWindow : iframe.window;
        var iDoc = (isGecko) ? iframe.contentDocument : iframe.document;
        /* Создаём код пустой HTML-страницы */
        iHTML = "<html><head></head><body style='background-color: yellow;'></body></html>";
        iDoc.open(); // Открываем фрейм
        iDoc.write(iHTML); // Добавляем написанный код в фрейм
        iDoc.close(); // Закрываем фрейм
        iDoc.designMode = "on"; // Включаем режим редактирования фрейма
        /* Функции для задания внешнего вида выделенного текста
        Полный набор возможных команд: http://javascript.itsoft.ru/execcom/execCommands.html */
        function setBold() {
            iWin.focus();
            iWin.document.execCommand("bold", null, "");
        }
        function setItal() {
            iWin.focus();
            iWin.document.execCommand("italic", null, "");
        }
        function save() {
            /* Сохранение HTML-кода в поле hidden, чтобы потом можно было передать полученный HTML-код в скрипт-обработчик */
            document.getElementById("content").value = iDoc.body.innerHTML;
            return true;
        }
    </script>
    <p>
        <input type="submit" value="Отправить" />
    </p>
</form>