<?php
session_start();
require_once('scripts/database.php');
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Greg.inc</title>
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
    </style>
</head>
<body>
<form action="katalog/" method="get">
<!-- navbar -->
<?php include("scripts/header.php")?>


<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="assets/images/slider3.png" class="d-block w-100" alt="slider3">
    </div>
    <div class="carousel-item">
      <img src="assets/images/slider2.png" class="d-block w-100" alt="slider2">
    </div>
    <div class="carousel-item">
      <img src="assets/images/slider1.png" class="d-block w-100" alt="slider1">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<div class="container-fluid p-0 d-flex h-100">
    

    <div class="bg-light flex-fill">
        <!-- Ciało storny -->
        <div class="p-4">
            <div class="row row-cols-1 row-cols-md-3 g-4 d-flex text-center">
                <?php 
                try {
                $q = $pdo->query("SELECT * FROM category");
                }catch (PDOException $e) {
                    echo 'Nie udało się odczytać danych z bazy';
                    //exit();
                }
                foreach($q as $row){
                    echo '<div class="col">
                    <a href="katalog/?category='.$row['category_id'].'" class="btn btn-primary btn-lg d-flex flex-column align-items-center justify-content-center" style="height: 150px; text-decoration: none;">
                        <i class="lni lni-laptop" style="font-size: 48px;"></i>
                        <span class="mt-2">'.$row['name'].'</span>
                    </a>
                    </div>';
                }
                ?>
                
            </div>
        </div>

        <div class="bg-dark text-white text-center py-2 mb-4">
            <h3 class="m-0">Polecane produkty</h3>
        </div>
	
	    <div class="p-4">
            <div class="row row-cols-1 row-cols-md-3 g-4 d-flex">
            <?php 
                try {
                

                $q = $pdo->query("SELECT * FROM items LIMIT 6");
                }catch (PDOException $e) {
                    echo 'Nie udało się odczytać danych z bazy';
                    //exit();
                }

                foreach ($q as $row){
                echo '
                <div class="col">
                    <a href="/produkt/?item='.$row['item_id'].'" style="color: inherit; text-decoration: inherit;">
                    <div class="card d-flex align-items-stretch">
                        <img src="data:image;base64,'.base64_encode($row['main_img']).'" class="card-img-top card-img" alt="'.$row['name'].'">
                        <div class="card-body ">
                            <h5 class="card-title">'.$row['name'].'</h5>
                            <p class="card-text">'.$row['short_description'].'</p>
                            <ul class="list-unstyled">
                                <li><strong>Cena:</strong> '.$row['price'].' PLN</li>
                                <li><strong>Ocena:</strong>
                                '; 
                                $data = [
                                    'id' => $row['item_id'],
                                ];
                                try {
                                $a = $pdo->prepare("SELECT AVG(rating) FROM reviews WHERE item_id = :id");
                                $a->execute($data);
                                $avgRating = $a->fetchColumn(); 
                                }catch (PDOException $e) {
                                    echo 'Nie udało się odczytać danych z bazy';
                                    //exit();
                                }
                                for ($s=0;$s<floor($avgRating);$s++){
                                    echo'★';
                                }
                                for ($s=0;$s<5-floor($avgRating);$s++){
                                    echo'☆';
                                }
                                echo '('.round($avgRating,2).')</li></ul>';
                echo '
                            <div class="row">
                                <div class="col-7">
                                <a href="javascript:add_to_cart('."'".$row['item_id']."'".')" class="btn btn-outline-light">Dodaj do koszyka</a>
                                </div>
                                <div class="col" style="text-align: right;">';

                      $data = [
                          'user' => $_SESSION['login'],
                      ];
                      $isAdded=false;

                      $in = $pdo->prepare("SELECT item_id FROM favourites where user = :user");
                      $in->execute($data);
                      
                      foreach($in as $r){
                          if($row['item_id']==$r['item_id']){
                              $isAdded=true;
                              break;
                          }
                      }
                            
                     if(isset($_SESSION['login'])&&$isAdded==true){
                        echo ' <a href="javascript:add_to_favourites('."'".$row['item_id']."'".')" class="btn btn-primary me-2" id="'.$row['item_id'].'">
                                  <svg width="24" height="24" viewBox="0 0 24 24" fill="#ff0000" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                  <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8227 4.77124L12 4.94862L12.1773 4.77135C14.4244 2.52427 18.0676 2.52427 20.3147 4.77134C22.5618 7.01842 22.5618 10.6616 20.3147 12.9087L13.591 19.6324C12.7123 20.5111 11.2877 20.5111 10.409 19.6324L3.6853 12.9086C1.43823 10.6615 1.43823 7.01831 3.6853 4.77124C5.93237 2.52417 9.5756 2.52417 11.8227 4.77124ZM10.762 5.8319C9.10073 4.17062 6.40725 4.17062 4.74596 5.8319C3.08468 7.49319 3.08468 10.1867 4.74596 11.848L11.4697 18.5718C11.7625 18.8647 12.2374 18.8647 12.5303 18.5718L19.254 11.8481C20.9153 10.1868 20.9153 7.49329 19.254 5.83201C17.5927 4.17072 14.8993 4.17072 13.238 5.83201L12.5304 6.53961C12.3897 6.68026 12.199 6.75928 12 6.75928C11.8011 6.75928 11.6104 6.68026 11.4697 6.53961L10.762 5.8319Z" fill="#ff0000"/>
                                  </svg>
                              </a>';
                     }else if(isset($_SESSION['login'])){
                        echo ' <a href="javascript:add_to_favourites('."'".$row['item_id']."'".')" class="btn btn-primary me-2" id="'.$row['item_id'].'">
                                  <svg width="24" height="24" viewBox="0 0 24 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                  <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8227 4.77124L12 4.94862L12.1773 4.77135C14.4244 2.52427 18.0676 2.52427 20.3147 4.77134C22.5618 7.01842 22.5618 10.6616 20.3147 12.9087L13.591 19.6324C12.7123 20.5111 11.2877 20.5111 10.409 19.6324L3.6853 12.9086C1.43823 10.6615 1.43823 7.01831 3.6853 4.77124C5.93237 2.52417 9.5756 2.52417 11.8227 4.77124ZM10.762 5.8319C9.10073 4.17062 6.40725 4.17062 4.74596 5.8319C3.08468 7.49319 3.08468 10.1867 4.74596 11.848L11.4697 18.5718C11.7625 18.8647 12.2374 18.8647 12.5303 18.5718L19.254 11.8481C20.9153 10.1868 20.9153 7.49329 19.254 5.83201C17.5927 4.17072 14.8993 4.17072 13.238 5.83201L12.5304 6.53961C12.3897 6.68026 12.199 6.75928 12 6.75928C11.8011 6.75928 11.6104 6.68026 11.4697 6.53961L10.762 5.8319Z" fill="#ffffff"/>
                                  </svg>
                              </a>';
                     }
                echo '
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                ';
                }
                ?>
                
            </div>
        </div>
    </div>
</div>

<!-- Stopka -->
<?php include("scripts/footer.php")?>

</form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
        });
        
        // funkcja ajax uruchamiająca plik logout.php
        function logout(){
            $.ajax({
                url: "scripts/logout.php",
            }).done(function( data ) {
                location.reload();
            });
        }

        function login(){
            window.location.assign("login/");
        }

        function register(){
            window.location.assign("rejestr/");
        }

        function add_to_favourites(item){
            var id=item;
            //alert(id);
            $.ajax({
                url: "scripts/add_to_favourites.php",
                method: 'POST',
                data: {
                    item: id
                }
            }).done(function( data ) {
                //alert(data);
                if(data=="add"){
                  document.getElementById(id).innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="#ff0000" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)"> <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8227 4.77124L12 4.94862L12.1773 4.77135C14.4244 2.52427 18.0676 2.52427 20.3147 4.77134C22.5618 7.01842 22.5618 10.6616 20.3147 12.9087L13.591 19.6324C12.7123 20.5111 11.2877 20.5111 10.409 19.6324L3.6853 12.9086C1.43823 10.6615 1.43823 7.01831 3.6853 4.77124C5.93237 2.52417 9.5756 2.52417 11.8227 4.77124ZM10.762 5.8319C9.10073 4.17062 6.40725 4.17062 4.74596 5.8319C3.08468 7.49319 3.08468 10.1867 4.74596 11.848L11.4697 18.5718C11.7625 18.8647 12.2374 18.8647 12.5303 18.5718L19.254 11.8481C20.9153 10.1868 20.9153 7.49329 19.254 5.83201C17.5927 4.17072 14.8993 4.17072 13.238 5.83201L12.5304 6.53961C12.3897 6.68026 12.199 6.75928 12 6.75928C11.8011 6.75928 11.6104 6.68026 11.4697 6.53961L10.762 5.8319Z" fill="#ff0000"/></svg>';
                }else if(data=="remove"){
                  document.getElementById(id).innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)"> <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8227 4.77124L12 4.94862L12.1773 4.77135C14.4244 2.52427 18.0676 2.52427 20.3147 4.77134C22.5618 7.01842 22.5618 10.6616 20.3147 12.9087L13.591 19.6324C12.7123 20.5111 11.2877 20.5111 10.409 19.6324L3.6853 12.9086C1.43823 10.6615 1.43823 7.01831 3.6853 4.77124C5.93237 2.52417 9.5756 2.52417 11.8227 4.77124ZM10.762 5.8319C9.10073 4.17062 6.40725 4.17062 4.74596 5.8319C3.08468 7.49319 3.08468 10.1867 4.74596 11.848L11.4697 18.5718C11.7625 18.8647 12.2374 18.8647 12.5303 18.5718L19.254 11.8481C20.9153 10.1868 20.9153 7.49329 19.254 5.83201C17.5927 4.17072 14.8993 4.17072 13.238 5.83201L12.5304 6.53961C12.3897 6.68026 12.199 6.75928 12 6.75928C11.8011 6.75928 11.6104 6.68026 11.4697 6.53961L10.762 5.8319Z" fill="#ffffff"/></svg>';
                }
              });
        }
        function add_to_cart(item){
            var id=item;
            //alert(id);
            $.ajax({
                url: "/scripts/add_to_cart.php",
                method: 'POST',
                data: {
                    item: id
                }
            }).done(function( data ) {
                alert("Dodano do koszyka!");
            });
        }
        </script>
</body>
</html>

