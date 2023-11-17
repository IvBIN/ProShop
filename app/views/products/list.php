<?php
/** @var array $sidebar - Меню */
/** @var string $role - Список товаров */
/** @var array $products - Роль пользователя */

use app\lib\UserOperations;

?>
<div class="page">
    <div class="container">
        <div class="header">
            <img class="logo" src="/app/views/images/Logo_Proshop2.png" alt="logo">
            <form class="search" method="get">
                <input type="text" placeholder="Поиск по сайту">
                <input type="submit" value="Найти">
            </form>

        </div>
        <div class="cabinet_wrapped">
            <div class="cabinet_sidebar">
                <?php if (!empty($sidebar)) : ?>
                    <div class="menu_box">
                        <ul>
                            <?php foreach ($sidebar as $link) : ?>
                                <li>
                                    <a href="<?= $link['link'] ?>"><?= $link['title'] ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div class="cabinet_content">
                <dib class="page-content-inner">
                    <h2>Товары</h2>
                    <div class="products-block">
                        <div class="links_box text-end">
                            <a href="/products/add" class="btn_add">Добавить</a>
                        </div>
                        <?php if (!empty($products)) : ?>
                            <div class="products-list">
                                <?php foreach ($products as $item) :?>
                                    <div class="products-item">
                                        <h3>
                                            <?=$item['title']?><br><span> от <?= date('d.m.Y H:i:s',strtotime($item['date_create']))?></span>
                                            <?php if ($role === UserOperations::RoleAdmin) :?><br>
                                                (<a href="/products/edit?products_id=<?=$item['id']?>">Редактировать</a>
                                                <a href="/products/delete?products_id=<?=$item['id']?>">Удалить</a>)
                                            <?php endif ?>
                                        </h3>
                                        <div class="products_info">
                                            <div class="products-description"><?=$item['description']?></div>
                                            <div class="products-price"><b>Цена, ₽: <?=$item['price']?><b></div>
                                            <div class="products-count"><b>Количество: <?=$item['count']?><b></div>
                                        <img src="data:image/png; base64,<?=$item['cover']?>" alt="cover">
                                        </div>

                                        <a href="/products/add_cart?id=<?php echo $item['id'] ?>">Купить</a>

<!--                                        <form class="btn_buy" method="post">-->
<!--                                            <input class="btn_sub" type="text" value="--><?php //echo $_GET['id'] ?><!--" name="id_item" style="display: none">-->
<!--                                            <input class="btn_name" type="submit" value="Купить">-->
<!--                                        </form>-->


                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </dib>
            </div>
        </div>
    </div>
</div>