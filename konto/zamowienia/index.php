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
<form action="../katalog/" method="get">
<!-- navbar -->
<?php include("../../scripts/header.php")?>
</form>

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
                if(isset($_SESSION['login'])){

                    $data = [
                        'user' => $_SESSION['login'],
                    ];

                    $noi = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE user=:user");
                    $noi->execute($data);
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
                        $orders = $pdo->prepare("SELECT * FROM orders WHERE user=:user ORDER BY order_id DESC LIMIT ".$nOnpage." OFFSET ".$offset);
                        $orders->execute($data);
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
                            $deliv = $pdo->prepare("SELECT name, price FROM delivery_method WHERE delivery_id=:method");
                            $deliv->execute($data);
                            $d=$deliv->fetch(PDO::FETCH_ASSOC);
                            $delivery = $d['name'];
                            $deliveryPrice = $d['price'];
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
                            $p=$pay->fetch(PDO::FETCH_ASSOC);
                            $payment = $p['name'];
                            $paymentPrice = $p['price'];
                        }catch (PDOException $e) {
                            echo 'Nie udało się odczytać danych z bazy';
                            //exit();
                        }

                        echo '<div class="container-md order-item mb-5">
                            <div class="row m-2">
                                <div class="col-4">
                                <h5>Zamówienie nr.</h5>
                                '.$order['order_id'].'
                                </div>
                                <div class="col-4">
                                <h5>Data złożenia.</h5>
                                '.$order['time'].'
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
                        $wholeprice+=$deliveryPrice+$paymentPrice;
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
                                        <a href="../../produkt/?item='.$item['item_id'].'"><h4>'.$item['name'].'</h4></a>
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
        </script>
</body>
</html>