<?php
session_start();
require_once('../../scripts/database.php')
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Dane zamówienia</title>
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
        <h2>Dane do zamówienia</h2>    
        <hr>
        </div>
        <form method="post" action="../podsumowanie/">
            <div class="container-md cart-item mb-2">
                <div class="row">
                <div class="col-12 col-md-6">
                    <div class="row g-3 m-2">
                        <!-- Imię -->
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">Imię</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Podaj imię" pattern="[A-ZÀ-ÿA-ZŻŹĆĄŚĘŁÓŃ][\-,a-z.'żźćńółęąś]+" maxlength="50" value="<?php echo $_SESSION['name']?>" required>
                        </div>
                        <!-- Nazwisko -->
                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Nazwisko</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Podaj nazwisko" pattern="([A-Za-zÀ-ÿA-ZŻŹĆĄŚĘŁÓŃżźćńółęąś][\-,a-z. 'żźćńółęąś]+[ ]*)+[a-zżźćńółęąś]" maxlength="60" value="<?php echo $_SESSION['surname']?>" required>
                        </div>
                        <!-- Nr telefonu -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Numer telefonu</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Podaj numer telefonu" pattern="[0-9]{9}" value="<?php echo $_SESSION['phone']?>" required>
                        </div>
                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Podaj email" pattern="^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$" value="<?php echo $_SESSION['email']?>" required>
                        </div>
                        <!-- Ulica -->
                        <div class="col-md-6">
                            <label for="road" class="form-label">Ulica</label>
                            <input type="text" class="form-control" id="road" name="road" placeholder="Podaj ulice" maxlength="60" value="<?php echo $_SESSION['road']?>" required>
                        </div>
                        <!-- Numer domu -->
                        <div class="col-md-6">
                            <label for="houseNumber" class="form-label">Numer domu</label>
                            <input type="text" class="form-control" id="houseNumber" name="houseNumber" placeholder="Podaj numer domu" maxlength="10" value="<?php echo $_SESSION['house_number']?>" required>
                        </div>
                        <!-- Kod pocztowy -->
                        <div class="col-md-6">
                            <label for="postalCode" class="form-label">Kod pocztowy</label>
                            <input type="text" class="form-control" id="postalCode" name="postalCode" placeholder="00-000" pattern="\d{2}-\d{3}" value="<?php echo $_SESSION['postal_code']?>" required>
                        </div>
                        <!-- Miejscowość -->
                        <div class="col-md-6">
                            <label for="city" class="form-label">Miejscowość</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Podaj miejscowość" maxlength="50" value="<?php echo $_SESSION['city']?>" required>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="mt-3" style="text-align: center;">
                        <input type="checkbox" id="addressCheckbox" name="addressCheckbox" value="1" onchange="address();">
                        <label for="addressCheckbox"> Inny adres dostawy</label><br>
                    </div>
                    <div class="row g-3 m-2">
                    <div id="otheraddress">
                        
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <?php
            echo '<div class="container-md" style="text-align: right; color: black">
            <hr style=" border: 3px solid black;">
            <h4 >Łącznie '.$_SESSION['whole_price'].' zł</h4>
            <input type="submit" name="submit" class="btn btn-success btn-lg" value="Dalej">
            </div>';
            ?>
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
                window.location.assign("../../");
            });
        }

        function login(){
            window.location.assign("../../login/");
        }

        function register(){
            window.location.assign("../../rejestr/");
        }
        function address(){
            alert($('#addressCheckbox').val());
            $.ajax({
                url: "../../scripts/other_address.php",
                method: 'POST',
                data: {
                    check: $('#addressCheckbox').val(),
                }
            }).done(function( data ) {
                    $('#otheraddress').html(data);
            });
        }
        </script>
</body>
</html>