<?php
session_start();
require_once('database.php');

if(isset($_SESSION['login'])){
    $data = [
        'user' => $_SESSION['login']
    ];
    // id koszyka
    try {
    $c = $pdo->prepare("SELECT cart_id FROM carts WHERE user = :user");
    $c->execute($data);
    $cart = $c->fetchColumn();
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }
    
    //id zamówienina
    try {
    $o = $pdo->query("SELECT MAX(order_id) FROM orders");
    $order = $o->fetchColumn();
    $order += 1;
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

    $data = [
        'user' => $_SESSION['login'],
        'order_status' => 1,
        'postal' => $_SESSION['Fpostal_code'],
        'city' => $_SESSION['Fcity'],
        'road' => $_SESSION['Froad'],
        'house' => $_SESSION['Fhouse_number'],
        'pay' => $_COOKIE['payment_method'],
        'deliv' => $_COOKIE['delivery_method'],
        'order_id'=> $order
    ];
    // tworzenie zamówienia
    try {
        $c = $pdo->prepare("INSERT INTO orders (order_id,user,order_status,postal_code,city,road,house_number,payment_method,delivery_method) VALUES (:order_id,:user,:order_status,:postal,:city,:road,:house,:pay,:deliv)");
        $c->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }
    
    
    $data = [
        'cart' => $cart,
    ];
    
    try {
        $items = $pdo->prepare("SELECT * FROM cart_items WHERE cart_id = :cart");
        $items->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd1';
        //exit();
    }
    
    foreach($items as $item){
        $data = [
            'item' => $item['item_id'],
            'amount' => $item['amount'],
            'order' => $order
        ];
        try {
            $items = $pdo->prepare("INSERT INTO order_items (order_id,item_id,amount) VALUES (:order,:item,:amount)");
            $items->execute($data);
        }catch (PDOException $e) {
            echo 'Wystąpił błąd2';
            //exit();
        }
    }

    $data = [
        'cart' => $cart,
    ];

    try {
    $q = $pdo->prepare("DELETE FROM cart_items WHERE cart_id = :cart");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd3';
        //exit();
    }
}else{

    //id zamówienina
    try {
        $o = $pdo->query("SELECT MAX(order_id) FROM orders");
        $order = $o->fetchColumn();
        $order += 1;
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

    $data = [
        'order_status' => 1,
        'postal' => $_SESSION['Fpostal_code'],
        'city' => $_SESSION['Fcity'],
        'road' => $_SESSION['Froad'],
        'house' => $_SESSION['Fhouse_number'],
        'pay' => $_COOKIE['payment_method'],
        'deliv' => $_COOKIE['delivery_method'],
        'order_id'=> $order
    ];
    // tworzenie zamówienia
    try {
        $c = $pdo->prepare("INSERT INTO orders (order_id,order_status,postal_code,city,road,house_number,payment_method,delivery_method) VALUES (:order_id,:order_status,:postal,:city,:road,:house,:pay,:deliv)");
        $c->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

    if(isset($_COOKIE['cart'])){
        $cart = json_decode($_COOKIE['cart'], true); 
    }else{
        $cart=[];
    }
    foreach($cart as $key=>$value){
        $data = [
            'item' => $key,
            'amount' => $value,
            'order' => $order
        ];
        try {
            $items = $pdo->prepare("INSERT INTO order_items (order_id,item_id,amount) VALUES (:order,:item,:amount)");
            $items->execute($data);
        }catch (PDOException $e) {
            echo 'Wystąpił błąd2';
            //exit();
        }
        unset($cart[$key]);
    }
    setcookie('cart', json_encode($cart), time() + (86400 * 30), "/");
}

header("Location: ../../");
exit;

?>