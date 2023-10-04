<?php
/** @var array $sidebar - Меню */
/** @var string $role - Список товаров */
/** @var array $products - Роль пользователя */

use app\lib\UserOperations;

?>
<div class="page">
    <div class="container">
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
                            <a href="/products/add">Добавить</a>
                        </div>
                        <?php if (!empty($products)) : ?>
                            <div class="products-list">
                                <?php foreach ($products as $item) :?>
                                    <div class="products-item">
                                        <h3>
                                            <?=$item['title']?><span> от <?= date('d.m.Y H:i:s',strtotime($item['date_create']))?></span>
                                            <?php if ($role === UserOperations::RoleAdmin) :?>
                                                (<a href="/products/edit?products_id=<?=$item['id']?>">редактировать</a>
                                                <a href="/products/delete?products_id=<?=$item['id']?>">Удалить</a>)
                                            <?php endif ?>
                                        </h3>
                                        <div class="products-description"><?=$item['description']?></div>
                                        <div class="products-price">Цена (руб): <?=$item['price']?></div>
                                        <div class="products-count">Количество: <?=$item['count']?></div>
                                        <img src="data:image/png; base64,<?=$item['cover']?>" alt="cover">
                                        <a class="btn_buy" href="#">Купить</a>



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