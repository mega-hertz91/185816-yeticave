    <form class="form container" action="/sing-up.php" method="post"> <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?php if(check_input($errors, 'email') == true): ?>form__item--invalid<?php endif;?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$form_data['email']?>" required>
            <span class="form__error">Введите e-mail</span>
        </div>
        <div class="form__item <?php if(check_input($errors, 'password') == true): ?>form__item--invalid<?php endif;?>">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?=$form_data['password']?>" required>
            <span class="form__error">Введите пароль</span>
        </div>
        <div class="form__item <?php if(check_input($errors, 'name') == true): ?>form__item--invalid<?php endif;?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" placeholder="Введите имя" required>
            <span class="form__error">Введите имя</span>
        </div>
        <div class="form__item <?php if(check_input($errors, 'message') == true): ?>form__item--invalid<?php endif;?>">
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="message" placeholder="Напишите как с вами связаться" required>
                <?=$form_data['message']?>
            </textarea>
            <span class="form__error">Напишите как с вами связаться</span>
        </div>
        <div class="form__item form__item--file form__item--last">
            <label>Аватар</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
