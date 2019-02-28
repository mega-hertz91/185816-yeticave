<form class="form container <?php if($errors): ?>form--invalid<?php endif;?>" action="/enter.php" method="post"> <!-- form--invalid -->
    <h2>Вход</h2>
    <div class="form__item <?php if(check_input($errors, 'email') == true): ?>form__item--invalid<?php endif;?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$form_data['email']?>">
        <?php if(empty($text_error)):?>
            <span class="form__error">Введите e-mail</span>
        <?php else: ?>
            <span class="form__error"><?=$text_error?></span>
        <?php endif;?>
    </div>
    <div class="form__item form__item--last <?php if(check_input($errors, 'password') == true): ?>form__item--invalid<?php endif;?>">
        <label for="password">Пароль*</label>
        <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?=$form_data['password']?>">
        <?php if(empty($text_error)):?>
            <span class="form__error">Введите пароль</span>
        <?php else:?>
            <span class="form__error"><?=$text_error?></span>
        <? endif;?>
    </div>
    <button type="submit" class="button">Войти</button>
</form>
