<?php
/** @var array $sidebar - Меню */
/** @var string $role - Список новостей */
/** @var array $news - Роль пользователя */

use app\lib\UserOperations;

?>
<div class="page">
    <div class="container">
        <div class="header">
            <img class="logo" src="/app/web/images/Logo_Proshop2.png" alt="logo">
            <form class="search" method="get">
                <input class="text_input" type="text" placeholder="Поиск по сайту">
                <input class="submit_input" type="submit" value="Найти">
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
                    <h2>Новости</h2>
                    <div class="news-block">
                        <div class="links_box text-end">
                            <a href="/news/add" class="btn_add">Добавить</a>
                        </div>
                        <?php if (!empty($news)) : ?>
                        <div class="news-list">
                            <?php foreach ($news as $item) :?>
                                <div class="news-item">
                                    <h3>
                                        <?=$item['title']?><span> от <?= date('d.m.Y H:i:s',strtotime($item['date_create']))?></span>
                                        <?php if ($role === UserOperations::RoleAdmin) :?>
                                        (<a href="/news/edit?news_id=<?=$item['id']?>">Редактировать</a>
                                            <a href="/news/delete?news_id=<?=$item['id']?>">Удалить</a>)
                                        <?php endif ?>
                                    </h3>
                                    <div class="news-short_description"><?=$item['short_description']?></div>
                                    <div class="news-description"><?=$item['description']?></div>
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