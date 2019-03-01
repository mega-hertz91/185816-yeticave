<section class="lot-item container">
    <h2><?=$lot['name']?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?=$lot['image']?>" width="730" height="548" alt="<?=$lot['name']?>">
            </div>
            <p class="lot-item__category">Категория: <span><?=$lot['category']?></span></p>
            <p class="lot-item__description"><?=$lot['description']?></p>
        </div>
        <div class="lot-item__right">
            <?php if (isset($_SESSION['user'])): ?>
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                    10:54
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <?php if($bet['current_price'] == false): ?>
                        <span class="lot-item__cost"><?=$lot['start_price']?></span>
                        <?php else: ?>
                        <span class="lot-item__cost"><?=$bet['current_price']?></span>
                        <?php endif; ?>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span>12 000 р</span>
                    </div>
                </div>
                <form class="lot-item__form" action="/lot.php?lot_id=<?=$_GET['lot_id']?>" method="post">
                    <p class="lot-item__form-item form__item <?php if($errors): ?>form__item--invalid<?php endif;?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="number" name="cost" placeholder="12 000" value="<?=$user_bet['cost']?>">
                        <?php if(empty($errors)): ?>
                            <span class="form__error"></span>
                        <?php else: ?>
                            <span class="form__error">Введите сумму лота лота</span>
                        <? endif; ?>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <?php endif;?>
            <div class="history">
                <?php if(count($bets) == 0) :?>
                    <h3>Ставок для этого лота нет</h3>
                <? else:?>
                <h3>История ставок (<span><?=count($bets)?></span>)</h3>
            </div>
                <?php foreach ($bets as $key => $value): ?>
                <table class="history__list">
                    <tr class="history__item">
                        <td class="history__name"><?=$value['nikname']?></td>
                        <td class="history__price"><?=$value['price_bet']?> р</td>
                        <td class="history__time"><?=have_date_last($value['date_bet'])?> назад</td>
                    </tr>
                </table>
                <?php endforeach; ?>
            <?php endif;?>
            </div>
        </div>
</section>
