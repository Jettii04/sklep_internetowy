<?php
session_start();
require_once("../scripts/database.php");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Koszyk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="your-project-dir/icon-font/lineicons.css" rel="stylesheet" >
    <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet" >

    <style>
        body {
            color: #ffffff; /* Biały kolor tekstu */
        }
        .card {
            background-color: #16213e;
            border: none;
            color: #ffffff;
            height: 100%;
        }
        .card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }
        .form-control, .form-select, .btn-primary {
            background-color: #1f4068;
            border: none;
            color: #ffffff;
        }
        .form-control::placeholder {
            color: #cccccc;
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
        .card-body {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
<form action="../katalog/" method="get">
<!-- navbar -->
<?php include("../scripts/header.php")?>
</form>

<div class="container-fluid p-0 d-flex h-100">

    <div class="bg-light flex-fill">
        <!-- Ciało storny -->
        <div class="pt-4 pb-4">
            <div style="color: black" class="ps-4 pe-4">
            <h2>Koszyk</h2>    
            <hr>
            </div>
                <?php 
                if(isset($_SESSION['login'])){
                    $data = [
                        'user' => $_SESSION['login'],
                    ];
                    try {
                        $q = $pdo->prepare("SELECT name, items.item_id, items.price, items.main_img, cart_items.amount FROM items JOIN cart_items on items.item_id = cart_items.item_id left JOIN carts on carts.cart_id = cart_items.cart_id WHERE user=:user");
                        $q->execute($data);
                    }catch (PDOException $e) {
                        echo 'Nie udało się odczytać danych z bazy';
                        //exit();
                    }

                    $wholeprice=0;

                    foreach($q as $item){
                        if($item['amount']<1){
                            $item['amount']=1;
                        }


                    $priceW = $item['price']*$item['amount'];
                    
                    $wholeprice+=$priceW;

                    echo '
                    <form method="post" action="">
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
                                <form>
                                    <input type="number" class="form-control cart-item-amount" id="amount'.$item['item_id'].'" name="amount" min="1" step="1" value="'.$item['amount'].'" onchange="myFunction('."'".$item['item_id']."'".')">
                                </form>
                            </div>
                            <div class="col col-lg-2 mt-2 mt-lg-0">
                                <h5>'.$priceW.' zł</h5>
                            </div>
                            <div class="col-1 mt-2 mt-lg-0">
                                <a href="javascript:remove_from_cart('."'".$item['item_id']."'".')">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="#373737" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                    <path d="M14.7223 12.7585C14.7426 12.3448 14.4237 11.9929 14.01 11.9726C13.5963 11.9522 13.2444 12.2711 13.2241 12.6848L12.9999 17.2415C12.9796 17.6552 13.2985 18.0071 13.7122 18.0274C14.1259 18.0478 14.4778 17.7289 14.4981 17.3152L14.7223 12.7585Z" fill="#373737"/>
                                    <path d="M9.98802 11.9726C9.5743 11.9929 9.25542 12.3448 9.27577 12.7585L9.49993 17.3152C9.52028 17.7289 9.87216 18.0478 10.2859 18.0274C10.6996 18.0071 11.0185 17.6552 10.9981 17.2415L10.774 12.6848C10.7536 12.2711 10.4017 11.9522 9.98802 11.9726Z" fill="#373737"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.249 2C9.00638 2 7.99902 3.00736 7.99902 4.25V5H5.5C4.25736 5 3.25 6.00736 3.25 7.25C3.25 8.28958 3.95503 9.16449 4.91303 9.42267L5.54076 19.8848C5.61205 21.0729 6.59642 22 7.78672 22H16.2113C17.4016 22 18.386 21.0729 18.4573 19.8848L19.085 9.42267C20.043 9.16449 20.748 8.28958 20.748 7.25C20.748 6.00736 19.7407 5 18.498 5H15.999V4.25C15.999 3.00736 14.9917 2 13.749 2H10.249ZM14.499 5V4.25C14.499 3.83579 14.1632 3.5 13.749 3.5H10.249C9.83481 3.5 9.49902 3.83579 9.49902 4.25V5H14.499ZM5.5 6.5C5.08579 6.5 4.75 6.83579 4.75 7.25C4.75 7.66421 5.08579 8 5.5 8H18.498C18.9123 8 19.248 7.66421 19.248 7.25C19.248 6.83579 18.9123 6.5 18.498 6.5H5.5ZM6.42037 9.5H17.5777L16.96 19.7949C16.9362 20.191 16.6081 20.5 16.2113 20.5H7.78672C7.38995 20.5 7.06183 20.191 7.03807 19.7949L6.42037 9.5Z" fill="#373737"/>
                                    </svg>
                                </a>
                            </div>
                    </div>
                    </div>';
                    }
                }else{
                    $wholeprice=0;
                    if(isset($_COOKIE['cart'])){
                        $cart = json_decode($_COOKIE['cart'], true);
                    }else{
                        $cart = [];
                    }
                    foreach($cart as $key=>$amount){ 
                        if($amount<1){
                            $amount=1;
                        }

                        $data = [
                            'item_id' => $key,
                        ];
                        try {
                        $it = $pdo->prepare("SELECT * FROM items WHERE item_id = :item_id");
                        $it->execute($data);
                        $item = $it->fetch(PDO::FETCH_ASSOC);
                        }catch (PDOException $e) {
                            echo 'Nie udało się odczytać danych z bazy';
                            //exit();
                        }

                    $priceW = $item['price']*$amount;
                    
                    $wholeprice+=$priceW;

                    echo '
                    <form method="post" action="">
                    <div class="container-md cart-item mb-2" id="'.$key.'">
                    <div class="row mt-2 mb-2 d-flex align-items-center">
                            <div class="col-3 col-lg-2">
                            <img class="cart-item-img" src="data:image;base64,'.base64_encode($item['main_img']).'" alt="Zdjęcie produktu">
                            </div>
                            <div class="col-9 col-lg-4">
                                <a href="../produkt/?item='.$key.'"><h4>'.$item['name'].'</h4></a>
                            </div>
                            <div class="col-3 col-lg-2 ms-2 ms-lg-0 mt-2 mt-lg-0">
                                <h5>'.$item['price'].' zł</h5>
                            </div>
                            <div class="col-2 col-lg-1 mt-2 mt-lg-0">
                                <form>
                                    <input type="number" class="form-control cart-item-amount" id="amount'.$key.'" name="amount" min="1" step="1" value="'.$amount.'" onchange="myFunction('."'".$key."'".')">
                                </form>
                            </div>
                            <div class="col col-lg-2 mt-2 mt-lg-0">
                                <h5>'.$priceW.' zł</h5>
                            </div>
                            <div class="col-1 mt-2 mt-lg-0">
                                <a href="javascript:remove_from_cart('."'".$key."'".')">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="#373737" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                    <path d="M14.7223 12.7585C14.7426 12.3448 14.4237 11.9929 14.01 11.9726C13.5963 11.9522 13.2444 12.2711 13.2241 12.6848L12.9999 17.2415C12.9796 17.6552 13.2985 18.0071 13.7122 18.0274C14.1259 18.0478 14.4778 17.7289 14.4981 17.3152L14.7223 12.7585Z" fill="#373737"/>
                                    <path d="M9.98802 11.9726C9.5743 11.9929 9.25542 12.3448 9.27577 12.7585L9.49993 17.3152C9.52028 17.7289 9.87216 18.0478 10.2859 18.0274C10.6996 18.0071 11.0185 17.6552 10.9981 17.2415L10.774 12.6848C10.7536 12.2711 10.4017 11.9522 9.98802 11.9726Z" fill="#373737"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.249 2C9.00638 2 7.99902 3.00736 7.99902 4.25V5H5.5C4.25736 5 3.25 6.00736 3.25 7.25C3.25 8.28958 3.95503 9.16449 4.91303 9.42267L5.54076 19.8848C5.61205 21.0729 6.59642 22 7.78672 22H16.2113C17.4016 22 18.386 21.0729 18.4573 19.8848L19.085 9.42267C20.043 9.16449 20.748 8.28958 20.748 7.25C20.748 6.00736 19.7407 5 18.498 5H15.999V4.25C15.999 3.00736 14.9917 2 13.749 2H10.249ZM14.499 5V4.25C14.499 3.83579 14.1632 3.5 13.749 3.5H10.249C9.83481 3.5 9.49902 3.83579 9.49902 4.25V5H14.499ZM5.5 6.5C5.08579 6.5 4.75 6.83579 4.75 7.25C4.75 7.66421 5.08579 8 5.5 8H18.498C18.9123 8 19.248 7.66421 19.248 7.25C19.248 6.83579 18.9123 6.5 18.498 6.5H5.5ZM6.42037 9.5H17.5777L16.96 19.7949C16.9362 20.191 16.6081 20.5 16.2113 20.5H7.78672C7.38995 20.5 7.06183 20.191 7.03807 19.7949L6.42037 9.5Z" fill="#373737"/>
                                    </svg>
                                </a>
                            </div>
                    </div>
                    </div>';
                    }
                }

                try {
                    $deliveryMethods = $pdo->query("SELECT * FROM delivery_method");
                }catch (PDOException $e) {
                    echo 'Nie udało się odczytać danych z bazy';
                    //exit();
                }
                
                echo '
                
                <div class="container-md cart-item mb-2">
                <div class="container mt-3 mb-2">
                <h2 class="mb-4">Wybierz metodę dostawy</h2>
                <div class="row g-3">';
                foreach($deliveryMethods as $delivery){
                    echo '
                    <div class="col-md-4">
                    <label for="delivery'.$delivery['delivery_id'].'" class="card" onclick="rememberDelivery('."'".$delivery['delivery_id']."'".')">
                    <div class="card-body">';
                    if($_COOKIE['delivery_method']==$delivery['delivery_id']){
                        $wholeprice+=$delivery['price'];
                        echo '
                        <input class="form-check-input" type="radio" name="delivery_method" id="delivery'.$delivery['delivery_id'].'" value="'.$delivery['delivery_id'].'" checked>
                        ';
                    }else{
                        echo '
                        <input class="form-check-input" type="radio" name="delivery_method" id="delivery'.$delivery['delivery_id'].'" value="'.$delivery['delivery_id'].'">
                        ';  
                    }
                    echo '  <div class="form-check">
                    '.$delivery['name'].' <b>'.$delivery['price'].' zł</b>
                    </div>
                    </div>
                    </label>
                    </div>';
                }
                echo '</div>
                </div>
                </div>
                ';
                
                try {
                    $paymentMethods = $pdo->query("SELECT * FROM payment_methods");
                }catch (PDOException $e) {
                    echo 'Nie udało się odczytać danych z bazy';
                    //exit();
                }
                
                echo '
                
                <div class="container-md cart-item mb-2">
                <div class="container mt-3 mb-2">
                <h2 class="mb-4">Wybierz sposób płatności</h2>
                <div class="row g-3">';
                foreach($paymentMethods as $payment){
                    echo '
                    <div class="col-md-4">
                    <label for="payment'.$payment['payment_id'].'" class="card" onclick="rememberPayment('."'".$payment['payment_id']."'".')">
                    <div class="card-body">';
                    if($_COOKIE['payment_method']==$payment['payment_id']){
                        echo '
                        <input class="form-check-input" type="radio" name="payment_method" id="payment'.$payment['payment_id'].'" value="'.$payment['payment_id'].'" checked>
                        ';
                    }else{
                        echo '
                        <input class="form-check-input" type="radio" name="payment_method" id="payment'.$payment['payment_id'].'" value="'.$payment['payment_id'].'">
                        ';  
                    }
                    echo '  <div class="form-check">
                    '.$payment['name'].'
                                        </div>
                                </div>
                            </label>
                        </div>';
                }
                    echo '</div>
                    </div>
                    </div>
                    </form>'
                    ;
                $_SESSION['whole_price']=$wholeprice;
                    echo '<div class="container-md" style="text-align: right; color: black">
                        <hr style=" border: 3px solid black;">
                        <h4 >Łącznie '.$wholeprice.' zł</h4>
                        <a href="dane/" class="btn btn-success btn-lg">Dalej</a>
                    </div>';
                ?>
            
        </div>
    </div>
</div>
    

<!-- Stopka -->
<?php include("../scripts/footer.php")?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

        });
        
        // funkcja ajax uruchamiająca plik logout.php
        function logout(){
            $.ajax({
                url: "../scripts/logout.php",
            }).done(function( data ) {
                location.reload();
            });
        }

        function login(){
            window.location.assign("../login/");
        }

        function register(){
            window.location.assign("../rejestr/");
        }

        function remove_from_cart(item){
            var id=item;
            //alert(id);
            $.ajax({
                url: "../scripts/remove_from_cart.php",
                method: 'POST',
                data: {
                    item: id
                }
            }).done(function( data ) {
                  document.getElementById(id).remove();
                  location.reload();
            });
        }
        function myFunction(item) {
            var id=item;
            var am = document.getElementById("amount"+id).value;
            //alert(am);
            $.ajax({
                url: "../scripts/change_amount_in_cart.php",
                method: 'POST',
                data: {
                    item: id,
                    amount: am
                }
            }).done(function( data ) {
                //alert(data);
                location.reload();
            });
        }
        function rememberPayment(option) {
            var id=option;
            //alert(id);
            $.ajax({
                url: "../scripts/remember_payment.php",
                method: 'POST',
                data: {
                    option: id
                }
            }).done(function( data ) {
                location.reload();
            });
        }
        function rememberDelivery(option) {
            var id=option;
            // alert(id);
            $.ajax({
                url: "../scripts/remember_delivery.php",
                method: 'POST',
                data: {
                    option: id
                }
            }).done(function( data ) {
                location.reload();
            });
        }
        </script>
</body>
</html>