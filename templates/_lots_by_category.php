<main class="container">
    <section class="lots">
        <div class="lots__header">
            <h2><?=$categories[$id -1]['name']?></h2>
        </div>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
            <?php foreach ($lots as $lot): ?>
                <?=include_template('_lots.php', ['lot' => $lot]); ?>
            <?php endforeach;?>
        </ul>
    </section>
</main>
