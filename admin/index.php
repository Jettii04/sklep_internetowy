<?php
session_start();
if((!isset($_SESSION['admin']) || (isset($_SESSION['admin'])&&$_SESSION['admin']==0)) && (!isset($_SESSION['employee']) || (isset($_SESSION['employee'])&&$_SESSION['employee']==0))){
    header("location: ../");
}
?> 
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Panel administratora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="your-project-dir/icon-font/lineicons.css" rel="stylesheet" >
    <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet" >
    <style>
      .menu-big-link {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
            background-color: white;
            border-style: solid;
            border-width: 1px;
            border-color: #8a8a8a;
        }
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
<!-- navbar -->
<?php include("admin_navbar.php")?>

<div class="container-fluid p-0 d-flex h-100">

  <div class="bg-light flex-fill">
      <!-- Ciało storny -->
      <div class="p-4">
          
            <div class="container">
                <div class="row g-2 justify-content-center">
                    <a href="klienci" class="col-12 col-md-4">
                        <div class="menu-big-link" style="color: black;">
                            <h4>Klienci</h4>
                        </div>
                    </a>
                    <a href="zamowienia/" class="col-12 col-md-4" >
                        <div class="menu-big-link" style="color: black;">
                            <h4>Zamówienia</h4>
                        </div>
                    </a>
                    <a href="produkty/" class="col-12 col-md-4" >
                        <div class="menu-big-link" style="color: black;">
                            <h4>Produkty</h4>
                        </div>
                    </a>
                    <?php
                    if($_SESSION['admin']==1){
                    echo  '<a href="https://chalimoniukmikolaj.infinityfreeapp.com/admin/oceny/" class="col-12 col-md-4" >
                        <div class="menu-big-link" style="color: black;">
                            <h4>Oceny</h4>
                        </div>
                    </a>
                    <a href="https://chalimoniukmikolaj.infinityfreeapp.com/admin/podstrony/" class="col-12 col-md-4" >
                        <div class="menu-big-link" style="color: black;">
                            <h4>Podstrony</h4>
                        </div>
                    </a>
                    <a href="https://chalimoniukmikolaj.infinityfreeapp.com/admin/kategorie/" class="col-12 col-md-4" >
                        <div class="menu-big-link" style="color: black;">
                            <h4>Kategorie</h4>
                        </div>
                    </a>
                    <a href="https://chalimoniukmikolaj.infinityfreeapp.com/admin/pracownicy/" class="col-12 col-md-4" >
                        <div class="menu-big-link" style="color: black;">
                            <h4>Pracownicy</h4>
                        </div>
                    </a>
                    <a href="https://chalimoniukmikolaj.infinityfreeapp.com/admin/metody_dostawy/" class="col-12 col-md-4" >
                        <div class="menu-big-link" style="color: black;">
                            <h4>Metody dostawy</h4>
                        </div>
                    </a>
                    <a href="https://chalimoniukmikolaj.infinityfreeapp.com/admin/sposoby_platnosci/" class="col-12 col-md-4" >
                        <div class="menu-big-link" style="color: black;">
                            <h4>Sposoby płatności</h4>
                        </div>
                    </a>
                    <a href="https://chalimoniukmikolaj.infinityfreeapp.com/admin/statusy_zamowien/" class="col-12 col-md-4" >
                        <div class="menu-big-link" style="color: black;">
                            <h4>Statusy zamówień</h4>
                        </div>
                    </a>
                    <a href="https://chalimoniukmikolaj.infinityfreeapp.com/admin/admini/" class="col-12 col-md-4" >
                        <div class="menu-big-link" style="color: black;">
                            <h4>Admini</h4>
                        </div>
                    </a>
                    ';
                    }
                    ?>
                    <a href="javascript:logout()" class="col-12 col-md-4" style="color:red">
                        <div class="menu-big-link" style="color: red;">
                            <h4>Wyloguj</h4>
                        </div>
                    </a>
                </div>
            </div>

      </div>
  </div>
</div>

<!-- Stopka -->
<?php include("../scripts/footer.php")?>

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
    </script>
</body>
</html>