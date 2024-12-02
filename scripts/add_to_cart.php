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

$am = $pdo->prepare("SELECT amount FROM cart_items where cart_id = :cart and item_id = :item");
$am->execute($data);

$amount = $am->fetchColumn();


if($amount!="" && $amount>0){
    
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
}
echo $amount;
?>