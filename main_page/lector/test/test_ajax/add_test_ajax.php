<form class="addcourse" name="add_course" id="add_course">

    <div name="about_course"
         id="about_course" class="my-3 p-3 bg-white rounded shadow-sm mx-auto">
        <h4 class="mb-3">Новый курс</h4>
        <form id="add" class="needs-validation" novalidate="">
            <!-- Данные о курсе-->
            <div id="fname" class=" mb-3">
                <label>Полное название курса</label>
                <input id="full_name" type="text" class="form-control" name="full_name" value="">
            </div>
            <div id="sname" class=" mb-3">
                <label>Краткое название курса</label>
                <input type="text" id="short_name" class="form-control" name="short_name" value="">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label> Категория </label>
                    <select class="custom-select d-block w-100" id="category" name="category">
                        <option value="">Выбрать</option>
                        <?php $id_category = $sql->query("SELECT * FROM category ");
                        while ($category = $id_category->fetch_assoc()) { ?>
                            <option
                                name="cat"
                                value="<?php echo $category['code_category'] ?>"> <?php echo $category['category_title'] ?> </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label> Тип курса: </label>
                    <select name="type_course" id="type_course" class="custom-select  w-100" ">
                    <option value="">Выбрать</option>
                    <option id="1" value="1"> Открытый</option>
                    <option id="2" value="2"> Закрытый</option>
                    </select>
                </div>
            </div>

            <div class=" mb-3">
                <label>Описание курса</label>
                <textarea name="description" id="description" class="form-control">                    </textarea>
            </div>
            <hr class="mb-4">
            <!--       Кнопки     -->
            <div id="btn_course">
                <button name="save_course" id="save_course" class="btn btn-outline-success"> Сохранить курс</button>
            </div>

    </div>
</form>