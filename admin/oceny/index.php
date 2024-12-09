<?php
session_start();
if(!isset($_SESSION['admin']) || (isset($_SESSION['admin'])&&$_SESSION['admin']==0)){
    header("location: https://chalimoniukmikolaj.infinityfreeapp.com/");
}
require_once("../../scripts/database.php");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Oceny</title>
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
<?php include("../admin_navbar.php")?>

<div class="container-fluid p-0 d-flex h-100">

    <!-- Sidebar -->
    <?php include("../admin_sidebar.php")?>

    <div class="bg-light flex-fill table-responsive">
        <!-- Sidebar po zmniejszeniu -->
        <?php include("../admin_sidebartop.php")?>
        
        <!-- Ciało storny -->
        <div class="p-4">
            <form method="get" action="">
            <div style="color: black">
            <h2>Oceny</h2> 
            <div class="d-flex me-auto ms-auto">
            <input class="form-control me-2" type="search" name="search" placeholder="Szukaj wedłóg nazwy..." aria-label="Search" value="<?php if(isset($_GET['search'])){ echo $_GET['search'];}?>">
            <button class="btn btn-primary" type="submit">Szukaj</button>  
            <a href="add/" class="btn btn-success ms-3">Dodaj</a> 
            </div>
            <hr>
            </div>

            <table class="table">
            <thead>
                <tr>
                <th scope="col">Id</th>
                <th scope="col">Id Produktu</th>
                <th scope="col">Imię</th>
                <th scope="col">Nazwisko</th>
                <th scope="col">Ocena</th>
                <th scope="col">Opis</th>
                <th scope="col"></th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            
            <?php

                $noi = $pdo->prepare("SELECT COUNT(*) FROM reviews");
                $noi->execute();
                $nOfitems = $noi->fetchColumn();

                $nOnpage=20;

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

                try {
                    $categories = $pdo->prepare("SELECT * FROM reviews where name like '%".$_GET['search']."%' ORDER BY review_id ASC LIMIT ".$nOnpage." OFFSET ".$offset);
                    $categories->execute();
                }catch (PDOException $e) {
                    echo 'Nie udało się odczytać danych z bazy';
                    //exit();
                }

                foreach($categories as $category){
                    echo '
                        <tr>
                            <td>'.$category['review_id'].'</td>
                            <td>'.$category['item_id'].'</td>
                            <td>'.$category['name'].'</td>
                            <td>'.$category['surname'].'</td>
                            <td>'.$category['rating'].'</td>
                            <td>'.$category['description'].'</td>
                            <td>
                                <a href="javascript:edit('."'".$category['review_id']."'".')">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="#343C54" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.8749 2.51272C20.1915 1.8293 19.0835 1.8293 18.4001 2.51272L13.2418 7.67095C12.879 8.03379 12.6511 8.50974 12.5959 9.0199L12.4069 10.7668C12.3824 10.9926 12.4616 11.2173 12.6222 11.3778C12.7827 11.5384 13.0074 11.6176 13.2332 11.5931L14.9801 11.4041C15.4903 11.3489 15.9662 11.121 16.3291 10.7582L21.4873 5.59994C22.1707 4.91652 22.1707 3.80848 21.4873 3.12506L20.8749 2.51272ZM18.5981 4.43601L19.564 5.40191L15.2684 9.69751C15.1474 9.81846 14.9888 9.89443 14.8187 9.91283L13.9984 10.0016L14.0872 9.18126C14.1056 9.01121 14.1815 8.85256 14.3025 8.73161L18.5981 4.43601Z" fill="#343C54"/>
                                    <path d="M5.5 3.25H15.5411L14.0411 4.75H5.5C5.08579 4.75 4.75 5.08579 4.75 5.5V18.5C4.75 18.9142 5.08579 19.25 5.5 19.25H18.5C18.9142 19.25 19.25 18.9142 19.25 18.5V9.95823L20.75 8.45823V18.5C20.75 19.7426 19.7426 20.75 18.5 20.75H5.5C4.25736 20.75 3.25 19.7426 3.25 18.5V5.5C3.25 4.25736 4.25736 3.25 5.5 3.25Z" fill="#343C54"/>
                                    </svg>
                                </a>
                            </td>
                            <td>
                            <a href="javascript:remove('."'".$category['review_id']."'".')">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="#373737" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                <path d="M14.7223 12.7585C14.7426 12.3448 14.4237 11.9929 14.01 11.9726C13.5963 11.9522 13.2444 12.2711 13.2241 12.6848L12.9999 17.2415C12.9796 17.6552 13.2985 18.0071 13.7122 18.0274C14.1259 18.0478 14.4778 17.7289 14.4981 17.3152L14.7223 12.7585Z" fill="#373737"/>
                                <path d="M9.98802 11.9726C9.5743 11.9929 9.25542 12.3448 9.27577 12.7585L9.49993 17.3152C9.52028 17.7289 9.87216 18.0478 10.2859 18.0274C10.6996 18.0071 11.0185 17.6552 10.9981 17.2415L10.774 12.6848C10.7536 12.2711 10.4017 11.9522 9.98802 11.9726Z" fill="#373737"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.249 2C9.00638 2 7.99902 3.00736 7.99902 4.25V5H5.5C4.25736 5 3.25 6.00736 3.25 7.25C3.25 8.28958 3.95503 9.16449 4.91303 9.42267L5.54076 19.8848C5.61205 21.0729 6.59642 22 7.78672 22H16.2113C17.4016 22 18.386 21.0729 18.4573 19.8848L19.085 9.42267C20.043 9.16449 20.748 8.28958 20.748 7.25C20.748 6.00736 19.7407 5 18.498 5H15.999V4.25C15.999 3.00736 14.9917 2 13.749 2H10.249ZM14.499 5V4.25C14.499 3.83579 14.1632 3.5 13.749 3.5H10.249C9.83481 3.5 9.49902 3.83579 9.49902 4.25V5H14.499ZM5.5 6.5C5.08579 6.5 4.75 6.83579 4.75 7.25C4.75 7.66421 5.08579 8 5.5 8H18.498C18.9123 8 19.248 7.66421 19.248 7.25C19.248 6.83579 18.9123 6.5 18.498 6.5H5.5ZM6.42037 9.5H17.5777L16.96 19.7949C16.9362 20.191 16.6081 20.5 16.2113 20.5H7.78672C7.38995 20.5 7.06183 20.191 7.03807 19.7949L6.42037 9.5Z" fill="#373737"/>
                                </svg>
                            </a>
                            </td>
                        </tr>
                    ';
                }
            ?>

            </tbody>
            </table>
        
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
                url: "../../scripts/remove_category.php",
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