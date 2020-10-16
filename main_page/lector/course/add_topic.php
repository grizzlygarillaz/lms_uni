<?php
echo "<div name=\"about_course\"
         id=\"about_course\" class=\"my-1 p-3 bg-white  shadow-sm \" >
        <h4 class=\"mb-3\">Новая тема лекции</h4>

            <div id=\"title\" class=\" mb-3\">
                <label >Название темы </label>
                <input  id=\"lecture_name\" type=\"text\" class=\"form-control\" name=\"title\"  value=\"\">
            </div>
            <div class=\" mb-3\">
                <label >Содержание</label>
                <textarea name=\"description\" id=\"description\" class=\"form-control\" style=\"height: 10rem\"  >                    </textarea>
            </div>

        <button type=\"button\" id=\"add_lecture\" class=\"btn btn-outline-success\">Сохранить</button>
    </div>";



