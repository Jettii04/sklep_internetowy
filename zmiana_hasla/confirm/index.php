<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['code'])){
    header("location: ../");
}
?>
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
                <h2>Zmiana hasła</h2>
                <br>
                <form id="form" method="post" action="">
                    <?php
                        if(isset($_POST['code'])){
                            if(htmlspecialchars($_POST['code'])==$_SESSION['code']){
                                header("location: ../new_password/");
                            }else{
                                echo '
                                <div class="form-group">
                                    <label  for="code">Podaj otrzymany kod</label>
                                    <input type="text" class="form-control mb-3 is-invalid" name="code" id="code" placeholder="Kod" maxlength="4">
                                    <div class="invalid-feedback mb-2" style="font-size:15px">
                                    Nieprawidłowy kod!
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="send_button">Sprawdź</button>
                                </div>
                            ';
                            }
                        }else{
                            echo '
                                <div class="form-group">
                                    <label  for="code">Podaj otrzymany kod</label>
                                    <input type="text" class="form-control mb-3" name="code" id="code" placeholder="Kod" maxlength="4">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="send_button">Sprawdź</button>
                                </div>
                            ';
                        }
                    ?>
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
	    
        });
    </script>
</body>
</html>
