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
<nav class="navbar navbar-expand-md navbar-dark bg-black sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Panel administarcyjny</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../">Strona główna</a>
                </li>
                <li class="nav-item dropdown d-none d-md-block">
                    <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg width="24" height="24" viewBox="0 0 25 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.4337 6.35C16.4337 8.74 14.4937 10.69 12.0937 10.69L12.0837 10.68C9.69365 10.68 7.74365 8.73 7.74365 6.34C7.74365 3.95 9.70365 2 12.0937 2C14.4837 2 16.4337 3.96 16.4337 6.35ZM14.9337 6.34C14.9337 4.78 13.6637 3.5 12.0937 3.5C10.5337 3.5 9.25365 4.78 9.25365 6.34C9.25365 7.9 10.5337 9.18 12.0937 9.18C13.6537 9.18 14.9337 7.9 14.9337 6.34Z" fill="#ffffff"/>
                        <path d="M12.0235 12.1895C14.6935 12.1895 16.7835 12.9395 18.2335 14.4195V14.4095C20.2801 16.4956 20.2739 19.2563 20.2735 19.4344L20.2735 19.4395C20.2635 19.8495 19.9335 20.1795 19.5235 20.1795H19.5135C19.0935 20.1695 18.7735 19.8295 18.7735 19.4195C18.7735 19.3695 18.7735 17.0895 17.1535 15.4495C15.9935 14.2795 14.2635 13.6795 12.0235 13.6795C9.78346 13.6795 8.05346 14.2795 6.89346 15.4495C5.27346 17.0995 5.27346 19.3995 5.27346 19.4195C5.27346 19.8295 4.94346 20.1795 4.53346 20.1795C4.17346 20.1995 3.77346 19.8595 3.77346 19.4495L3.77345 19.4448C3.77305 19.2771 3.76646 16.506 5.81346 14.4195C7.26346 12.9395 9.35346 12.1895 12.0235 12.1895Z" fill="#ffffff"/>
                        </svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="javascript:logout('')">Wyloguj</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

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
                    echo  '<a href="podstrony/" class="col-12 col-md-4" >
                        <div class="menu-big-link" style="color: black;">
                            <h4>Podstrony</h4>
                        </div>
                    </a>
                    <a href="pracownicy/" class="col-12 col-md-4" >
                        <div class="menu-big-link" style="color: black;">
                            <h4>Podstrony</h4>
                        </div>
                    </a>';
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