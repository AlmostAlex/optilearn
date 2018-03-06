<?php
include ("header_admin.php");
?>

<h2 style="margin-top: 20px;" class="card-title">Erfolgreich eingetragen!</h2>
 <div class='alert alert-success' style='margin-top: 3%; width: 90%; text-align: center; left: 5%;' role='alert'>
     <i class='fa fa-check-circle' aria-hidden='true'></i> 
     <b>Eintragung war erfolgreich!</b><br>
     Die Weiterleitung erfolgt in wenigen Sekunden. <br> 
     <img src='img/ajax-loader.gif'></div>  
<meta http-equiv='refresh' content='2; URL=/verwaltung.php'>
 
        
        
        
 <?php
include 'navis/navi_eintrag.php';
include 'footer.php';
?>