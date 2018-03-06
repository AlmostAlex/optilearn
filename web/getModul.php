<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>  

<?php
require("db.php");
$semester = $_GET["semester"];

        $statement = $dbh->prepare(
        "SELECT modulbezeichnung
        FROM modul 
        WHERE semester =?");
        $statement->bind_param('s', $semester);
        $statement->execute();
        $statement->bind_result($modulbezeichnung);
        $statement->store_result();
?>
    
<!-- HIER KOMMT DAS WAS RAUS KOMMT KEK-->
<label for="Modul"><b>Modul:</b></label>    
<select name="modulbezeichnung" id="modulbezeichnung" class="form-control">
<option value="">Modul wählen:</option> 
        <?php while($statement->fetch()){
            echo "<option value='{$modulbezeichnung}'>{$modulbezeichnung}</option>";
        } ?>
</select>

<div id="showModul"></div>

<!-- ENDE-->


</body>
</html>