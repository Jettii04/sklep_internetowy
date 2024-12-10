<?php
session_start();
if(!isset($_SESSION['admin']) || (isset($_SESSION['admin'])&&$_SESSION['admin']==0)){
    header("location: https://chalimoniukmikolaj.infinityfreeapp.com/");
}
require_once("../../../scripts/database.php");

if(isset($_POST['submit'])){
    try {
        $data=[
            "name"=>htmlspecialchars($_POST['name']),
            "price"=>htmlspecialchars($_POST['price']),
            "short_description"=>htmlspecialchars($_POST['short_description']),
            "description"=>htmlspecialchars($_POST['description']),
            "category"=>htmlspecialchars($_POST['category']),
        ];
        $update = $pdo->prepare("UPDATE items SET name=:name, price=:price, short_description=:short_description, description=:description, category=:category where item_id='".htmlspecialchars($_GET['item_id'])."'");
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
                    <th scope="col">Nazwa</th>
                    <th scope="col">Cena</th>
                    <th scope="col">Krótki opis</th>
                    <th scope="col">opis</th>
                    <th scope="col">Kategoria</th>
                    <th scope="col">Główne zadjęcie</th>
                </tr>
            </thead>
            <tbody>
            
            <?php
                try {
                    $items = $pdo->prepare("SELECT * FROM items where item_id='".htmlspecialchars($_GET['item_id'])."'");
                    $items->execute();
                }catch (PDOException $e) {
                    echo 'Nie udało się odczytać danych z bazy';
                    //exit();
                }

                foreach($items as $item){
                    echo '
                        <tr>
                            <td><input type="text" id="name" name="name" class="form-control" placeholder="Nazwa..." value="'.$item['name'].'" required></td>
                            <td><input type="text" id="price" name="price" class="form-control" placeholder="Cena..." value="'.$item['price'].'" required></td>
                            <td><input type="text" id="short_description" name="short_description" class="form-control" placeholder="Krótki opis..." value="'.$item['short_description'].'" required></td>
                            <td><input type="text" id="description" name="description" class="form-control" placeholder="Opis..." value="'.$item['description'].'" required></td>
                    ';

                    echo'
                        <td><select type="text" id="category" name="category" class="form-control" placeholder="" value="" required>
                        ';
                            try {
                            $ost = $pdo->query("SELECT * FROM category");
                            }catch (PDOException $e) {
                                echo 'Wystąpił błąd';
                                //exit();
                            }
                            echo'<option value="">Brak</option>';
                            foreach($ost as $cat){
                                
                                if($cat['category_id']==$item['category']){
                                    echo'<option value="'.$cat['category_id'].'" selected>'.$cat['name'].'</option>';
                                }else{
                                    echo'<option value="'.$cat['category_id'].'">'.$cat['name'].'</option>';
                                }
                            }
                        echo '
                        </select></td>
                    ';

                    echo'
                        </tr>
                    ';
                }
            ?>

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
        function remove(item){
            var id=item;
            alert();
            $.ajax({
                url: "../../scripts/remove_user.php",
                method: 'POST',
                data: {
                    category_id: id
                }
            }).done(function( data ) {
                  location.reload();
            });
        }
        function edit(item){
            var login=item;
            window.location.assign("edit/?login="+login);
        }
        </script>
</body>
</html>