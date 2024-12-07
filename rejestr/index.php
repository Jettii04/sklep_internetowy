<!DOCTYPE html>
<html lang="pl">
    <meta charset="UTF-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Rejestracja</title>
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
<head>
</head>
<body>
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="p-4 col-12 col-md-6 col-lg-4 text-center okno rounded-3">
                <h2>Załóż konto</h2>
                <form id="registerform">
                    <div class="form-group">
                        <label  for="login">Login</label>
                        <input type="text" class="form-control mb-3" name="login" id="login" placeholder="Login" pattern="[0-9a-z\-_]{2,30}" title="Login musi zawierać do 30 zanków, oraz może zawierać tylko a-z 0-9 i znaków _ -" maxlength="30" required>
                    </div>
                    <div class="form-group">
                        <label  for="name">Imię</label>
                        <input type="text" class="form-control mb-3" name="name" id="name" placeholder="Imię" pattern="[A-ZÀ-ÿA-ZŻŹĆĄŚĘŁÓŃ][\-,a-z.'żźćńółęąś]+" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <label  for="surname">Nazwisko</label>
                        <input type="text" class="form-control mb-3" name="surname" id="surname" placeholder="Nazwisko" pattern="([A-Za-zÀ-ÿA-ZŻŹĆĄŚĘŁÓŃżźćńółęąś][\-,a-z. 'żźćńółęąś]+[ ]*)+[a-zżźćńółęąś]" maxlength="60" required>
                    </div>
                    <div class="form-group">
                        <label  for="email">Email</label>
                        <input type="email" class="form-control mb-3" name="email" id="email" placeholder="Email" pattern="^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Hasło</label>
                        <input type="password" class="form-control mb-3" name="password" id="password" placeholder="Hasło" pattern="[A-Za-z0-9\-\\?\/.>,<\|;:\]\[\}\{+=_\-\)\(*&^%$#@!]{8,50}" title="Hasło musi mieć od 8 do 50 zanków, oraz może zawierać tylko A-Z a-z 0-9 i znaki ?\/><.,:;}{][+=_-)(*&^%$#@!" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <label for="repeat_password">Powtórz hasło</label>
                        <input type="password" class="form-control mb-3" name="repeat_password" id="repeat_password" placeholder="Hasło" pattern="[A-Za-z0-9\-\\?\/.>,<\|;:\]\[\}\{+=_\-\)\(*&^%$#@!]{8,50}" title="Hasło musi mieć od 8 do 50 zanków, oraz może zawierać tylko A-Z a-z 0-9 i znaki ?\/><.,:;}{][+=_-)(*&^%$#@!" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" id="create_button" value="Utwórz konto">
                    </div>
                </form>
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
	    rejestracja();
        });

        // funkcja ajax uruchamiająca plik rejestracja_check.php
        function rejestracja(){
        $('#registerform').on('submit',function(e){
            e.preventDefault();
            $.ajax({
                url: "../scripts/rejestracja_check.php",
                method: 'POST',
                data: {
                    login: $('#login').val(),
                    name: $('#name').val(),
                    surname: $('#surname').val(),
                    email: $('#email').val(),
                    password:$('#password').val(),
                    repeatPassword:$('#repeat_password').val()
                }
            }).done(function( data ) {
                if(data=="register"){
                    window.location.assign('../');
                }else{
                    
                    $('#registerform').html(data);
                }
                
            });
        });
        }
    </script>
</body>
</html>
