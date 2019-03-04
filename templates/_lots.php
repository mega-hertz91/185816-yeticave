<li class="lots__item lot">
    <div class="lot__image">
        <img src="<?=$lot['image']?>" width="350" height="260" alt="">
    </div>
    <div class="lot__info">
        <span class="lot__category"><?=$lot['category']?></span>
        <h3 class="lot__title"><a class="text-link" href="/lot.php?lot_id=<?=$lot['id']?>"><?=strip_tags($lot['name'])?></a></h3>
        <div class="lot__state">
            <div class="lot__rate">
                <span class="lot__amount">Стартовая цена</span>
                <span class="lot__cost"><?=strip_tags(around_price($lot['start_price']))?></span>
            </div>
            <?php if(have_date_left($lot['finish_date']) === false): ?>
                <div class="lot-item__timer timer" style="background-color: red">
                    Закрыт
                </div>
            <?php else:?>
                <div class="lot-item__timer timer">
                    <?=have_date_left($lot['finish_date'])?>
                </div>
            <? endif; ?>
        </div>
    </div>
</li>
