<!-- navbar -->
<nav class="navbar navbar-expand-md navbar-dark bg-black sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="">
        <img src="https://chalimoniukmikolaj.infinityfreeapp.com/assets/images/biden.jpg" style="width: 30px; height: 30px; object-fit: cover;" width="30" height="30" alt="">    
        Greg.inc</a>
        <div class="d-flex me-auto ms-auto">
            <input class="form-control me-2" type="search" name="search" placeholder="Szukaj produktów..." aria-label="Search">
            <button class="btn btn-primary" type="submit">Szukaj</button>
    </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php 
                if(isset($_SESSION['login'])){
                    if($_SESSION['admin']==1 || $_SESSION['employee']=1){
                        echo  '
                        <li class="nav-item">
                            <a class="nav-link" href="https://chalimoniukmikolaj.infinityfreeapp.com/admin">Strona główna</a>
                        </li>';
                    }
                    echo'
                        <li class="nav-item dropdown me-2">
                        <a class="nav-link" href="https://chalimoniukmikolaj.infinityfreeapp.com/konto/ulubione">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8227 4.77124L12 4.94862L12.1773 4.77135C14.4244 2.52427 18.0676 2.52427 20.3147 4.77134C22.5618 7.01842 22.5618 10.6616 20.3147 12.9087L13.591 19.6324C12.7123 20.5111 11.2877 20.5111 10.409 19.6324L3.6853 12.9086C1.43823 10.6615 1.43823 7.01831 3.6853 4.77124C5.93237 2.52417 9.5756 2.52417 11.8227 4.77124ZM10.762 5.8319C9.10073 4.17062 6.40725 4.17062 4.74596 5.8319C3.08468 7.49319 3.08468 10.1867 4.74596 11.848L11.4697 18.5718C11.7625 18.8647 12.2374 18.8647 12.5303 18.5718L19.254 11.8481C20.9153 10.1868 20.9153 7.49329 19.254 5.83201C17.5927 4.17072 14.8993 4.17072 13.238 5.83201L12.5304 6.53961C12.3897 6.68026 12.199 6.75928 12 6.75928C11.8011 6.75928 11.6104 6.68026 11.4697 6.53961L10.762 5.8319Z" fill="#ffffff"/>
                            </svg>
                        </a>
                        </li>
                        <li class="nav-item dropdown me-2">
                        <a class="nav-link" href="https://chalimoniukmikolaj.infinityfreeapp.com/koszyk/">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.31641 3.25C1.90219 3.25 1.56641 3.58579 1.56641 4C1.56641 4.41421 1.90219 4.75 2.31641 4.75H3.49696C3.87082 4.75 4.18759 5.02534 4.23965 5.39556L5.49371 14.3133C5.6499 15.424 6.60021 16.25 7.72179 16.25L18.0664 16.25C18.4806 16.25 18.8164 15.9142 18.8164 15.5C18.8164 15.0858 18.4806 14.75 18.0664 14.75L7.72179 14.75C7.34793 14.75 7.03116 14.4747 6.9791 14.1044L6.85901 13.2505H17.7114C18.6969 13.2505 19.5678 12.6091 19.8601 11.668L21.7824 5.48032C21.8531 5.25268 21.8114 5.00499 21.6701 4.81305C21.5287 4.62112 21.3045 4.50781 21.0662 4.50781H5.51677C5.14728 3.75572 4.37455 3.25 3.49696 3.25H2.31641ZM5.84051 6.00781L6.64807 11.7505H17.7114C18.0399 11.7505 18.3302 11.5367 18.4277 11.223L20.0478 6.00781H5.84051Z" fill="#ffffff"/>
                            <path d="M7.78418 17.75C6.81768 17.75 6.03418 18.5335 6.03418 19.5C6.03418 20.4665 6.81768 21.25 7.78418 21.25C8.75068 21.25 9.53428 20.4665 9.53428 19.5C9.53428 18.5335 8.75068 17.75 7.78418 17.75Z" fill="#ffffff"/>
                            <path d="M14.5703 19.5C14.5703 18.5335 15.3538 17.75 16.3203 17.75C17.2868 17.75 18.0704 18.5335 18.0704 19.5C18.0704 20.4665 17.2869 21.25 16.3204 21.25C15.3539 21.25 14.5703 20.4665 14.5703 19.5Z" fill="#ffffff"/>
                            </svg>
                        </a>
                        </li>
                        <li class="nav-item d-block d-md-none">
                            <a class="nav-link" href="https://chalimoniukmikolaj.infinityfreeapp.com/konto">Konto</a>
                        </li>
                        <li class="nav-item d-block d-md-none">
                            <a class="nav-link" href="https://chalimoniukmikolaj.infinityfreeapp.com/konto/zamowienia">Zamówienia</a>
                        </li>
                        <li class="nav-item d-block d-md-none">
                            <a class="nav-link" href="javascript:logout('.')">
                                <button class="btn btn btn-outline-secondary"  type="button">Wyloguj</button>
                            </a>
                        </li>
                        <li class="nav-item dropdown d-none d-md-block">
                            <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg width="24" height="24" viewBox="0 0 25 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.4337 6.35C16.4337 8.74 14.4937 10.69 12.0937 10.69L12.0837 10.68C9.69365 10.68 7.74365 8.73 7.74365 6.34C7.74365 3.95 9.70365 2 12.0937 2C14.4837 2 16.4337 3.96 16.4337 6.35ZM14.9337 6.34C14.9337 4.78 13.6637 3.5 12.0937 3.5C10.5337 3.5 9.25365 4.78 9.25365 6.34C9.25365 7.9 10.5337 9.18 12.0937 9.18C13.6537 9.18 14.9337 7.9 14.9337 6.34Z" fill="#ffffff"/>
                                <path d="M12.0235 12.1895C14.6935 12.1895 16.7835 12.9395 18.2335 14.4195V14.4095C20.2801 16.4956 20.2739 19.2563 20.2735 19.4344L20.2735 19.4395C20.2635 19.8495 19.9335 20.1795 19.5235 20.1795H19.5135C19.0935 20.1695 18.7735 19.8295 18.7735 19.4195C18.7735 19.3695 18.7735 17.0895 17.1535 15.4495C15.9935 14.2795 14.2635 13.6795 12.0235 13.6795C9.78346 13.6795 8.05346 14.2795 6.89346 15.4495C5.27346 17.0995 5.27346 19.3995 5.27346 19.4195C5.27346 19.8295 4.94346 20.1795 4.53346 20.1795C4.17346 20.1995 3.77346 19.8595 3.77346 19.4495L3.77345 19.4448C3.77305 19.2771 3.76646 16.506 5.81346 14.4195C7.26346 12.9395 9.35346 12.1895 12.0235 12.1895Z" fill="#ffffff"/>
                                </svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="https://chalimoniukmikolaj.infinityfreeapp.com/konto">Konto</a></li>
                                <li><a class="dropdown-item" href="https://chalimoniukmikolaj.infinityfreeapp.com/konto/zamowienia">Zamówienia</a></li>
                                <li><a class="" href="javascript:logout('.')">
                                <button class="btn btn btn-outline-secondary ms-2"  type="button">Wyloguj</button>
                                </a></li>
                            </ul>
                        </li>
                        ';
                }else{
                    echo  '
                        <li class="nav-item dropdown me-2">
                        <a class="nav-link" href="https://chalimoniukmikolaj.infinityfreeapp.com/koszyk/">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.31641 3.25C1.90219 3.25 1.56641 3.58579 1.56641 4C1.56641 4.41421 1.90219 4.75 2.31641 4.75H3.49696C3.87082 4.75 4.18759 5.02534 4.23965 5.39556L5.49371 14.3133C5.6499 15.424 6.60021 16.25 7.72179 16.25L18.0664 16.25C18.4806 16.25 18.8164 15.9142 18.8164 15.5C18.8164 15.0858 18.4806 14.75 18.0664 14.75L7.72179 14.75C7.34793 14.75 7.03116 14.4747 6.9791 14.1044L6.85901 13.2505H17.7114C18.6969 13.2505 19.5678 12.6091 19.8601 11.668L21.7824 5.48032C21.8531 5.25268 21.8114 5.00499 21.6701 4.81305C21.5287 4.62112 21.3045 4.50781 21.0662 4.50781H5.51677C5.14728 3.75572 4.37455 3.25 3.49696 3.25H2.31641ZM5.84051 6.00781L6.64807 11.7505H17.7114C18.0399 11.7505 18.3302 11.5367 18.4277 11.223L20.0478 6.00781H5.84051Z" fill="#ffffff"/>
                            <path d="M7.78418 17.75C6.81768 17.75 6.03418 18.5335 6.03418 19.5C6.03418 20.4665 6.81768 21.25 7.78418 21.25C8.75068 21.25 9.53428 20.4665 9.53428 19.5C9.53428 18.5335 8.75068 17.75 7.78418 17.75Z" fill="#ffffff"/>
                            <path d="M14.5703 19.5C14.5703 18.5335 15.3538 17.75 16.3203 17.75C17.2868 17.75 18.0704 18.5335 18.0704 19.5C18.0704 20.4665 17.2869 21.25 16.3204 21.25C15.3539 21.25 14.5703 20.4665 14.5703 19.5Z" fill="#ffffff"/>
                            </svg>
                        </a>
                        </li>
                        <button class="btn btn-outline-success me-2 d-none d-md-block" type="button" onclick="login();">Zaloguj się</button>
                        <button class="btn btn btn-outline-secondary d-none d-md-block" type="button" onclick="register();">Zarejestruj</button>
                        <li class="nav-item d-block d-md-none">
                            <a class="nav-link" href="javascript:logout('.')">
                                <button class="btn btn-outline-success" type="button" onclick="login();">Zaloguj się</button>
                            </a>
                        </li>
                        <li class="nav-item d-block d-md-none">
                            <a class="nav-link" href="javascript:logout('.')">
                                <button class="btn btn btn-outline-secondary" type="button" onclick="register();">Zarejestruj</button>
                            </a>
                        </li>
                        ';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>