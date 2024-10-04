<?php
session_start();
if(!isset($_SESSION['admin']) || (isset($_SESSION['admin'])&&$_SESSION['admin']==0)){
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <title>Panel administratora</title>
    </head>
    <body>
        <h1>Panel administratora</h1>
        <?php
        if(isset($_SESSION['login'])){
        echo "Zalogowany urzytkownik:".$_SESSION['login'];
        echo '<br><button id="logout" type="button">Wyloguj</button> ';
        }else{
          echo  '<a href="login.html">Zaloguj się</a><br>';
          echo  '<a href="rejestracja.html">Jeżeli nie masz konta utwórz je!</a>';
        }
        ?>
    </body>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
	    logout();
        });

        // funkcja ajax uruchamiająca plik logout.php
        function logout(){
        $('#logout').on('click',function(e){
            e.preventDefault();
            $.ajax({
                url: "logout.php",
            }).done(function( data ) {
                location.reload();
            });
        });
        }
    </script>
</html>