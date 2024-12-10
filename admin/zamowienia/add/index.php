<?php
session_start();
if(!isset($_SESSION['admin']) || (isset($_SESSION['admin'])&&$_SESSION['admin']==0)){
    header("location: https://chalimoniukmikolaj.infinityfreeapp.com/");
}
require_once("../../../scripts/database.php");

if(isset($_POST['submit'])){

    try {

        $mo = $pdo->query("SELECT MAX(order_id) FROM orders");
        $maxo = $mo->fetchColumn();
        $maxo+=1;
        $data=[
            "user"=>htmlspecialchars($_POST['user']),
            "order_status"=>htmlspecialchars($_POST['order_status']),
            "payment_method"=>htmlspecialchars($_POST['payment_method']),
            "delivery_method"=>htmlspecialchars($_POST['delivery_method']),
            "road"=>htmlspecialchars($_POST['road']),
            "city"=>htmlspecialchars($_POST['city']),
            "postal_code"=>htmlspecialchars($_POST['postal_code']),
            "house_number"=>htmlspecialchars($_POST['house_number']),
            'time' => date("Y-m-d H:i:s"),
            'order_id'=>$maxo
        ];
        $update = $pdo->prepare("INSERT INTO orders (order_id,user,payment_method,delivery_method,order_status,road,city,postal_code,house_number,time) values (:order_id,:user,:payment_method,:delivery_method,:order_status,:road,:city,:postal_code,:house_number,:time)");
        $update->execute($data);
    }catch (PDOException $e) {
        echo 'Nie udało się odczytać danych z bazy';
        //exit();
    }
    header("location: ../");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Kategorie</title>
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
        .table{
        display: block !important;
        overflow-x: auto !important;
        width: 100% !important;
        }
    </style>
</head>
<body>
<!-- navbar -->
<?php include("../../admin_navbar.php")?>

<div class="container-fluid p-0 d-flex h-100">

    <!-- Sidebar -->
    <?php include("../../admin_sidebar.php")?>

    <div class="bg-light flex-fill table-responsive">
        <!-- Sidebar po zmniejszeniu -->
        <?php include("../admin_sidebartop.php")?>
        
        <!-- Ciało storny -->
        <div class="p-4">
            <form method="post" action="">
            <div style="color: black">
            <h2>Kategorie</h2> 
            <hr>
            </div>

            <table class="table">
            <thead>
                <tr>
                    <th scope="col">Login</th>
                    <th scope="col">Sposób Dostawy</th>
                    <th scope="col">Metoda płątności</th>
                    <th scope="col">Status zamówienia</th>
                    <th scope="col">Kod pocztowy</th>
                    <th scope="col">Miasto</th>
                    <th scope="col">Ulica</th>
                    <th scope="col">Nr. Budynku</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" id="user" name="user" class="form-control" placeholder="Login..." value=""></td>
                    <?php 
                        echo'
                        <td><select type="text" id="delivery_method" name="delivery_method" class="form-control"  value="" required>
                        ';
                            try {
                            $do = $pdo->query("SELECT * FROM delivery_method");
                            }catch (PDOException $e) {
                                echo 'Wystąpił błąd';
                                //exit();
                            }
                            foreach($do as $method){
                                echo'<option value="'.$method['delivery_id'].'">'.$method['name'].'-'.$method['price'].'zł</option>';
                            }
                        echo '
                        </select></td>
                        ';

                        echo'
                        <td><select type="text" id="payment_method" name="payment_method" class="form-control" placeholder="" value="" required>
                        ';
                            try {
                            $po = $pdo->query("SELECT * FROM payment_methods");
                            }catch (PDOException $e) {
                                echo 'Wystąpił błąd';
                                //exit();
                            }
                            foreach($po as $method){
                                echo'<option value="'.$method['payment_id'].'">'.$method['name'].'</option>';
                            }
                        echo '
                        </select></td>
                        ';

                        echo'
                        <td><select type="text" id="order_status" name="order_status" class="form-control" placeholder="" value="" required>
                        ';
                            try {
                            $ost = $pdo->query("SELECT * FROM order_satus");
                            }catch (PDOException $e) {
                                echo 'Wystąpił błąd';
                                //exit();
                            }
                            foreach($ost as $status){
                                echo'<option value="'.$status['status_id'].'">'.$status['name'].'</option>';
                            }
                        echo '
                        </select></td>
                        ';
                    ?>
                    <td><input type="text" id="postal_code" name="postal_code" class="form-control" placeholder="Kod pocztowy..." value="" required></td>
                    <td><input type="text" id="city" name="city" class="form-control" placeholder="Miasto..." value="" required></td>
                    <td><input type="text" id="road" name="road" class="form-control" placeholder="Ulica..." value=""required></td>
                    <td><input type="text" id="house_number" name="house_number" class="form-control" placeholder="Nr. Budynku..." value="" required></td>
                </tr>
            </tbody>
            </table>
        
            <div class="mt-3" style="text-align: left;">
                <input type="submit" id="submit" name="submit" class="btn btn-success" value="Zapisz">
            </div>
            </form>
        </div>
    </div>
</div>
    

<!-- Stopka -->
<?php include("../../../scripts/footer.php")?>

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