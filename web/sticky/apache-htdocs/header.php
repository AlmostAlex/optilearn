<?php 
    session_start(); 
 ?>
<!DOCTYPE html>   
<html lang="de">
    <head>        
        <title>Georg-August-Universität Göttingen</title>                 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <!--Bootstrap Für das Layout benötigt -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">       
    
        <!-- Für die Slides beim Kurs hochladen-->
        <!--<script src="https://code.jquery.com/jquery-2.2.4.js"  integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>     
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><!-- jQuery library -->        
                  
        <!-- DATEPICKER! -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!-- DATEPICKER ENDE -->
                
        <!-- Pop-Over von Bootstraps -->        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>   
       
        <!-- Zur Nutzung von Icons -->
       <!--  <link rel="icon" href="http://getbootstrap.com/docs/3.3/favicon.ico"> --> <!-- Zur Anzeige der Icons -->
        <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">    

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>
        
   
        <!-- Eigene CSS u.a Verwaltungsseite Buttons -->
        <link href="css/main.css" rel="stylesheet"> 
        <link href="css/verwaltung.css" rel="stylesheet">
        <link href="css/admin_bereich.css" rel="stylesheet">
        <link href="css/bewerbung_einsicht.css" rel="stylesheet">
        <link href="css/modul_uebersicht.css" rel="stylesheet">
        
        <!-- Eigene JS -->               
        <script src="js/control.js"></script>     
        <script src="js/features.js"></script>         
        <script src="js/datepicker.js"></script>
        <script src="js/checkbox.js"></script>  

    </head>
    <body>
        <div class="wrapper">
            <!-- Header-Bereich -->
            <header>
                <div class="header">
                 <div class="container">
                    <a href="https://www.uni-goettingen.de">
                        <img id="logo" src="img/GAU_Logo.png" alt="Georg-August-Universit Göttingen">
                    </a>
                     <div class="headerunter">
                         <a href="index.php">
                            <span class="headeruntertitel">Anmeldung für Abschluss- <br> und Seminararbeitsthemen</span>
                        </a>
                    </div>
                 </div>
                </div>
            </header>
        </div>
            
            <!-- Obere Navigation -->          
            <nav class="navbereich" style="background-color: #3979b5"> 
                <a href="https://www.uni-goettingen.de/de/2165.html">Wiwi-Fakultät</a>
                <a href="index.php">Informationsseite</a>
                <a href="Themen_uebersicht_student.php">Themenübersicht</a>
                <?php 
                    if(isset($_SESSION['login'])){ 
                     echo"<a href='logout.php'>Admin-Logout</a>";
                    }
                    else{
                      echo"<a href='login.php'>Admin-Login</a>";
                    }
                ?>             
            </nav>
            <!-- Rechte Navigationssleiste -->  
            <div class="container">
                <div class="row">
                    <div class="col-8">
                        <div class="content">
                            <div>
