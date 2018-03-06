<?php 
session_start(); ?>
<!DOCTYPE html>   
<html lang="de">
    <head>        
        <title>Georg-August-Universität Göttingen</title>                 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
         <!-- DATEPICKER! -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <!-- DATEPICKER ENDE -->

        <!--Bootstrap Für das Layout benötigt -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">       
        <!-- Für Popover & COllapse-->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>              
        <!-- Für die Slides beim Kurs hochladen-->
        <script src="https://code.jquery.com/jquery-2.2.4.js"  integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
        <!-- Für die Slides beim Hochladen der Kurse/Themen-->     
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><!-- jQuery library -->        
                  
        <!-- DATEPICKER! -->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                <!-- DATEPICKER ENDE -->
                
        <!-- Pop-Over von Bootstraps -->        
        <link href="css/main.css" rel="stylesheet"> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>   
        <!-- Eigene JS -->               
        <script src="js/control.js"></script> 
        
    
        <!-- Zur Nutzung von Icons -->
        <link rel="icon" href="http://getbootstrap.com/docs/3.3/favicon.ico"> <!-- Zur Anzeige der Icons -->
        <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">                
        <!-- Eigene CSS u.a Verwaltungsseite Buttons -->
        <link href="css/verwaltung.css" rel="stylesheet">
        <link href="css/admin_bereich.css" rel="stylesheet">
        <script src="js/features.js"></script>   
        
        <script src="js/datepicker.js"></script>   


    </head>
    <body>
        <div class="wrapper">
            <!-- Header-Bereich -->
            <header>
          <!--     <div class="header">
          <!--      <div class="container"
                         <a href="https://www.uni-goettingen.de/"><img id="logo" src="img/GAU.png" alt="Georg-August-Universität Göttingen"></a>
                    </div>
               </div>
                 -->
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
                <a href="#">Aktuelles</a>
                <a href="#">Die Fakultät</a>
                <a href="#">Forschung</a>
                <a href="#">International</a>
                <a href="#">Studierende</a>
                <a href="#">Studieninteressierte</a>
                <a href="#">Karriere und Alumni</a>       
                <a href="login.php">Logout</a>
            </nav>
            <!-- Rechte Navigationssleiste -->  
            <div class="container">
                <div class="row">
                    <div class="col-8">
                        <div class="content">
                            <div>
