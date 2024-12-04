<?php
session_start();
require_once('database.php');
$order=0;
if(isset($_SESSION['login'])){
    $data = [
        'user' => $_SESSION['login']
    ];
    // id koszyka
    try {
    $c = $pdo->prepare("SELECT cart_id FROM carts WHERE user = :user");
    $c->execute($data);
    $cart = $c->fetchColumn();
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }
    
    //id zamówienina
    try {
    $o = $pdo->query("SELECT MAX(order_id) FROM orders");
    $order = $o->fetchColumn();
    $order += 1;
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

    $data = [
        'user' => $_SESSION['login'],
        'order_status' => 1,
        'postal' => $_SESSION['Fpostal_code'],
        'city' => $_SESSION['Fcity'],
        'road' => $_SESSION['Froad'],
        'house' => $_SESSION['Fhouse_number'],
        'pay' => $_COOKIE['payment_method'],
        'deliv' => $_COOKIE['delivery_method'],
        'order_id'=> $order
    ];
    // tworzenie zamówienia
    try {
        $c = $pdo->prepare("INSERT INTO orders (order_id,user,order_status,postal_code,city,road,house_number,payment_method,delivery_method) VALUES (:order_id,:user,:order_status,:postal,:city,:road,:house,:pay,:deliv)");
        $c->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }
    
    
    $data = [
        'cart' => $cart,
    ];
    
    try {
        $items = $pdo->prepare("SELECT * FROM cart_items WHERE cart_id = :cart");
        $items->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd1';
        //exit();
    }
    
    foreach($items as $item){
        $data = [
            'item' => $item['item_id'],
            'amount' => $item['amount'],
            'order' => $order
        ];
        try {
            $items = $pdo->prepare("INSERT INTO order_items (order_id,item_id,amount) VALUES (:order,:item,:amount)");
            $items->execute($data);
        }catch (PDOException $e) {
            echo 'Wystąpił błąd2';
            //exit();
        }
    }

    $data = [
        'cart' => $cart,
    ];

    try {
    $q = $pdo->prepare("DELETE FROM cart_items WHERE cart_id = :cart");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd3';
        //exit();
    }
}else{

    //id zamówienina
    try {
        $o = $pdo->query("SELECT MAX(order_id) FROM orders");
        $order = $o->fetchColumn();
        $order += 1;
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

    $data = [
        'order_status' => 1,
        'postal' => $_SESSION['Fpostal_code'],
        'city' => $_SESSION['Fcity'],
        'road' => $_SESSION['Froad'],
        'house' => $_SESSION['Fhouse_number'],
        'pay' => $_COOKIE['payment_method'],
        'deliv' => $_COOKIE['delivery_method'],
        'order_id'=> $order
    ];
    // tworzenie zamówienia
    try {
        $c = $pdo->prepare("INSERT INTO orders (order_id,order_status,postal_code,city,road,house_number,payment_method,delivery_method) VALUES (:order_id,:order_status,:postal,:city,:road,:house,:pay,:deliv)");
        $c->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

    if(isset($_COOKIE['cart'])){
        $cart = json_decode($_COOKIE['cart'], true); 
    }else{
        $cart=[];
    }
    foreach($cart as $key=>$value){
        $data = [
            'item' => $key,
            'amount' => $value,
            'order' => $order
        ];
        try {
            $items = $pdo->prepare("INSERT INTO order_items (order_id,item_id,amount) VALUES (:order,:item,:amount)");
            $items->execute($data);
        }catch (PDOException $e) {
            echo 'Wystąpił błąd2';
            //exit();
        }
        unset($cart[$key]);
    }
    setcookie('cart', json_encode($cart), time() + (86400 * 30), "/");
}


$mailBody="";
    $data = [
        'order' => $order,
    ];
    try {
        $orders = $pdo->prepare("SELECT * FROM orders WHERE order_id=:order");
        $orders->execute($data);
    }catch (PDOException $e) {
        echo 'Nie udało się odczytać danych z bazy';
        //exit();
    }

    foreach($orders as $ord){

        $data = [
            'status_id' => $ord['order_status'],
        ];
        try {
            $stat = $pdo->prepare("SELECT name FROM order_satus WHERE status_id=:status_id");
            $stat->execute($data);
            $status = $stat ->fetchColumn();
        }catch (PDOException $e) {
            echo 'Nie udało się odczytać danych z bazy';
            //exit();
        }

        $data = [
            'method' => $ord['delivery_method'],
        ];
        try {
            $deliv = $pdo->prepare("SELECT name FROM delivery_method WHERE delivery_id=:method");
            $deliv->execute($data);
            $delivery = $deliv ->fetchColumn();
        }catch (PDOException $e) {
            echo 'Nie udało się odczytać danych z bazy';
            //exit();
        }

        $data = [
            'method' => $ord['payment_method'],
        ];
        try {
            $pay = $pdo->prepare("SELECT name FROM payment_methods WHERE payment_id=:method");
            $pay->execute($data);
            $payment = $pay ->fetchColumn();
        }catch (PDOException $e) {
            echo 'Nie udało się odczytać danych z bazy';
            //exit();
        }

        $mailBody .= '
            <div>
                <div>
                <h5>Zamówienie nr.</h5>
                '.$ord['order_id'].'
                </div>
                <div >
                <h5>Płatność</h5>
                '.$payment.'
                </div>
                <div>
                <h5>Status</h5>
                '.$status.'
                </div>
                <div >
                <h5>Dostawa</h5>
                '.$delivery.'
                </div>
                <div>
                <h5>Adres</h5>
                <p>ul.'.$ord['road'].' '.$ord['house_number'].'</p>
                <p>'.$ord['postal_code'].' '.$ord['city'].'</p>
                </div>
            </div>
        ';
        $data = [
            'order' => $ord['order_id'],
        ];
        try {
            $items = $pdo->prepare("SELECT name, items.item_id, items.price, items.main_img, order_items.amount FROM items JOIN order_items on items.item_id = order_items.item_id WHERE order_id=:order");
            $items->execute($data);
        }catch (PDOException $e) {
            echo 'Nie udało się odczytać danych z bazy';
            //exit();
        }
        $wholeprice=0;
        foreach($items as $item){ 

            $priceW = $item['price']*$item['amount'];
            
            $wholeprice+=$priceW;

            $mailBody .= '
            <div>
            <div>
                    <div>
                        <a href="https://chalimoniukmikolaj.infinityfreeapp.com/produkt/?item='.$item['item_id'].'"><h4>'.$item['name'].'</h4></a>
                    </div>
                    <div>
                        <h5>'.$item['price'].' zł</h5>
                    </div>
                    <div>
                            <h5>szt. '.$item['amount'].'</h5>
                    </div>
                    <div>
                        <h5>'.$priceW.' zł</h5>
                    </div>
            </div>
            </div>';
        }
        $mailBody .= '
        <div">
        <hr style=" border: 3px solid black;">
        <h4 >Łącznie '.$wholeprice.' zł</h4>
        </div>
        </div>';
    }



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->CharSet="UTF-8";
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'mireknwindalinkau@gmail.com';                     //SMTP username
    $mail->Password   = 'hwcezsncdnrzfdbn';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->addAddress($_SESSION['Femail']);


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Potwierdzenie zamówienia';
    $mail->Body    = $mailBody;
    $mail->AltBody = '';

    echo 'Message has been sent';
    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
header("Location: ../");
exit;

?>