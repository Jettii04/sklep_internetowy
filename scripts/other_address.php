<?php 
session_start();
if(!isset($_SESSION['otheraddress'])){
    $_SESSION['otheraddress']=0;
}
if($_SESSION['otheraddress']==0){
    echo'               
        <!-- Imię -->
        <div class="col-md-6">
            <label for="otherfirstName" class="form-label">Imię</label>
            <input type="text" class="form-control" id="otherfirstName" name="otherfirstName" placeholder="Podaj imię" required>
        </div>
        <!-- Nazwisko -->
        <div class="col-md-6">
            <label for="otherlastName" class="form-label">Nazwisko</label>
            <input type="text" class="form-control" id="otherlastName" name="otherlastName" placeholder="Podaj nazwisko" required>
        </div>
        <!-- Ulica -->
        <div class="col-md-6">
            <label for="otherroad" class="form-label">Ulica</label>
            <input type="text" class="form-control" id="otherroad" name="otherroad" placeholder="Podaj ulice" required>
        </div>
        <!-- Numer domu -->
        <div class="col-md-6">
            <label for="otherhouseNumber" class="form-label">Numer domu</label>
            <input type="text" class="form-control" id="otherhouseNumber" name="otherhouseNumber" placeholder="Podaj numer domu" required>
        </div>
        <!-- Kod pocztowy -->
        <div class="col-md-6">
            <label for="otherpostalCode" class="form-label">Kod pocztowy</label>
            <input type="text" class="form-control" id="otherpostalCode" name="otherpostalCode" placeholder="00-000" pattern="\d{2}-\d{3}" required>
        </div>
        <!-- Miejscowość -->
        <div class="col-md-6">
            <label for="othercity" class="form-label">Miejscowość</label>
            <input type="text" class="form-control" id="othercity" name="othercity" placeholder="Podaj miejscowość" required>
        </div>';
        $_SESSION['otheraddress']=1;
}else{
    echo'';
    $_SESSION['otheraddress']=0;
}

?>