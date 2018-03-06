<?php
include("header.php");
?>
<br><h4>Report erstellen</h4>

<style>
    #waehle_modul{
        display:none;
    }

    report label{
        padding: 0%;
    }
</style>

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
echo "<li>Erstmal testen</li>";
echo "</ul>";
echo "</div><br>";


$host = "127.0.0.1";
$port = 3306;
$user = "web171";
$password = "s5TZ.MZqEBuD";
$dbname = "web171db";
$socket = "";
$con = mysqli_connect($host, $user, $password, $dbname, $port, $socket);
?>

<form action="reporting.php" method="post">
    <report>
        <label for="semester"><b>Semester:</b></label>
        <select name="semester" id="semester" class="form-control"  onchange="showModul(this.value)">   
            <option value="">Semester wählen:</option>   

            <?php
            mysqli_select_db($con, "web171db");
            $sql1 = "SELECT semester FROM modul group by semester";
            $result2 = mysqli_query($con, $sql1);
            while ($row = mysqli_fetch_array($result2)) {
                echo "<option value='" . $row['semester'] . "'>" . $row['semester'] . "<optionn>";
            }
            mysqli_close($con);
            ?>
        </select>
        <br>
        <!-- Wird angezeigt, wenn noch kein Semester gewählt wurde -->
        <div style="color: red;" id="waehle_semester">Wähle ein Semester aus.</div>
        <!-- Wenn das Semester gewählt wurde, erscheinen die dazugehörigen Module -->
        <div id="showModul"></div><br>
        <!-- Wenn noch kein Modul gewählt wurde, erschein diese Meldung -->
        <!--<div style="color: red;"   id="waehle_modul">Wähle ein Modul aus.</div> -->
        <!-- Wenn ein Modul gewählt wurde, erscheinen die dazugehröigen Themen -->
        <br>
        <input type="submit" name="report" class="btn btn-primary" value="Report"/>
    </report>
</form>
      
<br><br>


<?php
include 'navi.php';
include("footer.php");
?>