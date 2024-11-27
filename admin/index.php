<?php
session_start();
if(!isset($_SESSION['admin']) || (isset($_SESSION['admin'])&&$_SESSION['admin']==0)){
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
                    <a class="nav-link" href="../">Stroa główna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">O nas</a>
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
  <!-- Sidebar -->
  <div id="bdSidebar" class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white offcanvas-md offcanvas-start">
      <ul class="mynav nav nav-pills flex-column mb-auto">
          <li class="nav-item mb-1">
              <a href="" class="nav-link">
                  Dodaj Podstronę
              </a>
          </li>

          <li class="nav-item mb-1">
              <a href="" class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#settings" aria-expanded="false" aria-controls="settings">
                  <span class="topic">Settings </span>
              </a>
              <ul id="settings" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                  <li class="sidebar-item">
                      <a href="" class="nav-link">
                          <span class=""> Login</span>
                      </a>
                  </li>
                  <li class="sidebar-item">
                      <a href="" class="nav-link">
                          <span class="">Register</span>
                      </a>
                  </li>
                  <li class="sidebar-item">
                      <a href="" class="nav-link">
                          <span class="">Log Out</span>
                      </a>
                  </li>
              </ul>
          </li>
      </ul>
      <hr>
      <div class="d-flex">
          <span>
              <h6 class="mt-1 mb-0">
                      
                  </h6>
          </span>
      </div>
  </div>

  <div class="bg-light flex-fill">
      <!-- Sidebar po zmniejszeniu -->
      <div class="p-2 d-md-none d-flex text-white bg-dark">
          <a href="#" class="text-white" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar">
              <i class="fa-solid fa-bars"></i>
          </a>
          <span class="ms-3">TEST</span>
      </div>
      <!-- Ciało storny -->
      <div class="p-4">
          <div class="row">
              <div class="col" id="main">
                  <hr>
                  <p>
                    <h1></h1>
                  </p>
              </div>
          </div>
      </div>
  </div>
</div>

<!-- Stopka -->
<footer style="background-color: white;">
    <div class="container p-4 pb-2">
      <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
          <h5 class="mb-3" style="letter-spacing: 2px; color: #7f4722;">sklep</h5>
          <ul class="list-unstyled mb-0">
            <li class="mb-1">
              <a href="" style="color: #4f4f4f;">strona główna</a>
            </li>
            <li class="mb-1">
              <a href="" style="color: #4f4f4f;">katalog</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <h5 class="mb-3" style="letter-spacing: 2px; color: #7f4722;">social media</h5>
          <ul class="list-unstyled mb-0">
            <li class="mb-1">
              <a href="" style="color: #4f4f4f;">youtube</a>
            </li>
            <li class="mb-1">
              <a href="" style="color: #4f4f4f;">instagram</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <h5 class="mb-3" style="letter-spacing: 2px; color: #7f4722;">firma</h5>
          <ul class="list-unstyled mb-0">
            <li class="mb-1">
              <a href="" style="color: #4f4f4f;">o nas</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <h5 class="mb-3" style="letter-spacing: 2px; color: #7f4722;">konto</h5>
          <ul class="list-unstyled mb-0">
            <li class="mb-1">
              <a href="" style="color: #4f4f4f;">zamówienia</a>
            </li>
            <li class="mb-1">
              <a href="" style="color: #4f4f4f;">koszyk</a>
            </li>
            <li class="mb-1">
              <a href="" style="color: #4f4f4f;">dane</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2024 Mikołaj Chalimoniuk Grzegorz Komar:
      <a class="text-dark" href="https://github.com/Jettii04/sklep_internetowy">github.com</a>
    </div>
  </footer>

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