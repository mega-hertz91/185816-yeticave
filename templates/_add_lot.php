        <form class="form form--add-lot container form--invalid <?php if($errors): ?>form--invalid<?php endif;?>" action="/add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
            <h2>Добавление лота</h2>
            <div class="form__container-two">
                <div class="form__item <?php if(check_input($errors, 'lot-name') == true): ?>form__item--invalid<?php endif;?>"> <!-- form__item--invalid -->
                    <label for="lot-name">Наименование</label>
                    <input id="lot-name" type="text" name="lot-name" value="<?=$form_data['lot-name']?>" placeholder="Введите наименование лота" required>
                    <span class="form__error">Введите наименование лота</span>
                </div>
                <div class="form__item">
                    <label for="category">Категория</label>
                    <select id="category" name="category" required>
                        <?php foreach ($categories as  $cat): ?>
                            <option <?php if($cat['name'] === $form_data['category']) {
                                print('selected');
                            } ?>>
                                <?= $cat['name']?></option>
                        <?php endforeach;?>
                    </select>
                    <span class="form__error">Выберите категорию</span>
                </div>
            </div>
            <div class="form__item form__item--wide <?php if(check_input($errors, 'lot-message') == true): ?>form__item--invalid<?php endif;?>">
                <label for="message">Описание</label>
                <textarea id="message" name="message" placeholder="Напишите описание лота"required ><?=$form_data['message']?></textarea>
                <span class="form__error">Напишите описание лота</span>
            </div>
            <div class="form__item form__item--file <?php if(check_input($errors, 'image-lot') == true): ?>form__item--invalid<?php endif;?>"> <!-- form__item--uploaded -->
                <label>Изображение</label>
                <div class="preview">
                    <button class="preview__remove" type="button">x</button>
                    <div class="preview__img">
                        <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
                    </div>
                </div>
                <div class="form__input-file">
                    <input class="visually-hidden" type="file" id="photo2" name="image-lot" value="" required>
                    <label for="photo2">
                        <span>+ Добавить</span>
                    </label>
                </div>
                <span class="form__error">Загрузите изображение в формате ".jpeg, .jpg, .png"</span>
            </div>
            <div class="form__container-three">
                <div class="form__item form__item--small <?php if(check_input($errors, 'lot-rate') == true): ?>form__item--invalid<?php endif;?>">
                    <label for="lot-rate">Начальная цена</label>
                    <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?=$form_data['lot-rate']?>" required>
                    <span class="form__error">Введите начальную цену</span>
                </div>
                <div class="form__item form__item--small <?php if(check_input($errors, 'lot-step') == true): ?>form__item--invalid<?php endif;?>">
                    <label for="lot-step">Шаг ставки</label>
                    <input id="lot-step" type="number" name="lot-step" value="<?=$form_data['lot-step']?>" placeholder="0" required>
                    <span class="form__error">Введите шаг ставки</span>
                </div>
                <div class="form__item">
                    <label for="lot-date">Дата окончания торгов</label>
                    <input class="form__input-date" id="lot-date" type="date" name="lot-date" value="<?=$form_data['lot-date']?>" required>
                    <span class="form__error">Введите дату завершения торгов</span>
                </div>
            </div>
            <div class="form__error
            <?php
            $errors = get_errors_name($errors);
            if($errors): ?>form__error--bottom">
                Пожалуйста, исправьте ошибки в форме.
                <ul>
                    <?php foreach ($errors as $key): ?>
                        <li><?=$key?>: не заполненно поле</li>
                    <?php endforeach;?>
                </ul>
            </div>
            <?php else:?>
                <div class="form__error"></div>
            <?php endif;?>
            <button type="submit" class="button">Добавить лот</button>
        </form>
