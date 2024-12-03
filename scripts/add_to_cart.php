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

$am = $pdo->prepare("SELECT amount FROM cart_items where cart_id = :cart and item_id = :item");
$am->execute($data);

$amount = $am->fetchColumn();
}else{
    if(isset($_COOKIE['cart'])){
        $cart = json_decode($_COOKIE['cart'], true); 
    }else{
        $cart=[];
    }
    $amount = $cart[$_POST['item']];
}

if($amount!="" && $amount>0){
    if(isset($_SESSION['login'])){
        $data = [
            'cart' => $cart,
            'item' => $_POST['item'],
            'amount' => $amount+1
        ];

        try {
            $q = $pdo->prepare("UPDATE cart_items SET amount = :amount WHERE cart_id = :cart and item_id = :item");
            $q->execute($data);
        }catch (PDOException $e) {
            echo 'Wystąpił błąd';
            //exit();
        }  
    }else{
        $cart[$_POST['item']]+=1;
        setcookie('cart', json_encode($cart), time() + (86400 * 30), "/");
    }
}else{
    if(isset($_SESSION['login'])){
        $data = [
            'cart' => $cart,
            'item' => $_POST['item'],
        ];

        try {
            $q = $pdo->prepare("INSERT INTO cart_items (cart_id,item_id,amount) VALUES (:cart,:item,1)");
            $q->execute($data);
        }catch (PDOException $e) {
            echo 'Wystąpił błąd';
            //exit();
        }
    }else{
        $cart[$_POST['item']]=1;
        setcookie('cart', json_encode($cart), time() + (86400 * 30), "/");
    }
}

?>