 <?php
require("db.php");
$semester = $_GET["semester"];
        $statement = $dbh->prepare(
        "SELECT modul_id, modulbezeichnung
        FROM modul 
        WHERE semester =?");
        $statement->bind_param('s', $semester);
        $statement->execute();
        $statement->bind_result($modul_id,$modulbezeichnung);
        $statement->store_result();
?>   
<!-- HIER KOMMT DAS WAS RAUS KOMMT KEK-->
<label for="Modul"><b>Modul:</b></label>    
<select name="modul_id" id="modul_id" class="form-control">
        <?php while($statement->fetch()){
            echo "<option value='{$modul_id}'>{$modulbezeichnung}</option>";
        } ?>
</select>
<br>

<div id="showModul"></div><br>
<button type="submit" name="report" class="btn btn-primary"> Report erstellen</button>

<!-- ENDE-->
