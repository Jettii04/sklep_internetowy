<?php
session_start();
// Plik odpowiedzialny za sprawdzanie formularza 

require_once("database.php");
if(isset($_SESSION['login'])){
    $data = [
        'user' => $_SESSION['login']
    ];

    try {
    $c = $pdo->prepare("SELECT cart_id FROM carts WHERE user = :user");
    $c->execute($data);
    $cart = $c->fetchColumn();
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

    $data = [
        'cart' => $cart,
        'item' => $_POST['item']
    ];

    try {
    $q = $pdo->prepare("DELETE FROM cart_items WHERE item_id = :item and cart_id = :cart");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }
}else{
    if(isset($_COOKIE['cart'])){
        $cart = json_decode($_COOKIE['cart'], true); 
    }else{
        $cart=[];
    }
    unset($cart[$_POST['item']]);
    setcookie('cart', json_encode($cart), time() + (86400 * 30), "/");
}
?>