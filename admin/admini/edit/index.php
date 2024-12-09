<?php
session_start();
if(!isset($_SESSION['login'])){
    header("location: ../../../");
}
require_once("../../../scripts/database.php");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Administratorzy</title>
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
        <?php include("../../admin_sidebartop.php")?>

        <!-- Ciało storny -->
        <div class="p-4">
            <form method="get" action="">
            <div style="color: black">
            <h2>Administratorzy - Edycja</h2> 
            <hr>
            </div>

            <table class="table">
            <thead>
                <tr>
                <th scope="col">Login</th>
                <th scope="col">Email</th>
                <th scope="col">Imię</th>
                <th scope="col">Nazwisko</th>
                <th scope="col">Telefon</th>
                <th scope="col">Kod pocztowy</th>
                <th scope="col">Miasto</th>
                <th scope="col">Ulica</th>
                <th scope="col">Nr. Budynku</th>
                </tr>
            </thead>
            <tbody>
            
            <?php

                try {
                    $admins = $pdo->prepare("SELECT * FROM users where login='".$_GET['login']."'");
                    $admins->execute();
                }catch (PDOException $e) {
                    echo 'Nie udało się odczytać danych z bazy';
                    //exit();
                }

                foreach($admins as $admin){
                    echo '
                        <tr>
                            <td>'.$admin['login'].'</td>
                            <td>'.$admin['email'].'</td>
                            <td>'.$admin['name'].'</td>
                            <td>'.$admin['surname'].'</td>
                            <td>'.$admin['phone'].'</td>
                            <td>'.$admin['postal_code'].'</td>
                            <td>'.$admin['city'].'</td>
                            <td>'.$admin['road'].'</td>
                            <td>'.$admin['house_number'].'</td>
                        </tr>
                    ';
                }
            ?>

            </tbody>
            </table>
        
            <div class="mt-3" style="text-align: center;">
                
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
                url: "../../../scripts/logout.php",
            }).done(function( data ) {
                location.reload();
            });
        }

        function login(){
            window.location.assign("../../../login/");
        }

        function register(){
            window.location.assign("../../../rejestr/");
        }
        function remove_user(item){
            var login=item;
            alert();
            $.ajax({
                url: "../../../scripts/remove_user.php",
                method: 'POST',
                data: {
                    login: login
                }
            }).done(function( data ) {
                  location.reload();
            });
        }
        function edit_user(item){
            var login=item;
            window.location.assign("../edit/?login="+login);
        }
        </script>
</body>
</html>