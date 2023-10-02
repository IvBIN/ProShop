<?php
/** @var array $sidebar - Меню */
/** @var array $products - Товар */
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
                    <h2>Редактирование Товара</h2>
                    <form method="post" name="products_add_form" enctype="multipart/form-data">
                        <div class="products_add_form">
                            <div class="alert alert-danger <?= !empty($error_message) ? null : 'hidden' ?>">
                                <?= !empty($error_message) ? $error_message : null ?>
                            </div>
                            <?php if (!empty($products)): ?>
                                <div class="input_box">
                                    <label for="field_title">Наименование</label>
                                    <input type="text"
                                           name="products[title]"
                                           id="field_title"
                                           class="form-control"
                                           maxlength="120"
                                           value="<?= !empty($_POST['products']['title']) ? $_POST['products']['title'] : !empty($products['title']) ? $products['title'] : '' ?>"
                                           placeholder="Введите наименование"
                                    >
                                </div>

                                <div class="input_box">
                                    <label for="field_description">Описание</label>
                                    <textarea
                                        name="products[description]"
                                        id="field_description"
                                        cols="50"
                                        rows="8"
                                        placeholder="Введите описание"
                                    ><?= !empty($_POST['products']['description'])
                                            ? $_POST['products']['description']
                                            : (!empty($products['description']) ? $products['description'] : '')
                                        ?></textarea>
                                </div>

                                <div class="input_box">
                                    <label for="field_price">Цена</label>
                                    <input type="text"
                                           name="products[price]"
                                           id="field_price"
                                           class="form-control"
                                           maxlength="120"
                                           value="<?= !empty($_POST['products']['price'])
                                               ? $_POST['products']['price']
                                               : !empty($products['price']) ? $products['price'] : ''
                                           ?>"
                                           placeholder="Введите цену"
                                    >
                                </div>

                                <div class="input_box">
                                    <label for="field_count">Количество</label>
                                    <input type="text"
                                           name="products[count]"
                                           id="field_count"
                                           class="form-control"
                                           maxlength="120"
                                           value="<?= !empty($_POST['products']['count'])
                                               ? $_POST['products']['count']
                                               : !empty($products['count']) ? $products['count'] : ''
                                           ?>"
                                           placeholder="Введите количество"
                                    >
                                </div>

                                <div class="input_box">
                                    <label for="cover">Добавьте изображение товара</label>
                                    <input type="file"
                                           name="cover"
                                           id="field_cover"
                                           class="form-control"
                                           maxlength="24"
                                           placeholder="Добавьте изображение товара"
                                    >
                                </div>

                                <div class="button_box">
                                    <button type="submit"
                                            name="btn_products_edit_form"
                                            id="btnNewsEditForm"
                                            class="btn btn-primary"
                                            value="1"
                                    >Редактировать
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </dib>
            </div>
        </div>
    </div>
</div>
