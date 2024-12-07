<?php
session_start();
require_once('../../scripts/database.php');
$_SESSION['Femail']=htmlspecialchars($_POST['email']);
$_SESSION['Fphone']=htmlspecialchars($_POST['phone']);
if($_POST['addressCheckbox']!=1){
    $_SESSION['Fname']=htmlspecialchars($_POST['firstName']);
    $_SESSION['Fsurname']=htmlspecialchars($_POST['lastName']);
    $_SESSION['Fpostal_code']=htmlspecialchars($_POST['postalCode']);
    $_SESSION['Fcity']=htmlspecialchars($_POST['city']);
    $_SESSION['Froad']=htmlspecialchars($_POST['road']);
    $_SESSION['Fhouse_number']=htmlspecialchars($_POST['houseNumber']);
}else{
    $_SESSION['Fname']=htmlspecialchars($_POST['otherfirstName']);
    $_SESSION['Fsurname']=htmlspecialchars($_POST['otherlastName']);
    $_SESSION['Fpostal_code']=htmlspecialchars($_POST['otherpostalCode']);
    $_SESSION['Fcity']=htmlspecialchars($_POST['othercity']);
    $_SESSION['Froad']=htmlspecialchars($_POST['otherroad']);
    $_SESSION['Fhouse_number']=htmlspecialchars($_POST['otherhouseNumber']);
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Podsumowanie</title>
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
        .cart-item {
            background-color: white;
            border-style: solid;
            border-width: 1px;
            border-color: #8a8a8a;
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

    <div class="bg-light flex-fill">
    
        <!-- Ciało storny -->
        <div class="p-4">
        <div style="color: black">
        <h2>Podsumowanie</h2>    
        <hr>
        </div>
            <div class="container-md cart-item mb-2">
            <div class="container summary-container">
                <!-- Dane klienta -->

                <?php 

                $data = [
                    'method' => $_COOKIE['delivery_method'],
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
                    'method' => $_COOKIE['payment_method'],
                ];
                try {
                    $pay = $pdo->prepare("SELECT name FROM payment_methods WHERE payment_id=:method");
                    $pay->execute($data);
                    $payment = $pay ->fetchColumn();
                }catch (PDOException $e) {
                    echo 'Nie udało się odczytać danych z bazy';
                    //exit();
                }


                echo '
                     <div class="row m-2 mt-3">
                        <div class="col-3">
                        <h5>Dane</h5>
                        <p>'.$_SESSION['Fname'].' '.$_SESSION['Fsurname'].'</p>
                        <p>'.$_SESSION['Femail'].'</p>
                        <p>'.$_SESSION['Fphone'].'</p>
                        </div>
                        <div class="col-3">
                        <h5>Płatność</h5>
                        '.$payment.'
                        </div>
                        <div class="col-3">
                        <h5>Dostawa</h5>
                        '.$delivery.'
                        </div>
                        <div class="col-3">
                        <h5>Adres dostawy</h5>
                        <p>ul.'.$_SESSION['Froad'].' '.$_SESSION['Fhouse_number'].'</p>
                        <p>'.$_SESSION['Fpostal_code'].' '.$_SESSION['Fcity'].'</p>
                        </div>
                    </div>
                ';
                ?>

                <!-- Łączna cena koszyka -->
                <div id="cart-summary">
                    <h4 class="text-center">Łączna cena</h4>
                    <p class="total-price text-center"><?php echo $_SESSION['whole_price'];?> zł</p>
                </div>

                <!-- Przycisk przejścia do płatności -->
                <div class="text-center mt-2 mb-2">
                    <form action="../../scripts/add_order.php">
                    <input type="submit" class="btn btn-success btn-lg" value="Przejdź do płatności">
                    </form>
                </div>
            </div>
            </div>

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