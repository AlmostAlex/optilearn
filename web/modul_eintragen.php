<?php
include ("header.php");
include ("Controllers/modul_controller.php");
?>
<br><br>
<div class="verwaltungsbox" style='width: 100%; margin:0%; font-size: 1.0rem;'>
    <h4 class='card-title'><i class="fa fa-info-circle" aria-hidden="true"></i>  Zum Eintrag eines Moduls</h4>
    Um erfolgreich einen Kurs anzulegen, ist es zunächst erforderlich, dass:<br>
    <ul>
    <li>  alle <b>Pflichtfelder</b> <red style="color: red">*</red> ausgefüllt werden,</li>
    <li>  eine <b>Kategorie</b> gewählt wird,</li>
    <li>  und ein <b>Verfahren</b> gewählt wird.</li>
    <li>  beim Verfahren <b>"Belegwunsch"</b>, sind mindestens <b>drei</b> Themen erforderlich.</li>
   
    <li>Bei Abschlussarbeiten geben Sie bitte zudem Ihre Professur an und geben Sie an, ob die Arbeit für Bachelor-, Masterstudiengänge oder beides verfügbar ist.</li> </ul>  
    Es können zum Kurs beliebig viele Themen angelegt werden. Es besteht zudem die Möglichkeit,
    nachträglich Themen zu eingetragenen Kursen hochzuladen. <a href="/mt_verwaltung.php"><i class="fa fa-arrow-right"></i>Themen eintragen</a>
</div>
<br>
       <?php
if (isset($_POST["modul_eintrag1"])) {
    $modul = new modul_controller();
    $modul->ModulEintragung();
} else if (isset($_POST["modul_eintrag2"])) {
    $modul = new modul_controller();
    $modul->ModulEintragung();
}
?> 

<div style="margin-bottom: 100px; border-top: 4px solid #3979b5;" class="form_thema">
    <form method="post">
        <feld>
            <table style="width:100%;"> 
                <div class="form_ueberschrift">Allgemeine Informationen</div><br>
                <tr>
                    <td><label for="Kategorie"><b>Kategorie:</b><red style="color: red" >*</red></label></td>
                    <td><input type="radio" name="Kategorie" value="Seminararbeit" class="Kategorie" />Seminararbeit</input> </td>
                    <td><input type="radio" name="Kategorie" value="Abschlussarbeit" class="Kategorie" />Abschlussarbeit</input></td>
                    <td></td>
                </tr>
            </table>
            <table>   
                <tr>
                    <td style="width: 37%"><label for="Modul"><b>Modul:</b><red style="color: red">*</red></label></td>
                    <td><input type="text" style="width: 400px;" class="form-control" id="bezeichnung" placeholder="Bezeichnung der Veranstaltung" name="Bezeichnung" required> </td>
                    <td></td>
                </tr> 
            </table>
            <table>      
                <tr>
                    <td style="width: 37%"><label for="Termine"><b>Bewerbungsfristen:</b><red style="color: red">*</red></label></td>
                    <td><input type="text" style="width: 200px;" class="form-control" name="Start"  placeholder="TT-MM-JJJJ" id="datepicker_Start" required></td>
                    <td><input type="text" style="width: 200px;" class="form-control" name="Ende"  placeholder="TT-MM-JJJJ" id="datepicker_Ende" required></td>
                </tr>   
            </table>
            <table>      
                <tr>
                    <td style="width: 37%"><label for="Semester"><b>Semester:</b><red style="color: red">*</red></label></td>
                    <td> <select  style="width: 200px;" class="form-control" name="Semester" id="Semester" required>
                            <option value="SoSe">SoSe</option>
                            <option value="WiSe">WiSe</option>
                        </select> </td>
                    <td><input type="text" style="width: 200px;" class="form-control" name="Semester_Jahr" required></td>
                </tr>   
            </table>
            <table>
                <tr>
                    <td style="width: 37%"><label for="bevStudiengang"><b>Bevorzugter Studiengang:</b></label></td>
                    <td>
                        <select  style="width: 400px;" class="form-control" name="Studiengang" id="Studiengang" required>
                            <option value="None">Keiner</option>
                            <option value="Betriebswirtschaftlehre">Betriebswirtschaftslehre</option>
                            <option value="Wirtschaftsinformatik">Wirtschaftsinformatik</option>
                            <option value="Volkswirtschaftslehre">Volkswirtschaftslehre</option>
                            <option value="Wirtschaftspädagogik">Wirtschaftspädagogik</option>
                        </select>
                    </td>
                </tr>
            </table><br>
            <div class="form_ueberschrift">Themen Informationen</div><br>
            <div id="meldung">
                <table>
                    <tr>
                        <td>
                            <div role="alert">
                                <div class="alert alert-danger" style="margin-left: 270px; width:300px; margin-top: 1%;" role="alert">
                                    Bitte wähle zuerst eine Kategorie aus!
                                </div>
                            </div>  
                        </td>
                    </tr>     
                </table>
            </div>  
            <!-- WENN AUF ABSCHLUSS GEKLICKT WIRD ERSCHEINT DIESES FORMULAR ! -->
        </feld>

        <!-- WENN AUF SEMINAR GEKLICKT WIRD ERSCHEINT DIESES FORMULAR ! -->

        <div id="seminar">   
            <table>
                <tr>
                    <td style="width: 37%"><label for="Verfahren"><b>Verfahren:</b></label></td>  
                    <td><select style="width: 400px;" name="Verfahrenseminar" id="verfahren1" class="form-control">
                            <option value=""></option>
                            <option value="Windhundverfahren">Windhundverfahren</option>
                            <option value="Bewerbungsverfahren">Bewerbungsverfahren</option>
                            <option value="Belegwunschverfahren">Belegwunschverfahren</option>
                        </select></td>  
                </tr>
            </table>                    

            <div class="row" id="meldung2">
                <table>
                    <tr>
                        <td>
                            <div role="alert">
                                <div class="alert alert-danger" style="margin-left: 270px; width:300px; margin-top: 1%;" role="alert">
                                    Bitte wähle ein Verfahren aus!
                                </div>
                            </div>  
                        </td>
                    </tr>
                </table>
            </div>

            <!-- WENN WINDHUND ODER BEWERBUNGSVERFAHREN AUSGEWÄHLT WIRD!-->

            <feld2>
                <div id="WindUndBew">      
                    <div class="form-group fieldGroup">
                        <table>
                            <tr>
                                <td style="width: 34.3%"><label for="titel"><b>Titel:</b></label></td>
                                <td><input style="width: 400px;" type="text" name="themenbezeichnungwindhund[]" class="form-control" placeholder="Titel des Themas"/></td>  
                                <td><a href="javascript:void(0)" class="btn btn-success addMore2">Hinzufügen</a></td>
                            </tr>
                            <td style="width: 34.5%"><b>Beschreibung:</b></td>
                            <td>
                                <textarea style="width: 400px;" type="text" name="themenbeschreibung[]" class="form-control" placeholder="Beschreibung des Themas"/></textarea>
                            </td>
                        </table> 
                    </div> 
                    <input type="submit" name="modul_eintrag1" class="btn btn-primary" value="Modul eintragen"/> 
                </div>     
            </feld2>


            <!-- WENN AUF BELEGWUNSCH GEKLICKT WIRD -->
            <feld3> 
                <div id="Belegwunschverfahren">
                    <div class="form-group fieldGroup">
                        <table>
                            <tr>
                                <td style="width: 34.3%"><label for="titel"><b>Titel: <red style="color: red"> * </red> </b></label></td>
                                <td><input style="width: 400px;" type="text" name="themenbezeichnungbelegwunsch[]" id="validationCustom03" class="form-control" placeholder="Titel des Themas"/></td>  
                                <td><a href="javascript:void(0)" class="btn btn-success addMore3">Hinzufügen</a></td>
                            </tr>
                            <td style="width: 34.5%"><b>Beschreibung:</b></td>
                            <td>
                                <textarea style="width: 400px;" type="text" name="themenbeschreibung[]" class="form-control" placeholder="Beschreibung des Themas"/></textarea>
                            </td>
                            <tr>
                                <td style="width: 34.3%"><label for="titel"><b>Titel: <red style="color: red"> * </red> </b></label></td>
                                <td><input style="width: 400px;" type="text" name="themenbezeichnungbelegwunsch[]" id="validationCustom03" class="form-control" placeholder="Titel des Themas"/></td>  
                            </tr>
                            <td style="width: 34.5%"><b>Beschreibung:</b></td>
                            <td>
                                <textarea style="width: 400px;" type="text" name="themenbeschreibung[]" class="form-control" placeholder="Beschreibung des Themas"/></textarea>
                            </td>
                            <tr>
                                <td style="width: 34.3%"><label for="titel"><b>Titel: <red style="color: red"> * </red></b></label></td>
                                <td><input style="width: 400px;" type="text" name="themenbezeichnungbelegwunsch[]" id="validationCustom03" class="form-control" placeholder="Titel des Themas"/></td>  
                            </tr>
                            <td style="width: 34.5%"><b>Beschreibung:</b></td>
                            <td>
                                <textarea style="width: 400px;" type="text" name="themenbeschreibung[]" class="form-control" placeholder="Beschreibung des Themas"/></textarea>
                            </td>
                        </table>  
                    </div>
                    <input type="submit" name="modul_eintrag2" class="btn btn-primary" value="Modul eintragen"/>
                </div>
            </feld3>      

        </div>    
    

   
</div>
</form>
    <!-- copy of input fields group -->
    <div class="form-group fieldGroupCopy" style="display: none;">     
        <table>
            <tr> 
                <td><label for="titel"><b>Titel:</b></label></td>
                <td><input style="width: 400px;" type="text" name="themenbezeichnungwindhund[]" class="form-control" placeholder="Titel des Themas"/></td>
                <td><a href="javascript:void(0)" class="btn btn-danger remove">Entfernen</a></td>
            </tr>
            <tr>
                <td style="width: 32.5%"><b>Beschreibung:</b></td>
                <td><textarea style="width: 400px;" type="text" name="themenbeschreibung[]" class="form-control" placeholder="Beschreibung des Themas"/></textarea></td>
            </tr>
        </table>
    </div>
    <div class="form-group fieldCopy2" style="display: none;">     
        <table>
            <tr> 
                <td style="width: 32.5%"><label for="titel"><b>Titel:</b></label></td>
                <td><input style="width: 377px;" type="text" name="themenbezeichnungbelegwunsch[]" class="form-control" placeholder="Titel des Themas"/></td>
                <td><a href="javascript:void(0)" class="btn btn-danger remove">Entfernen</a></td>
            </tr>
            <tr>
                <td style="width: 32.5%"><b>Beschreibung:</b></td>
                <td><textarea style="width: 400px;" type="text" name="themenbeschreibung[]" class="form-control" placeholder="Beschreibung des Themas"/></textarea></td>
            </tr>
        </table>
    </div>
<?php
include 'navi.php';
include 'footer.php';
?>