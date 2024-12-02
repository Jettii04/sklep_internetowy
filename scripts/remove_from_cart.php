<?php
session_start();
// Plik odpowiedzialny za sprawdzanie formularza 

require_once("database.php");

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
?>