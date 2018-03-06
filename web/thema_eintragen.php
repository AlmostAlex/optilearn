            <?php include 'header.php';?>

            <a href="verwaltung.php"><i class="fas fa-chevron-right"></i> zurück zur Übersichtsseite</a><br><br>
                <h2 class="card-title">Thema erstellen</h2> 
                         
                <div class="formbox">
                        
                        <form action="index.php" method="post">
                            <div class="card-header" style="margin-bottom: 4%;"><h4><u>Thema eintragen</u></h4></div>
                       
                             <table style="width: 100%">

                             <tr>
                                  <td style="width: 30%;"><label style="padding-left: 5%;" for="Kategorie"><b>Kategorie:</b></label> </td>    
                                   <td style="width: 25%"> <input type="radio" name="kategorie1" id="inlineRadio1" value="option1"> Seminarthema </input>    </td> 
                                   <td style="width: 25%">  <input type="radio" name="kategorie1" id="inlineRadio1" value="option2"> Abschlussarbeit </input> 
                                 </td> 
                            </tr>
                             </table>
                            
                             <table style="width: 100%">
                             <tr style="width: 100%">
                                 <td style="width: 30%;"><label style="padding-left: 5%;" for="Termine"><b>Bewerbungsfristen</b></label> </td>
                                 <td style="width: 30%; padding-right: 2%;"><input type="text" class="form-control" id="Starttermin" placeholder="TT.MM.YYYY">
                                    <span>Starttermin</span> </td>
                                 <td style="width: 30%;  padding-right: 2%;"><input type="text" class="form-control" id="Endtermin"  placeholder="TT.MM.YYYY">
                                     <span>Endtermin</span> 
                                 </td>
                             </tr>
                            </table>
                             <table>
                             <tr>
                                 <td style="width: 20%;"><label style="padding-left: 5%;"  for="inputTitel"><b>Titel:</b></label>  </td> 
                                 <td style="width: 60%;"><input type="text" class="form-control" id="inputTitel" placeholder="Titel"> </td> 
                             </tr>

                              <tr>
                                 <td style="width: 20%;"><label style="padding-left: 5%;"  for="Voraussetzung" ><b>Zulassungsvoraussetzung:</b></label>  </td> 
                                 <td><input type="text" class="form-control" name="Voraussetzng" placeholder="(Optional)" id="form-control"></td>                             
                             </tr>
                             
                                <tr>
                                   <td style="width: 30%;"><label style="padding-left: 5%;" for="bevStudiengang"><b>Bevorzugter Studiengang:</b> </label></td>
                                    <td><select class="form-control" id="bevStudiengang">
                                    <option>Keiner</option>
                                    <option>Betriebswirtschaftslehre</option>
                                    <option>Wirtschaftsinformatik</option>
                                    <option>Volkswirtschaftslehre</option>
                                    <option>Wirtschaftspädagogik</option>
                                        </select></td>
                                </tr>

                              <tr>
                                 <td style="width: 20%;"><label style="padding-left: 5%;" for="Tags"><b>Tags: </b></label>  </td> 
                                 <td><input type="text" class="form-control" name="Tags" id="form-control"></td>                             
                             </tr>

                               <tr>
                                   <td style="width: 30%;"><label style="padding-left: 5%;" for="inputVerfahren"><b>Verfahren:</b> </label></td>
                                    <td><select class="form-control" id="Verfahren">
                                    <option>Windhund-Verfahren</option>
                                    <option>Bewerbungsverfahren</option>
                                    <option>Belegungswunsch-Verfahren</option>
                                    </select></td>
                                </tr>
                               <tr>
                                   
                                 <td style="width: 30%;"><label style="padding-left: 5%;" for="inputBeschreibung"><b>Beschreibung:</b></label>  </td> 
                                 <td style="width: 25%"><textarea class="form-control" name="beschreibung" id="exampleFormControlTextarea1" rows="8" placeholder="Beschreibung des Themas"></textarea></td>                             
                             </tr>
                             <tr>

                              <td>    <button style="margin: 10%;" type="button" class="btn btn-primary">Einreichen</button> </td>       
                             </tr>
                             
                            </table>   
                        </form>    
                </div>


    <?php include 'navi_thema_eintragen.php';?>
    <?php include 'footer.php';?>    
    
    </body>
</html>