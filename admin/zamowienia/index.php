<?php
session_start();
if(!isset($_SESSION['login'])){
    header("location: ../");
}
require_once("../../scripts/database.php");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Dane użytkownika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="your-project-dir/icon-font/lineicons.css" rel="stylesheet" >
    <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet" >

    <style>
        body {
            color: #ffffff; /* Biały kolor tekstu */
        }
        .card {
            background-color: #16213e; /* Głębszy odcień dla kart produktów */
            border: none;
            color: #ffffff; /* Biały kolor tekstu */
            height: 100%;
        }
        .card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4); /* Efekt podświetlenia przy najechaniu */
        }
        .form-control, .form-select, .btn-primary {
            background-color: #1f4068; /* Ciemny niebieski odcień */
            border: none;
            color: #ffffff; /* Biały kolor tekstu */
        }
        .form-control::placeholder {
            color: #cccccc; /* Jasnoszary placeholder dla lepszej widoczności */
        }
        .form-control:focus, .form-select:focus, .btn-primary:focus {
            box-shadow: 0 0 8px rgba(31, 64, 104, 0.8);
        }
        .btn-primary {
            border-radius: 30px;
        }
        .btn-outline-light {
            border-color: #ffffff;
            color: #ffffff;
        }
        .btn-outline-light:hover {
            background-color: #ffffff;
            color: #1a1a2e;
        }
        .card-img {
            width: 100%;
            height: 250px;
            object-fit:contain;
            object-position: 50% 50%;
            display: block;
            margin-left: auto;
            margin-right:auto;
        }
        .order-item {
            background-color: white;
            border-style: solid;
            border-width: 1px;
            border-color: #8a8a8a;
            color: black;
        }
        .cart-item {
            background-color: white;
            border-style: solid;
            border-width: 1px;
            border-color: #8a8a8a;
            color: black;
        }
        .cart-item-img{
            width: 100px;
            height: 100px;
            object-fit:contain;
            object-position: 50% 50%;
            display: block;
            border-style: solid;
            border-width: 1px;
            border-color: black;
        }
        .cart-item-amount{
            background-color: white;
            border: solid;
            border-width: 1px;
            color: black;
        }
    </style>
</head>
<body>
<!-- navbar -->
<nav class="navbar navbar-expand-md navbar-dark bg-black sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="../../">
        <img src="../../assets/images/biden.jpg" style="width: 30px; height: 30px; object-fit: cover;" width="30" height="30" alt="">    
        Greg.inc</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php 
                if(isset($_SESSION['login'])){
                    echo'
                        <li class="nav-item dropdown me-2">
                        <a class="nav-link" href="../ulubione">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8227 4.77124L12 4.94862L12.1773 4.77135C14.4244 2.52427 18.0676 2.52427 20.3147 4.77134C22.5618 7.01842 22.5618 10.6616 20.3147 12.9087L13.591 19.6324C12.7123 20.5111 11.2877 20.5111 10.409 19.6324L3.6853 12.9086C1.43823 10.6615 1.43823 7.01831 3.6853 4.77124C5.93237 2.52417 9.5756 2.52417 11.8227 4.77124ZM10.762 5.8319C9.10073 4.17062 6.40725 4.17062 4.74596 5.8319C3.08468 7.49319 3.08468 10.1867 4.74596 11.848L11.4697 18.5718C11.7625 18.8647 12.2374 18.8647 12.5303 18.5718L19.254 11.8481C20.9153 10.1868 20.9153 7.49329 19.254 5.83201C17.5927 4.17072 14.8993 4.17072 13.238 5.83201L12.5304 6.53961C12.3897 6.68026 12.199 6.75928 12 6.75928C11.8011 6.75928 11.6104 6.68026 11.4697 6.53961L10.762 5.8319Z" fill="#ffffff"/>
                            </svg>
                        </a>
                        </li>
                        <li class="nav-item dropdown me-2">
                        <a class="nav-link" href="../../koszyk/">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.31641 3.25C1.90219 3.25 1.56641 3.58579 1.56641 4C1.56641 4.41421 1.90219 4.75 2.31641 4.75H3.49696C3.87082 4.75 4.18759 5.02534 4.23965 5.39556L5.49371 14.3133C5.6499 15.424 6.60021 16.25 7.72179 16.25L18.0664 16.25C18.4806 16.25 18.8164 15.9142 18.8164 15.5C18.8164 15.0858 18.4806 14.75 18.0664 14.75L7.72179 14.75C7.34793 14.75 7.03116 14.4747 6.9791 14.1044L6.85901 13.2505H17.7114C18.6969 13.2505 19.5678 12.6091 19.8601 11.668L21.7824 5.48032C21.8531 5.25268 21.8114 5.00499 21.6701 4.81305C21.5287 4.62112 21.3045 4.50781 21.0662 4.50781H5.51677C5.14728 3.75572 4.37455 3.25 3.49696 3.25H2.31641ZM5.84051 6.00781L6.64807 11.7505H17.7114C18.0399 11.7505 18.3302 11.5367 18.4277 11.223L20.0478 6.00781H5.84051Z" fill="#ffffff"/>
                            <path d="M7.78418 17.75C6.81768 17.75 6.03418 18.5335 6.03418 19.5C6.03418 20.4665 6.81768 21.25 7.78418 21.25C8.75068 21.25 9.53428 20.4665 9.53428 19.5C9.53428 18.5335 8.75068 17.75 7.78418 17.75Z" fill="#ffffff"/>
                            <path d="M14.5703 19.5C14.5703 18.5335 15.3538 17.75 16.3203 17.75C17.2868 17.75 18.0704 18.5335 18.0704 19.5C18.0704 20.4665 17.2869 21.25 16.3204 21.25C15.3539 21.25 14.5703 20.4665 14.5703 19.5Z" fill="#ffffff"/>
                            </svg>
                        </a>
                        </li>
                        <li class="nav-item d-block d-md-none">
                            <a class="nav-link" href="../">Konto</a>
                        </li>
                        <li class="nav-item d-block d-md-none">
                            <a class="nav-link" href="">Zamówienia</a>
                        </li>
                        <li class="nav-item d-block d-md-none">
                            <a class="nav-link" href="javascript:logout('.')">
                                <button class="btn btn btn-outline-secondary"  type="button">Wyloguj</button>
                            </a>
                        </li>
                        <li class="nav-item dropdown d-none d-md-block">
                            <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg width="24" height="24" viewBox="0 0 25 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.4337 6.35C16.4337 8.74 14.4937 10.69 12.0937 10.69L12.0837 10.68C9.69365 10.68 7.74365 8.73 7.74365 6.34C7.74365 3.95 9.70365 2 12.0937 2C14.4837 2 16.4337 3.96 16.4337 6.35ZM14.9337 6.34C14.9337 4.78 13.6637 3.5 12.0937 3.5C10.5337 3.5 9.25365 4.78 9.25365 6.34C9.25365 7.9 10.5337 9.18 12.0937 9.18C13.6537 9.18 14.9337 7.9 14.9337 6.34Z" fill="#ffffff"/>
                                <path d="M12.0235 12.1895C14.6935 12.1895 16.7835 12.9395 18.2335 14.4195V14.4095C20.2801 16.4956 20.2739 19.2563 20.2735 19.4344L20.2735 19.4395C20.2635 19.8495 19.9335 20.1795 19.5235 20.1795H19.5135C19.0935 20.1695 18.7735 19.8295 18.7735 19.4195C18.7735 19.3695 18.7735 17.0895 17.1535 15.4495C15.9935 14.2795 14.2635 13.6795 12.0235 13.6795C9.78346 13.6795 8.05346 14.2795 6.89346 15.4495C5.27346 17.0995 5.27346 19.3995 5.27346 19.4195C5.27346 19.8295 4.94346 20.1795 4.53346 20.1795C4.17346 20.1995 3.77346 19.8595 3.77346 19.4495L3.77345 19.4448C3.77305 19.2771 3.76646 16.506 5.81346 14.4195C7.26346 12.9395 9.35346 12.1895 12.0235 12.1895Z" fill="#ffffff"/>
                                </svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="../">Konto</a></li>
                                <li><a class="dropdown-item" href="">Zamówienia</a></li>
                                <li><a class="" href="javascript:logout('.')">
                                <button class="btn btn btn-outline-secondary ms-2"  type="button">Wyloguj</button>
                                </a></li>
                            </ul>
                        </li>
                        ';
                }else{
                    echo  '
                        <li class="nav-item dropdown me-2">
                        <a class="nav-link" href="../../koszyk/">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.31641 3.25C1.90219 3.25 1.56641 3.58579 1.56641 4C1.56641 4.41421 1.90219 4.75 2.31641 4.75H3.49696C3.87082 4.75 4.18759 5.02534 4.23965 5.39556L5.49371 14.3133C5.6499 15.424 6.60021 16.25 7.72179 16.25L18.0664 16.25C18.4806 16.25 18.8164 15.9142 18.8164 15.5C18.8164 15.0858 18.4806 14.75 18.0664 14.75L7.72179 14.75C7.34793 14.75 7.03116 14.4747 6.9791 14.1044L6.85901 13.2505H17.7114C18.6969 13.2505 19.5678 12.6091 19.8601 11.668L21.7824 5.48032C21.8531 5.25268 21.8114 5.00499 21.6701 4.81305C21.5287 4.62112 21.3045 4.50781 21.0662 4.50781H5.51677C5.14728 3.75572 4.37455 3.25 3.49696 3.25H2.31641ZM5.84051 6.00781L6.64807 11.7505H17.7114C18.0399 11.7505 18.3302 11.5367 18.4277 11.223L20.0478 6.00781H5.84051Z" fill="#ffffff"/>
                            <path d="M7.78418 17.75C6.81768 17.75 6.03418 18.5335 6.03418 19.5C6.03418 20.4665 6.81768 21.25 7.78418 21.25C8.75068 21.25 9.53428 20.4665 9.53428 19.5C9.53428 18.5335 8.75068 17.75 7.78418 17.75Z" fill="#ffffff"/>
                            <path d="M14.5703 19.5C14.5703 18.5335 15.3538 17.75 16.3203 17.75C17.2868 17.75 18.0704 18.5335 18.0704 19.5C18.0704 20.4665 17.2869 21.25 16.3204 21.25C15.3539 21.25 14.5703 20.4665 14.5703 19.5Z" fill="#ffffff"/>
                            </svg>
                        </a>
                        </li>
                        <button class="btn btn-outline-success me-2 d-none d-md-block" type="button" onclick="login();">Zaloguj się</button>
                        <button class="btn btn btn-outline-secondary d-none d-md-block" type="button" onclick="register();">Zarejestruj</button>
                        <li class="nav-item d-block d-md-none">
                            <a class="nav-link" href="javascript:logout('.')">
                                <button class="btn btn-outline-success" type="button" onclick="login();">Zaloguj się</button>
                            </a>
                        </li>
                        <li class="nav-item d-block d-md-none">
                            <a class="nav-link" href="javascript:logout('.')">
                                <button class="btn btn btn-outline-secondary" type="button" onclick="register();">Zarejestruj</button>
                            </a>
                        </li>
                        ';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid p-0 d-flex h-100">

    <div id="bdSidebar" class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white offcanvas-md offcanvas-start">
        <ul class="mynav nav nav-pills flex-column mb-auto">
            <li class="nav-item mb-1">
                <a href="../dane/" class="nav-link">
                    Dane
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="../ulubione/" class="nav-link">
                    Ulubione
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="javascript:logout()" class="nav-link" style="color: red;">
                    Wyloguj
                </a>
            </li>
        </ul>
        <hr>
        <div class="d-flex">
            <span>
                <h6 class="mt-1 mb-0">
                        
                </h6>
            </span>
        </div>
    </div>

    <div class="bg-light flex-fill">
        <!-- Sidebar po zmniejszeniu -->
      <div class="p-2 d-md-none d-flex text-white bg-dark">
          <a href="#" class="text-white" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar">
              <i class="fa-solid fa-bars"></i>
          </a>
          <span class="nav-item me-2">
                <a href="../dane/" class="nav-link">
                    Dane
                </a>
          </span>
            <span class="nav-item me-2">
                <a href="../ulubione/" class="nav-link">
                    Ulubione
                </a>
            </span>
            <span class="nav-item me-2">
                <a href="javascript:logout()" class="nav-link" style="color: red;">
                    Wyloguj
                </a>
            </span>
      </div>
        <!-- Ciało storny -->
        <div class="p-4">
            <div style="color: black">
            <h2>Zamówienia</h2>    
            <hr>
            </div>
            <?php

                $noi = $pdo->prepare("SELECT COUNT(*) FROM orders");
                $noi->execute();
                $nOfitems = $noi->fetchColumn();

                $nOnpage=4;

                if($nOfitems%$nOnpage!=0){
                    $nOfpages=floor($nOfitems/$nOnpage)+1;
                }else{
                    $nOfpages=floor($nOfitems/$nOnpage);
                }

                $page=1;
                $offset=0;
                if(isset($_GET['page'])){
                    $page=htmlspecialchars($_GET['page']);
                    $offset=($page-1)*$nOnpage;
                }

                $data = [
                    'user' => $_SESSION['login'],
                ];
                try {
                    $orders = $pdo->prepare("SELECT * FROM orders ORDER BY order_id DESC LIMIT ".$nOnpage." OFFSET ".$offset);
                    $orders->execute();
                }catch (PDOException $e) {
                    echo 'Nie udało się odczytać danych z bazy';
                    //exit();
                }

                foreach($orders as $order){

                    $data = [
                        'status_id' => $order['order_status'],
                    ];
                    try {
                        $stat = $pdo->prepare("SELECT name FROM order_satus WHERE status_id=:status_id");
                        $stat->execute($data);
                        $status = $stat ->fetchColumn();
                    }catch (PDOException $e) {
                        echo 'Nie udało się odczytać danych z bazy';
                        //exit();
                    }

                    $data = [
                        'method' => $order['delivery_method'],
                    ];
                    try {
                        $deliv = $pdo->prepare("SELECT name FROM delivery_method WHERE delivery_id=:method");
                        $deliv->execute($data);
                        $delivery = $deliv ->fetchColumn();
                    }catch (PDOException $e) {
                        echo 'Nie udało się odczytać danych z bazy';
                        //exit();
                    }

                    $data = [
                        'method' => $order['payment_method'],
                    ];
                    try {
                        $pay = $pdo->prepare("SELECT name FROM payment_methods WHERE payment_id=:method");
                        $pay->execute($data);
                        $payment = $pay ->fetchColumn();
                    }catch (PDOException $e) {
                        echo 'Nie udało się odczytać danych z bazy';
                        //exit();
                    }

                    echo '<div class="container-md order-item mb-5">
                        <div class="row m-2">
                            <div class="col-12" style="text-align: right">
                                <a href="javascript:remove_order('."'".$order['order_id']."'".')">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="#373737" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                    <path d="M14.7223 12.7585C14.7426 12.3448 14.4237 11.9929 14.01 11.9726C13.5963 11.9522 13.2444 12.2711 13.2241 12.6848L12.9999 17.2415C12.9796 17.6552 13.2985 18.0071 13.7122 18.0274C14.1259 18.0478 14.4778 17.7289 14.4981 17.3152L14.7223 12.7585Z" fill="#373737"/>
                                    <path d="M9.98802 11.9726C9.5743 11.9929 9.25542 12.3448 9.27577 12.7585L9.49993 17.3152C9.52028 17.7289 9.87216 18.0478 10.2859 18.0274C10.6996 18.0071 11.0185 17.6552 10.9981 17.2415L10.774 12.6848C10.7536 12.2711 10.4017 11.9522 9.98802 11.9726Z" fill="#373737"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.249 2C9.00638 2 7.99902 3.00736 7.99902 4.25V5H5.5C4.25736 5 3.25 6.00736 3.25 7.25C3.25 8.28958 3.95503 9.16449 4.91303 9.42267L5.54076 19.8848C5.61205 21.0729 6.59642 22 7.78672 22H16.2113C17.4016 22 18.386 21.0729 18.4573 19.8848L19.085 9.42267C20.043 9.16449 20.748 8.28958 20.748 7.25C20.748 6.00736 19.7407 5 18.498 5H15.999V4.25C15.999 3.00736 14.9917 2 13.749 2H10.249ZM14.499 5V4.25C14.499 3.83579 14.1632 3.5 13.749 3.5H10.249C9.83481 3.5 9.49902 3.83579 9.49902 4.25V5H14.499ZM5.5 6.5C5.08579 6.5 4.75 6.83579 4.75 7.25C4.75 7.66421 5.08579 8 5.5 8H18.498C18.9123 8 19.248 7.66421 19.248 7.25C19.248 6.83579 18.9123 6.5 18.498 6.5H5.5ZM6.42037 9.5H17.5777L16.96 19.7949C16.9362 20.191 16.6081 20.5 16.2113 20.5H7.78672C7.38995 20.5 7.06183 20.191 7.03807 19.7949L6.42037 9.5Z" fill="#373737"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="row m-2" id="z'.$order['order_id'].'">
                            <div class="col-4">
                            <h5>Zamówienie nr.</h5>
                            '.$order['order_id'].'
                            </div>
                            <div class="col-4">
                            <h5>Urzytkownik</h5>
                            '.$order['user'].'
                            </div>
                            <div class="col-4">
                            <h5>Płatność</h5>
                            '.$payment.'
                            </div>
                            <div class="col-4">
                            <h5>Status</h5>
                            '.$status.'
                            </div>
                            <div class="col-4">
                            <h5>Dostawa</h5>
                            '.$delivery.'
                            </div>
                            <div class="col-4">
                            <h5>Adres</h5>
                            <p>ul.'.$order['road'].' '.$order['house_number'].'</p>
                            <p>'.$order['postal_code'].' '.$order['city'].'</p>
                            </div>
                        </div>
                    ';
                    $data = [
                        'order' => $order['order_id'],
                    ];
                    try {
                        $items = $pdo->prepare("SELECT name, items.item_id, items.price, items.main_img, order_items.amount FROM items JOIN order_items on items.item_id = order_items.item_id WHERE order_id=:order");
                        $items->execute($data);
                    }catch (PDOException $e) {
                        echo 'Nie udało się odczytać danych z bazy';
                        //exit();
                    }
                    $wholeprice=0;
                    foreach($items as $item){ 

                        $priceW = $item['price']*$item['amount'];
                        
                        $wholeprice+=$priceW;
    
                        echo '
                        <div class="container-md cart-item mb-2" id="'.$item['item_id'].'">
                        <div class="row mt-2 mb-2 d-flex align-items-center">
                                <div class="col-3 col-lg-2">
                                <img class="cart-item-img" src="data:image;base64,'.base64_encode($item['main_img']).'" alt="Zdjęcie produktu">
                                </div>
                                <div class="col-9 col-lg-4">
                                    <a href="../produkt/?item='.$item['item_id'].'"><h4>'.$item['name'].'</h4></a>
                                </div>
                                <div class="col-3 col-lg-2 ms-2 ms-lg-0 mt-2 mt-lg-0">
                                    <h5>'.$item['price'].' zł</h5>
                                </div>
                                <div class="col-2 col-lg-1 mt-2 mt-lg-0">
                                        <h5>szt. '.$item['amount'].'</h5>
                                </div>
                                <div class="col col-lg-2 mt-2 mt-lg-0">
                                    <h5>'.$priceW.' zł</h5>
                                </div>
                        </div>
                        </div>';
                    }
                    echo '
                    <div class="container-md" style="text-align: right; color: black">
                    <hr style=" border: 3px solid black;">
                    <h4 >Łącznie '.$wholeprice.' zł</h4>
                    </div>
                    </div>';
                }
                ?>
            <form method="get" action="">
            <div class="mt-3" style="text-align: center;">
                <?php 
                for($j=1;$j<=$nOfpages;$j++){
                    if($page==$j){
                        echo '
                        <input type="submit" class="btn btn-dark" name="page" value="'.$j.'">
                        ';
                    }else{
                        echo '
                        <input type="submit" class="btn btn-outline-dark" name="page" value="'.$j.'">
                        ';
                    }
                }
                ?>
            </div>
            </form>
        </div>
    </div>
</div>
    

<!-- Stopka -->
<?php include("../../scripts/footer.php")?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
        });
        
        // funkcja ajax uruchamiająca plik logout.php
        function logout(){
            $.ajax({
                url: "../../scripts/logout.php",
            }).done(function( data ) {
                location.reload();
            });
        }

        function login(){
            window.location.assign("../../login/");
        }

        function register(){
            window.location.assign("../../rejestr/");
        }
        function remove_order(item){
            var id=item;
            $.ajax({
                url: "../../scripts/remove_order.php",
                method: 'POST',
                data: {
                    order_id: id
                }
            }).done(function( data ) {
                  location.reload();
            });
        }
        </script>
</body>
</html>