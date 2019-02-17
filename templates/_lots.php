<li class="lots__item lot">
    <div class="lot__image">
        <img src="<?=$lot['image']?>" width="350" height="260" alt="">
    </div>
    <div class="lot__info">
        <span class="lot__category"><?=$lot['category']?></span>
        <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?=strip_tags($lot['name'])?></a></h3>
        <div class="lot__state">
            <div class="lot__rate">
                <span class="lot__amount">Стартовая цена</span>
                <span class="lot__cost"><?=strip_tags(around_price($lot['start_price']))?></span>
            </div>
            <div class="lot__timer timer">
                <?=get_time_left('23:59:59', 'now')?>
            </div>
        </div>
    </div>
</li>
