<?php include 'header.php';?>
    <h4 class="card-title">Bewerbung -> Bewerbungs-Verfahren</h4>   
            
                   
                <div class="formbox">            
                        <form action="bewerben.php" method="post">
                            <div class="card-header" style="margin-bottom: 4%"><h4><u>Bewerbung auf ein Seminar- oder Abschlussarbeitsthema</u></h4></div>

                          <h6 style="background-color: #efefef; padding: 5px; margin: 5px; text-align: right;">persönliche Informationen</h6>

        
                            <table style="width: 100%">
                                <tr style="width: 100%">
                                 <td style="width: 30%;"> <label style="padding-left: 5%;" for="inputVorname"><b>Vorname:</b> </label>  </td> 
                                 <td style="width: 50%; padding-right: 5%;"><input type="text" class="form-control" id="inputVorname" > </td> 
                               </tr>

                                <tr>
                                 <td style="width: 30%;"> <label style="padding-left: 5%;" for="inputNachname"><b>Nachname:</b> </label>  </td> 
                                 <td style="width: 50%; padding-right: 5%;"><input type="text" class="form-control" id="inputNachname" > </td> 
                               </tr>

                                <tr>
                                 <td style="width: 30%;"><label style="padding-left: 5%;" for="inputMatrikel"><b>Matrikelnummer:</b> </label>  </td> 
                                 <td style="width: 50%; padding-right: 5%;"><input type="text" class="form-control" id="inputMatrikel" > </td> 
                               </tr>

                                <tr>
                                 <td style="width: 30%;"> <label style="padding-left: 5%;" for="inputMail"><b>E-Mail:</b> </label>  </td> 
                                <td style="width: 40%; padding-right: 5%;"><input type="text" class="form-control" id="inputMail" > </td> 
                               </tr>


                             <tr>
                                   <td style="width: 30%;"><label style="padding-left: 5%;" for="inputStudiengang"><b>Studiengang:</b> </label> </td>
                                    <td style="width: 50%; padding-right: 5%;"><select class="form-control" id="Studiengang">
                                    <option></option>
                                    <option>Wirtschaftsinformatik</option>
                                    <option>Betriebswirtschaftslehre</option>
                                    <option>Volkswirtschaftslehre</option>
                                    <option>Wirtschaftspädagogik</option>
                                    </select></td>
                                </tr>

                                <tr>
                                  <td style="width: 30%;"><label style="padding-left: 5%; text-align:left" for="inputSemesteranzahl"><b>Aktuelles Fachsemester:</b> </label>  </td> 
                                     <td style="width: 50%; padding-right: 5%;"><input type="text" class="form-control" id="inputSemesteranzahl" placeholder="Bspw.: 5 "> </td> 
                               </tr>

                                <tr>
                                  <td style="width: 30%;"><label  style="padding-left: 5%; text-align:left" for="inputCreditsranzahl"><b>Creditsanzahl:</b></label>  </td> 
                                 <td style="width: 50%; padding-right: 5%;"><input type="text" class="form-control" id="inputCreditsranzahl" placeholder="Anzahl der Credits"> </td> 
                               </tr>

                                </table>
                            <br>
                          <h6 style="background-color: #efefef; padding: 5px; margin: 5px; text-align: right;">Zentrale Informationen</h6>

                            <table>
                             <tr>
                                 <td style="width: 55%;"><label style="padding-left: 5%; " for="Kategorie"><b>Kategorie:</b></label> </td>    
                                  <td style="width: 20%"><input type="radio" name="kategorie1" id="inlineRadio1" value="option1"> Seminarthema </input>    </td> 
                                  <td style="width: 20%"> <input type="radio" name="kategorie1" id="inlineRadio1" value="option2"> Abschlussarbeit </input> 
                                 </td> 
                            </tr>
                            </table>

                        <table>
                                <tr>
                                 <td style="width: 30%;"><label style="padding-left: 5%; text-align:left" for="inputVorname"><b>Abgeschl. O-Phase:</b> </label>  </td> 
                                    <td style="width: 50%; padding-right: 5%;"><select class="form-control" id="oPhase">
                                    <option></option>
                                    <option>Ja</option>
                                    <option>Nein</option>
                                    </select></td>
                               </tr>

                                <tr>
                                 <td style="width: 30%;"><label style="padding-left: 5%; text-align:left" for="inputNachname"><b>Bereits an Seminar/Abschluss teilgenommen?:</b> </label>  </td> 
                                    <td style="width: 50%; padding-right: 5%;"><select class="form-control" id="Teilnahme">
                                    <option></option>
                                    <option>Ja</option>
                                    <option>Nein</option>
                                    </select></td>
                               </tr>
 
                               <tr>
                                  <td style="width: 30%;"><label style="padding-left: 5%; text-align:left" for="inputoPhase"><b>Thema:</b> </label></td>
                                   <td style="width: 50%; padding-right: 5%;"><select class="form-control" id="b1">
                                    <option></option>
                                    <option>Burger</option>
                                    <option>Pizza</option>
                                    <option>Salat</option>
                                    </select></td>
                                </tr>
   


                             <tr>
                                 <td>                        
                                  <button style="margin: 10%" type="button" style="margin-top:5px;margin-bottom:15px;" class="btn btn-primary">Bewerbung abschicken</button>
                                 </td>       
                             </tr>
                                </table>
   




                        </form>    
                </div>        
                              
            
<?php include 'navi.php';?>
<?php include 'footer.php';?>
