<?php
session_start();
require_once("../scripts/database.php");

$item = htmlspecialchars($_GET['item']);
$data = [
    'item_id' => $item,
];
try {
$q = $pdo->prepare("SELECT * FROM items WHERE item_id = :item_id");
$q->execute($data);
$result = $q->fetch(PDO::FETCH_ASSOC);
$name = $result['name'];
$mainImg = $result['main_img'];
$price = $result['price'];
$shortDescription = $result['short_description'];
$desription = $result['description'];
$categoryId = $result['category'];
}catch (PDOException $e) {
    echo 'Nie udało się odczytać danych z bazy';
    //exit();
}

$data = [
    'id' => $categoryId,
];
try {
$q = $pdo->prepare("SELECT name FROM category WHERE category_id = :id");
$q->execute($data);
$categoryName = $q->fetchColumn();
}catch (PDOException $e) {
    echo 'Nie udało się odczytać danych z bazy';
    //exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a2e; /* Ciemnoniebieski odcień */
            color: #ffffff; /* Biały kolor tekstu */
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
        .product-gallery img {
            max-width: 100%;
            border-radius: 10px;
        }
        .gallery-thumbnails img {
            max-width: 80px;
            max-height: 80px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: 0.3s;
        }
        .gallery-thumbnails img:hover {
            border: 2px solid #ffffff;
        }
        .product-details {
            background-color: #16213e; /* Ciemny odcień dla sekcji produktu */
            border-radius: 10px;
            padding: 20px;
        }
        .btn-primary {
            border-radius: 30px;
            background-color: #1f4068;
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: #1b365d;
        }
        .main-img {
            width: 100%;
            height: 400px;
            object-fit:contain;
            margin-left: auto;
            margin-right:auto;
        }
    </style>
</head>
<body>
<form action="../katalog/" method="get">
<!-- navbar -->
<?php include("../scripts/header.php")?>

    <!-- Strona produktu -->
    <div class="container mt-5">
        <div class="row">
            <!-- Galeria zdjęć -->
            <div class="col-md-6">
                <div class="product-gallery mb-3">
                    <?php echo '<img id="main-image" class="main-img" src="data:image;base64,'.base64_encode($mainImg).'" alt="Zdjęcie produktu">'; ?>
                </div>
                <div class="gallery-thumbnails d-flex">
                    <?php 
                        echo '<img src="data:image;base64,'.base64_encode($mainImg).'" alt="Miniatura '.$i.'" onclick="document.getElementById('."'".'main-image'."'".').src='."'".'data:image;base64,'.base64_encode($mainImg)."'".'">';

                        $data = [
                            'id' => $item,
                        ];
                        try {
                        $q = $pdo->prepare("SELECT image FROM item_images WHERE item_id = :id");
                        $q->execute($data);
                        }catch (PDOException $e) {
                            echo 'Nie udało się odczytać danych z bazy';
                            //exit();
                        }
                        $i=0;
                        foreach($q as $row){
                            $i++;
                            echo '<img src="data:image;base64,'.base64_encode($row['image']).'" alt="Miniatura '.$i.'" onclick="document.getElementById('."'".'main-image'."'".').src='."'".'data:image;base64,'.base64_encode($row['image'])."'".'">';
                        }
                    ?>
                    </div>
            </div>

            <!-- Szczegóły produktu -->
            <div class="col-md-6">
                <div class="product-details">
                    <h2 class="mb-3"><?php echo $name; ?></h2>
                    <p class="mb-2"><strong>Kategoria:</strong> <?php echo $categoryName; ?></p>
                    <p class="mb-2"><strong>Ocena:</strong> 
                    <?php 
                    $data = [
                        'id' => $item,
                    ];
                    try {
                    $q = $pdo->prepare("SELECT AVG(rating) FROM reviews WHERE item_id = :id");
                    $q->execute($data);
                    $avgRating = $q->fetchColumn(); 
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
                    echo '('.round($avgRating,2).')';
                    ?>
                    </p>
                    <p class="mb-3"><strong>Cena:</strong> <span class="text-warning"><?php echo $price; ?> PLN</span></p>
                    <p class="mb-4"><?php echo $desription; ?></p>
                    <div class="d-flex">
                        <?php
                        $data = [
                            'user' => $_SESSION['login'],
                        ];
                        $isAdded=false;
    
                        $in = $pdo->prepare("SELECT item_id FROM favourites where user = :user");
                        $in->execute($data);
                        
                        foreach($in as $r){
                            if($_GET['item']==$r['item_id']){
                                $isAdded=true;
                                break;
                            }
                        }
                                
                        if(isset($_SESSION['login'])&&$isAdded==true){
                            echo ' <a href="javascript:add_to_favourites('."'".$_GET['item']."'".')" class="btn btn-primary me-2" id="'.$_GET['item'].'">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="#ff0000" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8227 4.77124L12 4.94862L12.1773 4.77135C14.4244 2.52427 18.0676 2.52427 20.3147 4.77134C22.5618 7.01842 22.5618 10.6616 20.3147 12.9087L13.591 19.6324C12.7123 20.5111 11.2877 20.5111 10.409 19.6324L3.6853 12.9086C1.43823 10.6615 1.43823 7.01831 3.6853 4.77124C5.93237 2.52417 9.5756 2.52417 11.8227 4.77124ZM10.762 5.8319C9.10073 4.17062 6.40725 4.17062 4.74596 5.8319C3.08468 7.49319 3.08468 10.1867 4.74596 11.848L11.4697 18.5718C11.7625 18.8647 12.2374 18.8647 12.5303 18.5718L19.254 11.8481C20.9153 10.1868 20.9153 7.49329 19.254 5.83201C17.5927 4.17072 14.8993 4.17072 13.238 5.83201L12.5304 6.53961C12.3897 6.68026 12.199 6.75928 12 6.75928C11.8011 6.75928 11.6104 6.68026 11.4697 6.53961L10.762 5.8319Z" fill="#ff0000"/>
                                    </svg>
                                </a>';
                        }else if(isset($_SESSION['login'])){
                            echo ' <a href="javascript:add_to_favourites('."'".$_GET['item']."'".')" class="btn btn-primary me-2" id="'.$_GET['item'].'">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8227 4.77124L12 4.94862L12.1773 4.77135C14.4244 2.52427 18.0676 2.52427 20.3147 4.77134C22.5618 7.01842 22.5618 10.6616 20.3147 12.9087L13.591 19.6324C12.7123 20.5111 11.2877 20.5111 10.409 19.6324L3.6853 12.9086C1.43823 10.6615 1.43823 7.01831 3.6853 4.77124C5.93237 2.52417 9.5756 2.52417 11.8227 4.77124ZM10.762 5.8319C9.10073 4.17062 6.40725 4.17062 4.74596 5.8319C3.08468 7.49319 3.08468 10.1867 4.74596 11.848L11.4697 18.5718C11.7625 18.8647 12.2374 18.8647 12.5303 18.5718L19.254 11.8481C20.9153 10.1868 20.9153 7.49329 19.254 5.83201C17.5927 4.17072 14.8993 4.17072 13.238 5.83201L12.5304 6.53961C12.3897 6.68026 12.199 6.75928 12 6.75928C11.8011 6.75928 11.6104 6.68026 11.4697 6.53961L10.762 5.8319Z" fill="#ffffff"/>
                                    </svg>
                                </a>';
                        }
                        echo'
                        <a href="javascript:add_to_cart('."'".$_GET['item']."'".')" class="btn btn-outline-light">Dodaj do koszyka</a>
                        ';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sekcja opinii -->
    <div class="container mt-2 mb-3">
        <h3 class="mb-4">Opinie o produkcie</h3>
        <?php 
        $data = [
            'id' => $item,
        ];
        try {
        $q = $pdo->prepare("SELECT * FROM reviews WHERE item_id = :id");
        $q->execute($data);

        }catch (PDOException $e) {
            echo 'Nie udało się odczytać danych z bazy';
            //exit();
        }

        foreach($q as $row){
            $i++;
            echo '
            <div class="bg-dark p-4 rounded mt-3">
            <p><strong>'.$row['name'].' '.$row['surname'].':</strong> '.$row['description'].'</p>
            <p><strong>Ocena:</strong>';
            for ($s=0;$s<$row['rating'];$s++){
                echo'★';
            }
            for ($s=0;$s<5-$row['rating'];$s++){
                echo'☆';
            }
            echo '</p></div>
            ';
        }
        ?>
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