<?php
session_start();
require_once("../scripts/database.php");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Katalog</title>
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
<form action="" method="get">
<!-- navbar -->
<?php include("../scripts/header.php")?>

<div class="container-fluid p-0 d-flex h-100">
    <!-- Sidebar -->
    <div id="bdSidebar" class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white offcanvas-md offcanvas-start col-4 col-lg-3">
        <ul class="mynav nav nav-pills flex-column mb-auto">
            <li class="nav-item mb-1">
                <h4>Filtruj produkty</h4>
                <div class="p-3">
                    <!-- Kategorie -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategoria</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Wszystkie</option>
                            <?php 
                            try {
                            $q = $pdo->query("SELECT * FROM category");
                            }catch (PDOException $e) {
                                echo 'Nie udało się odczytać danych z bazy';
                                //exit();
                            }
                            foreach($q as $row){
                                if($row['category_id']==htmlspecialchars($_GET['category'])){
                                echo '<option value="'.$row['category_id'].'" selected>'.$row['name'].'</option>';
                                }else{
                                echo '<option value="'.$row['category_id'].'">'.$row['name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Przedział cenowy -->
                    <div class="mb-3">
                        <label class="form-label">Przedział cenowy</label>
                        <div class="d-flex">
                            <input type="number" class="form-control me-2" min="0" placeholder="Od" aria-label="Od" name="minPrice" <?php if(isset($_GET['minPrice'])){echo 'value="'.htmlspecialchars($_GET['minPrice']).'"';}else{echo 'value="0"';}?>>
                            <input type="number" class="form-control" min="0" placeholder="Do" aria-label="Do" name="maxPrice" <?php if(isset($_GET['maxPrice'])){echo 'value="'.htmlspecialchars($_GET['maxPrice']).'"';}else{echo 'value="1000000"';}?>>
                        </div>
                    </div>
                    <!-- Ocena produktu -->
                    <div class="mb-3">
                        <label class="form-label">Ocena</label>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" id="ratingDefault" value="0" checked>
                                <label class="form-check-label" for="ratingRatingDefault">Wszystkie</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" id="rating1" value="5" <?php if(htmlspecialchars($_GET['rating'])==5){echo "checked";}?>>
                                <label class="form-check-label" for="rating1">5 gwiazdek</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" id="rating2" value="4" <?php if(htmlspecialchars($_GET['rating'])==4){echo "checked";}?>>
                                <label class="form-check-label" for="rating2">4+ gwiazdki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" id="rating3" value="3" <?php if(htmlspecialchars($_GET['rating'])==3){echo "checked";}?>>
                                <label class="form-check-label" for="rating3">3+ gwiazdki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" id="rating4" value="2" <?php if(htmlspecialchars($_GET['rating'])==2){echo "checked";}?>>
                                <label class="form-check-label" for="rating4">2+ gwiazdki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" id="rating5" value="1" <?php if(htmlspecialchars($_GET['rating'])==1){echo "checked";}?>>
                                <label class="form-check-label" for="rating5">1+ gwiazdki</label>
                            </div>
                        </div>
                    </div>
                    <!-- Sortowanie -->
                    <div class="mb-3">
                        <label for="sortOrder" class="form-label">Sortuj według</label>
                        <select class="form-select" id="sortOrder" name="order">
                            <option value="1" <?php if(htmlspecialchars($_GET['order'])==1){echo "selected";}?>>Cena: od najniższej</option>
                            <option value="2" <?php if(htmlspecialchars($_GET['order'])==2){echo "selected";}?>>Cena: od najwyższej</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Zastosuj filtr</button>
                </div>
            </li>
        </ul>
        <hr>
    </div>

    <div class="bg-light flex-fill">
        
        <!-- Ciało storny -->
        <div class="p-4">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 d-flex">
                <?php 
                try {

                if(htmlspecialchars($_GET['order'])==1){
                    $order="asc";
                }else if(htmlspecialchars($_GET['order'])==2){
                    $order="desc";
                }

                $minPrice=0;
                $maxPrice=1000000;
                $rating=0;
                $search="";

                if(isset($_GET['minPrice']) && $_GET['minPrice']!=""){
                    $minPrice=$_GET['minPrice'];
                }
                if(isset($_GET['maxPrice']) && $_GET['maxPrice']!=""){
                    $maxPrice=$_GET['maxPrice'];
                }
                if(isset($_GET['rating']) && $_GET['rating']>0){
                    $rating=$_GET['rating'];
                    $rc=" and AVG(rating) >= ".$rating." ";
                    $r2=" HAVING AVG(rating) >= ".$rating." ";
                }else{
                    $rc=" ";
                    $r2=" ";
                }

                if(isset($_GET['search'])){
                    $search=htmlspecialchars($_GET['search']);
                }

                if(($_GET['category'])==""||!isset($_GET['category'])){
                    $noi = $pdo->query("SELECT COUNT(*), item_id FROM items WHERE name like '%".$search."%' and price BETWEEN ".$minPrice." and ".$maxPrice." and item_id in (SELECT items.item_id FROM items left join reviews on items.item_id = reviews.item_id GROUP by item_id ".$r2.")");
                    $nOfitems = $noi->fetchColumn();
                }else{
                    $noi = $pdo->query("SELECT COUNT(*), item_id FROM items WHERE name like '%".$search."%' and category=".htmlspecialchars($_GET['category'])." and price BETWEEN ".$minPrice." and ".$maxPrice." and item_id in (SELECT items.item_id FROM items left join reviews on items.item_id = reviews.item_id GROUP by item_id ".$r2.")");
                    $nOfitems = $noi->fetchColumn();
                }


                // ilosc wyswietlana produktow na jesdnej stronie
                $nOnpage=18;

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

                if(($_GET['category'])==""||!isset($_GET['category'])){
                    $q = $pdo->query("SELECT items.* , AVG(rating) FROM items left join reviews on items.item_id = reviews.item_id GROUP by item_id HAVING name like '%".$search."%' and price BETWEEN ".$minPrice." and ".$maxPrice.$rc." order by price ".$order." LIMIT ".$nOnpage." OFFSET ".$offset);
                }else{
                    $q = $pdo->query("SELECT items.* , AVG(rating) FROM items left join reviews on items.item_id = reviews.item_id GROUP by item_id HAVING name like '%".$search."%' and category=".htmlspecialchars($_GET['category'])." and price BETWEEN ".$minPrice." and ".$maxPrice.$rc." order by price ".$order." LIMIT ".$nOnpage." OFFSET ".$offset);
                }
                
                }catch (PDOException $e) {
                    echo 'Nie udało się odczytać danych z bazy';
                    //exit();
                }

                foreach ($q as $row){
                
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

                //if(floor($avgRating)>=$rating){
                echo '
                <div class="col">
                    <a href="../produkt/?item='.$row['item_id'].'" style="color: inherit; text-decoration: inherit;">
                    <div class="card d-flex align-items-stretch">
                        <img src="data:image;base64,'.base64_encode($row['main_img']).'" class="card-img-top card-img" alt="'.$row['name'].'">
                        <div class="card-body ">
                            <h5 class="card-title">'.$row['name'].'</h5>
                            <p class="card-text">'.$row['short_description'].'</p>
                            <ul class="list-unstyled">
                                <li><strong>Cena:</strong> '.$row['price'].' PLN</li>
                                <li><strong>Ocena:</strong>
                                '; 
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
                //}
                }
                ?>
            </div>
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
        </div>
    </div>
</div>
    

<!-- Stopka -->
<?php include("../scripts/footer.php")?>

</form>
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

        function add_to_favourites(item){
            var id=item;
            //alert(id);
            $.ajax({
                url: "../scripts/add_to_favourites.php",
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
                url: "../scripts/add_to_cart.php",
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