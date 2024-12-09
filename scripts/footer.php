<footer style="background-color: white;">
    <div class="container p-4 pb-2">
      <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
          <h5 class="mb-3" style="letter-spacing: 2px; color: #7f4722;">sklep</h5>
          <ul class="list-unstyled mb-0">
            <li class="mb-1">
              <a href="https://chalimoniukmikolaj.infinityfreeapp.com/" style="color: #4f4f4f;">strona główna</a>
            </li>
            <li class="mb-1">
              <a href="https://chalimoniukmikolaj.infinityfreeapp.com/katalog/" style="color: #4f4f4f;">katalog</a>
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
            <?php
            try {
                $qs = $pdo->prepare("SELECT * FROM info_sites");
                $qs->execute();
            }catch (PDOException $e) {
                echo 'Nie udało się odczytać danych z bazy';
                //exit();
            }
            foreach($qs as $site){
              echo'
              <li class="mb-1">
              <a href="https://chalimoniukmikolaj.infinityfreeapp.com/informacje/?id='.$site['site_id'].'" style="color: #4f4f4f;">'.$site['header'].'</a>
              </li>
              ';
            }
            ?>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <h5 class="mb-3" style="letter-spacing: 2px; color: #7f4722;">konto</h5>
          <ul class="list-unstyled mb-0">
            <li class="mb-1">
              <a href="https://chalimoniukmikolaj.infinityfreeapp.com/konto/" style="color: #4f4f4f;">konto</a>
            </li>
            <li class="mb-1">
              <a href="https://chalimoniukmikolaj.infinityfreeapp.com/konto/ulubione/" style="color: #4f4f4f;">ulubione</a>
            </li>
            <li class="mb-1">
              <a href="https://chalimoniukmikolaj.infinityfreeapp.com/konto/zamowienia/" style="color: #4f4f4f;">zamówienia</a>
            </li>
            <li class="mb-1">
              <a href="https://chalimoniukmikolaj.infinityfreeapp.com/koszyk/" style="color: #4f4f4f;">koszyk</a>
            </li>
            <li class="mb-1">
              <a href="https://chalimoniukmikolaj.infinityfreeapp.com/konto/dane/" style="color: #4f4f4f;">dane</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2); color:black">
      © 2024 Mikołaj Chalimoniuk Grzegorz Komar:
      <a class="text-dark" href="https://github.com/Jettii04/sklep_internetowy">github.com</a>
    </div>
</footer>