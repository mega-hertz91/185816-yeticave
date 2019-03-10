<main class="container">
    <section class="lots">
        <div class="lots__header">
            <h2><?=$categories[$id -1]['name']?></h2>
        </div>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
            <?php if(empty($lots)): ?>
                 <h3>В данной категории пока нет лотов</h3>
            <?php else:?>
                <?php foreach ($lots as $lot): ?>
                    <?=include_template('_lots.php', ['lot' => $lot]); ?>
                <?php endforeach;?>
            <?php endif;?>
        </ul>
    </section>
</main>
