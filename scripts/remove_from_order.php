<?php 
session_start();

require_once("database.php");
try {
    $data = [
        'order' => $_POST['order_id'],
        'item' => $_POST['item_id']
    ];
    $q = $pdo->prepare("DELETE FROM order_items WHERE item_id = :item and order_id = :order");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }
?>