<?php
session_start();
require 'app/config/db.php';
$id_item = $_POST['id_item'];
$id_user = $_SESSION['user_id'];

$count = (int)select(
    'SELECT count FROM products WHERE id = :id_item',
    [
        'id_item' =>$id_item
    ]
)[0]['count'];

update(
    'UPDATE count SET products WHERE id = :id_item',
    [
        'count' =>$count-1,
        'id_item' =>$id_item
    ]
);

insert(
    'INSERT INTO cart(id_item, id_user) VALUES (:id_item, :id_user)',
    [
    'id_item' =>$id_item,
    'id_user' =>$id_user
    ]
);
header('Location: ../user/profile.php?id='.$id_user);
