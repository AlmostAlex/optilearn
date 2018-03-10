<?php
include('header.php');
?>

<style>
#process-box-1{
  width: 630px;
  height: 270px;
  background: rgb(245, 245, 245);
  margin-left: 220px;
  border-radius: 5px;
}
.process-box-number {
  width: 100px;
  border-radius: 3px;
  height: 100px;
  margin-left: -10px;
  background: rgb(250, 194, 0);
  color: white;
  z-index: 99999;
}
.process-box-number p {
  font-size: 45px;
  font-family: 'Montserrat', sans-serif;
  padding-top: 21px;
  padding-left: 20px;
}
.triangle-process {
  margin-left: -10px;
  width: 0;
  height: 0;
  border-top: 10px solid rgb(173, 136, 0);
  border-left: 10px solid transparent;
  margin-top: -1px;
  z-index: -99999;
}
.process-text-head {
  margin-top: -115px;
  padding-top: 20px;
  padding-left: 110px;
  color: rgb(51, 51, 51);
  font-size: 30px;
  font-weight: 600;
  font-family: 'Montserrat', sans-serif;
}
.process-text-desc {
  padding-top: 15px;
  padding-left: 110px;
  padding-right: 40px;
  font-size: 15px;
  font-weight: 400;
  font-family: 'Montserrat', sans-serif;
  letter-spacing: 0px;
  line-height: 23px;
}
</style>
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
		
<br><br>
<div class="title">
    <h2>Optilearn - Login-System</h2>
    <span class="byline">Als registrierter User oder Free-User!</span>
</div> 

  <div id="process-box-1">
    <div class="process-box-number">
    <p>01.</p>
    </div>
    <div class="triangle-process"></div>
    <div class="process-text-head">Free-User</div>
    <div class="process-text-desc">We're all about getting it done on time and to client satisfaction. From start to finish we have a positive and enthusiastic attitude. 
        We have the experience and dedication to finish all our projects on time giving all our clients peace of mind.<br><a href="#" class="button">Etiam posuere</a></div>
  </div>



</div>

<?php
include('navi.php');
include('footer.php');
?>