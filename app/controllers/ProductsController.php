<?php

namespace app\controllers;

use app\core\InitController;
use app\lib\UserOperations;
use app\models\ProductsModels;

class ProductsController extends InitController
{
    public function behaviors()
    {
        return [
            'access' => [
                'rules' => [
                    [
                        'actions' => ['list'],
                        'roles' => [UserOperations::RoleUser, UserOperations::RoleAdmin],
                        'matchCallback' => function () {
                            $this->redirect('/user/login');
                        }
                    ],
                    [
                        'actions' => ['add', 'edit', 'delete'],
                        'roles' => [UserOperations::RoleAdmin],
                        'matchCallback' => function () {
                            $this->redirect('/products/list');
                        }
                    ],
                ]
            ]
        ];
    }

    public function actionList()
    {
        $this->view->title = 'Товары';
        $products_model = new ProductsModels();
        $products = $products_model->getListProducts();
        $this->render('list', [
            'sidebar' => UserOperations::getMenuLinks(),
            'products' => $products,
            'role' => UserOperations::getRoleUser(),
        ]);
    }

    public function actionAdd()
    {
        $this->view->title = 'Добавление товара';
        $error_message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['btn_products_add_form'])) {
            $products_data = !empty($_POST['products']) ? $_POST['products'] : null;
            $cover = !empty($_FILES['cover']['tmp_name']) ? $_FILES['cover']['tmp_name'] : null;
            if (!empty($products_data)) {
                if (!empty($cover)) {
                    $userModel = new ProductsModels();
                    $result_add = $userModel->add($products_data, $cover);
                    if ($result_add['result']) {
                        $this->redirect('/products/list');
                    } else {
                        $error_message = $result_add['error_message'];
                    }
                }
            }
        }
        $this->render('add', [
            'sidebar' => UserOperations::getMenuLinks(),
            'error_message' => $error_message
        ]);
    }



    public function actionEdit()
    {
        $this->view->title = 'Редактирование товара';
        $products_id = !empty($_GET['products_id']) ? $_GET['products_id'] : null;
        $products = null;
        $error_message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['btn_products_edit_form'])) {
            $products_data = !empty($_POST['products']) ? $_POST['products'] : null;
            $cover = !empty($_FILES['cover']['tmp_name']) ? $_FILES['cover']['tmp_name'] : null;
            if (!empty($products_data)) {
                if (!empty($cover)) {
                    $userModel = new ProductsModels();
                    $result_edit = $userModel->edit($products_id, $products_data, $cover);
                    if ($result_edit['result']) {
                        $this->redirect('/products/list');
                    } else {
                        $error_message = $result_edit['error_message'];
                    }
                }
            }
        }
        if (!empty($products_id)) {
            $products_model = new ProductsModels();
            $products = $products_model->getProductsById($products_id);
            if (empty($products)) {
                $error_message = 'Товар не найден!';
            }
        } else {
            $error_message = 'Отсутствует идентификатор записи!';
        }
        $this->render('edit', [
            'sidebar' => UserOperations::getMenuLinks(),
            'products' => $products,
            'error_message' => $error_message
        ]);
    }

    public function actionDelete()
    {
        $this->view->title = 'Редактирование товара';
        $products_id = !empty($_GET['products_id']) ? $_GET['products_id'] : null;
        $products = null;
        $error_message = '';
        if (!empty($products_id)) {
            $products_model = new ProductsModels();
            $products = $products_model->getProductsById($products_id);
            if (!empty($products)) {
                $result_delete = $products_model->deleteById($products_id);
                if ($result_delete['result']) {
                    $this->redirect('/products/list');
                } else {
                    $error_message = $result_delete['error_message'];
                }
            } else {
                $error_message = 'Товар не найден!';
            }
        } else {
            $error_message = 'Отсутствует идентификатор записи!';
        }
        $this->render('delete', [
            'sidebar' => UserOperations::getMenuLinks(),
            'products' => $products,
            'error_message' => $error_message
        ]);
    }

    public function actionAdd_Cart()
    {

    }
}