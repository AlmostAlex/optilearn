<?php
include("header.php");
require("db.php");
?>
<script>
    function showModul(str) {
        if (str == "") {
            document.getElementById("showModul").innerHTML = "";
            $("#waehle_semester").slideDown();
            $("#waehle_modul").slideUp();
            $("#showModul").slideUp();
            return;

        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                $("#showModul").hide();
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("showModul").innerHTML = this.responseText;
                    $("#waehle_semester").slideUp();
                    $("#waehle_modul").slideDown();
                    $("#showModul").slideDown();
                }
            };
            xmlhttp.open("GET", "getModul.php?semester=" + str, true);
            xmlhttp.send();
           
        }
    }
</script>

<?php
echo "<br><div style='width: 100%; margin:0%; font-size: 1.0rem;' class='verwaltungsbox'>";
echo "<h4 class='card-title'><i class='fa fa-info-circle' aria-hidden='true'></i> Informationen zum Report</h4>";
echo "<ul>";
echo "<li>Wählen Sie zunächst ein Semester aus.</li>";
echo "<li>Wählen sie anschließend ein Modul aus dem gewählten Semester aus.</li>";
echo "<li>Anschließend erscheinen grundlegende Informationen zum Semester und zum gewählten Modul.</li>";
echo "<li>Zusätzlich können alle Module aus dem Semester exportiert werden.</li>";
echo "</ul>";
echo "</div><br>";

$statement = $dbh->prepare("SELECT semester FROM modul group by semester");
$statement->execute();
$statement->bind_result($semester);
$statement->store_result();
?>

<form class="form_thema" style='margin-bottom:50px;' action="reporting.php" method="post">
    <report>
        <label for="semester"><b>Semester:</b></label>
        <select name="semester" id="semester" class="form-control"  onchange="showModul(this.value)">   
            <option value="">Semester wählen:</option>   
            <?php
               while($statement->fetch()){
                echo "<option value='{$semester}'>{$semester}<optionn>";
            }
            ?>
        </select>

        <br>
        <!-- Wird angezeigt, wenn noch kein Semester gewählt wurde -->
        <div style="color: red;" id="waehle_semester"><div class="well" role="alert"><i style='color: red;' class='fas fa-exclamation-triangle'></i> Wähle ein Semester aus.</div></div>
        <!-- Wenn das Semester gewählt wurde, erscheinen die dazugehörigen Module -->
        <div id="showModul">
        <div style="color: red;" id="waehle_modul"><div class="well" role="alert"><i style='color: red;' class='fas fa-exclamation-triangle'></i> Wähle ein Modul auswählen.</div></div>

            </div>
            <br>
        <br>
    </report>
    
    
</form>  


<?php
include 'navi.php';
include("footer.php");
?>