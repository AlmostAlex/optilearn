<?php
include('header.php');
require("controller/index_controller.php");
require("db.php");
?>


<div class="title">
    <span class="byline">Fragen und Antworten</span>
</div> 

<answer>
    <ul>
        <li>
            <div class="panel-heading"><a style='border-top: 1px dotted #000000;' class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1">Results</a></div>
        </li>      
        <div id="collapse1" class="panel-collapse collapse">
            <div class="panel-body">
                ongue rutnt a lacus atongue rutnt a lacus at urnantum nibh augue praesent a lacus at urna congue rutntum nibh augue praesent a lacus at urna congue rutntum n
                ibh augue praesent a lacus at urna congue rutntum nibh augue praesenongue rutnt a lacus at urnantum nibh augue praesent a lacus at urna congue rutntum nibh augue praesent a lacus at urna congue rutntum n
                ibh augue praesent a lacus at urna congue rutntum nibh augue praesen urnantum nibh augue praesent
            </div>
        </div>  

        <li>
            <div class="panel-heading"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2">Results</a></div>
        </li>      
        <div id="collapse2" class="panel-collapse collapse">
            <div class="panel-body">
                ongue rutnt a lacus atongue rutnt a lacus at urnantum nibh augue praesent a lacus at urna congue rutntum nibh augue praesent a lacus at urna congue rutntum n
                ibh augue praesent a lacus at urna congue rutntum nibh augue praesenongue rutnt a lacus at urnantum nibh augue praesent a lacus at urna congue rutntum nibh augue praesent a lacus at urna congue rutntum n
                ibh augue praesent a lacus at urna congue rutntum nibh augue praesen urnantum nibh augue praesent
            </div>
        </div> 
    </ul>
</answer>

<script>
function showBezirk(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        $("#waehle_stadt").slideDown();
        $("#bezirk").slideUp();
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
                $("#waehle_stadt").slideUp();
                $("#bezirk").slideDown();
            }
        };
        xmlhttp.open("GET","getBezirk.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
<br><br>
<center><div class="title">
        <h2>Optilearn - Login-System</h2>
        <span class="byline">Als registrierter User oder Free-User!</span>
    </div> 
</center>

<?php
 $control = new index_controller();
 $control->free_user_formular();
  ?>

<br><br><br>

<?php
include('navi.php');
include('footer.php');
?>