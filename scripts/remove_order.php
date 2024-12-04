<?php
session_start();
// Plik odpowiedzialny za sprawdzanie formularza 
require_once("database.php");
    $data = [
        'order' => $_POST['order_id']
    ];

    try {
    $q = $pdo->prepare("DELETE FROM order_items WHERE order_id = :order");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }
    try {
    $q = $pdo->prepare("DELETE FROM orders WHERE order_id = :order");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }
?>