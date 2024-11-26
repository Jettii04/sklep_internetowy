<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        label {
            font-weight: bold;
            margin-bottom: 12px;
        }

        body {
            background-color: #e3e3e3;
        }

        .okno {
            border-style: solid;
            border-color: #a1a1a1;
            border-width: 2px;
            background-color: white;
        }
    </style>
</head>
<body>

    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="p-4 col-12 col-md-6 col-lg-4 text-center okno rounded-3">
                <h2>Logowanie</h2>
                <br>
                <form id="loginform">
                    <div class="form-group">
                        <label  for="login">Login</label>
                        <input type="text" class="form-control mb-3" name="login" id="login" placeholder="Login" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label for="password">Hasło</label>
                        <input type="password" class="form-control mb-1" name="password" id="password" placeholder="Hasło" maxlength="50">
                        <a href="zmiana_hasla.php">Nie pamiętasz hasła?</a>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mt-3" id="login_button">Zaloguj się</button>
                    </div>
                </form>
                <hr>
                <button class="btn btn-secondary" id="register_button" onclick="window.location.assign('rejestracja.html')">Nie masz konta utwórz je!</button>
            </div>
        </div>
    </div>
    <br>
    <!-- Skrypty java script -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
	    login();
        });

        // funkcja ajax uruchamiająca plik login.php
        function login(){
        $('#loginform').on('submit',function(e){
            e.preventDefault();
            $.ajax({
                url: "../scripts/login_check.php",
                method: 'POST',
                data: {
                    login: $('#login').val(),
                    password: $('#password').val()
                }
            }).done(function( data ) {
                if(data=="login"){
                    window.location.assign('../');
                }else if(data=="admin"){
                    window.location.assign('../admin');
                }else{
                    $('#loginform').html(data);
                }
            });
        });
        }
    </script>
</body>
</html>
