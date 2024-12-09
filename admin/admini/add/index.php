<?php
session_start();
if(!isset($_SESSION['admin']) || (isset($_SESSION['admin'])&&$_SESSION['admin']==0)){
    header("location: https://chalimoniukmikolaj.infinityfreeapp.com/");
}
require_once("../../../scripts/database.php");

if(isset($_POST['submit'])){
    try {
        $data=[
            "login"=>htmlspecialchars($_POST['login']),
            "email"=>htmlspecialchars($_POST['email']),
            "name"=>htmlspecialchars($_POST['name']),
            "surname"=>htmlspecialchars($_POST['surname']),
            "phone"=>htmlspecialchars($_POST['phone']),
            "road"=>htmlspecialchars($_POST['road']),
            "city"=>htmlspecialchars($_POST['city']),
            "postal_code"=>htmlspecialchars($_POST['postal_code']),
            "house_number"=>htmlspecialchars($_POST['house_number']),
        ];
        $update = $pdo->prepare("INSERT INTO users (login,email,name,surname,phone,road,city,postal_code,house_number,admin) values (:login,:email,:name,:surname,:phone,:road,:city,:postal_code,:house_number,'1')");
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
                    <th scope="col">Email</th>
                    <th scope="col">Imię</th>
                    <th scope="col">Nazwisko</th>
                    <th scope="col">Telefon</th>
                    <th scope="col">Kod pocztowy</th>
                    <th scope="col">Miasto</th>
                    <th scope="col">Ulica</th>
                    <th scope="col">Nr. Budynku</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" id="login" name="login" class="form-control" placeholder="Login..." value=""></td>
                    <td><input type="text" id="email" name="email" class="form-control" placeholder="Email..." value=""></td>
                    <td><input type="text" id="name" name="name" class="form-control" placeholder="Imię..." value=""></td>
                    <td><input type="text" id="surname" name="surname" class="form-control" placeholder="Nazwisko..." value=""></td>
                    <td><input type="text" id="phone" name="phone" class="form-control" placeholder="Nr. Tel..." value=""></td>
                    <td><input type="text" id="postal_code" name="postal_code" class="form-control" placeholder="Kod pocztowy..." value=""></td>
                    <td><input type="text" id="city" name="city" class="form-control" placeholder="Miasto..." value=""></td>
                    <td><input type="text" id="road" name="road" class="form-control" placeholder="Ulica..." value=""></td>
                    <td><input type="text" id="house_number" name="house_number" class="form-control" placeholder="Nr. Budynku..." value=""></td>
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