<?php
namespace app\models;

use app\core\BaseModel;

class ProductsModels extends BaseModel
{
    public function add($products_data, $cover)
    {
        $cover = base64_encode(file_get_contents($cover));


        $result = false;
        $error_message = '';
        if (empty($products_data['title'])) {
            $error_message .= "Введите наименование! <br>";
        }
        if (empty($products_data['description'])) {
            $error_message .= "Введите описание! <br>";
        }
        if (empty($products_data['price'])) {
            $error_message .= "Введите цену! <br>";
        }
        if (empty($products_data['count'])) {
            $error_message .= "Введите количество! <br>";
        }
        if (empty($cover)) {
            $error_message .= "Вложите изображение! <br>";
        }
        if (empty($error_message)) {
            $result = $this ->insert(
                "INSERT INTO products (title, description, price, count, cover, date_create, user_id)
                    values (:title, :description, :price, :count, :cover, NOW(), :user_id)",
                [
                    'title' => $products_data['title'],
                    'description' => $products_data['description'],
                    'price' => $products_data['price'],
                    'count' => $products_data['count'],
                    'cover' => $cover,
                    'user_id' => $_SESSION['user']['id'],
                ]
            );
        }

        return [
            'result' => $result,
            'error_message' => $error_message
        ];
    }

    public function getListProducts()
    {
        $result = null;

        $products = $this->select('select * from products');
        if (!empty($products)) {
            $result = $products;
        }
        return $result;
    }

    public function edit($products_id, $products_data, $cover)
    {
        $cover = base64_encode(file_get_contents($cover));

        $result = false;
        $error_message = '';
        if (empty($products_id)) {
            $error_message .= "Отсутствует идентификатор записи! <br>";
        }
        if (empty($products_data['title'])) {
            $error_message .= "Введите наименование! <br>";
        }
        if (empty($products_data['description'])) {
            $error_message .= "Введите описание! <br>";
        }
        if (empty($products_data['price'])) {
            $error_message .= "Введите цену! <br>";
        }
        if (empty($products_data['count'])) {
            $error_message .= "Введите количество! <br>";
        }
        if (empty($cover)) {
            $error_message .= "Вложите изображение! <br>";
        }

        if (empty($error_message)) {
            $result = $this ->update(
                "UPDATE products SET title = :title, description = :description,
                    price = :price, count = :count, cover = :cover where id = :id",
                [
                    'title' => $products_data['title'],
                    'description' => $products_data['description'],
                    'price' => $products_data['price'],
                    'count' => $products_data['count'],
                    'cover' => $cover,
                    'id' => $products_id,
                ]
            );
        }

        return [
            'result' => $result,
            'error_message' => $error_message
        ];
    }

    public function getProductsById($products_id)
    {
        $result = null;
        $products = $this->select('select * from products where id = :id',[
            'id' => $products_id
        ]);
        if (!empty($products[0])) {
            $result = $products[0];
        }
        return $result;
    }

    public function deleteById($products_id){
        $result = false;
        $error_message = '';


        if (empty($products_id)) {
            $error_message .= "Отсутствует идентификатор записи! <br>";
        }

        if (empty($error_message)) {
            $result = $this->update("DELETE FROM products WHERE id = :id",
                [
                    'id' => $products_id,
                ]
            );
        }

        return [
            'result' => $result,
            'error_message' => $error_message
        ];
    }

}
