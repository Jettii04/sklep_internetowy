<?php
session_start();
// Plik odpowiedzialny za sprawdzanie formularza 
require_once("database.php");
    $data = [
        'login' => $_POST['login']
    ];

    try {
    $q = $pdo->prepare("SELECT cart_id FROM carts WHERE user = :login");
    $q->execute($data);
    $cart=$q->fetchColumn();
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

    try {
    $q = $pdo->prepare("DELETE FROM carts WHERE user = :login");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

    try {
    $q = $pdo->prepare("DELETE FROM users WHERE login = :login");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

    try {
    $q = $pdo->prepare("UPDATE orders SET user=NULL WHERE user = :login");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

    $data = [
        'cart' => $cart
    ];

    try {
    $q = $pdo->prepare("DELETE FROM cart_items WHERE cart_id = :cart");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }


?>