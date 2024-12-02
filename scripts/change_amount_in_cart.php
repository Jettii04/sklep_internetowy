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
    'item' => $_POST['item'],
    'amount' => $_POST['amount']
];

try {
    $q = $pdo->prepare("UPDATE cart_items SET amount = :amount WHERE cart_id = :cart and item_id = :item");
    $q->execute($data);
}catch (PDOException $e) {
    echo 'Wystąpił błąd';
    //exit();
}  
echo $_POST['amount'];
?>