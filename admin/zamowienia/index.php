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
    <title>Zamówienia</title>
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
<?php include("../admin_navbar.php")?>

<div class="container-fluid p-0 d-flex h-100">

    <!-- Sidebar -->
    <?php include("../admin_sidebar.php")?>

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
            <form method="get" action="">
            <div style="color: black">
            <h2>Zamówienia</h2> 
            <div class="d-flex me-auto ms-auto">
            <input class="form-control me-2" type="search" name="search" placeholder="Szukaj wedłóg numeru zamówienia lub loginu urzytkownika..." aria-label="Search">
            <button class="btn btn-primary" type="submit">Szukaj</button>   
            </div>
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