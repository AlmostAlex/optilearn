<script> $(function () { $('[data-toggle="tooltip"]').tooltip()})</script>

<?php
require("db.php");
require("Models/modul_model.php");
require("Models/windhund_model.php");
require("Models/bewerbung_model.php");
require("Models/reporting_model.php");
require("Models/belegwunsch_model.php");

class reporting_controller {
    public $modul;

    public function __construct() {
        $this->modul = new modul_model();
        $this->thema = new thema_model();
        $this->belegwunsch = new belegwunsch_model();       
        $this->reporting = new reporting_model();
    }

    public function ReportBasis($semester, $modul_id) {
        $modul_id_aktuell = $modul_id;
        echo"<report>";
        echo "<div class='title'>Alle Informationen im Überblick</div>";

        $statement = $this->modul->getModulAnzahlBySemester($semester);
        $statement->bind_result($modul_anzahl);
        $statement->store_result();

        $verfuegbar = "Verfügbar";
        $statement_verfuegbar = $this->modul->getModulAnzahlVerfuegbarBySemester($semester, $verfuegbar);
        $statement_verfuegbar->bind_result($modul_verfuegbar_anzahl);
        $statement_verfuegbar->store_result();

        while ($statement->fetch()) {
            while ($statement_verfuegbar->fetch()) {
                echo"<div style='float:left; width: 45%; margin-left: 3%;' class='well'>";
                echo"<b>Semester <b>{$semester}</b> Informationen:</b>";
                echo"<table>";
                echo"<tr><td style='width: 180px;'>Module Insgesamt:</td><td>{$modul_anzahl}</td></tr>";
                echo"<tr><td><i class='fas fa-angle-right'></i> Verfügbare Module:</td> <td>{$modul_verfuegbar_anzahl}</td></tr>";
                $vergeben = $modul_anzahl - $modul_verfuegbar_anzahl;
                echo"<tr><td><i class='fas fa-angle-right'></i> Vergebene Module:</td> <td>{$vergeben}</td></tr>";
                echo"</table></div>";
            }
        }
        echo"<div style='margin-left: 50%; margin-right: 3%;'class='well'>";
        echo"<b>Informationen:</b><br>";
        // echo"<i class='fas fa-arrows-alt-v'></i> Es kann nach aufsteigend/absteigend sortiert werden.<br>";
        echo"<i class='far fa-file'></i> Es können alle angezeigten Module exportiert werden. (.csv)<br><br>";
        echo"</div>";
        echo"<br><div class='title'>Alle Module aus dem Semester: {$semester}</div>";
        ?> 

        <div class="table-responsive" id="module">  
            <semester><table class="table table-bordered">                   
                    <tr>  
                        <th><span class="column_sort" id="modul_id" data-order="desc" return false>ID</span></th>  
                        <th><span class="column_sort" id="modulbezeichnung" data-order="desc" return false>Modulbezeichnung</span></th> 
                        <th><span class="column_sort" id="frist_start" data-order="desc" return false>Start</span></th> 
                        <th><span class="column_sort" id="frist_ende" data-order="desc" return false>End</span></th>
                        <th><span class="column_sort" id="verfahren" data-order="desc" return false>Verfahren</span></th> 
                        <th><span class="column_sort" id="nachrueckverfahren" data-order="desc" return false>Nachrückverfahren</span></th>
                        <th><i  data-toggle="tooltip" data-placement="top" title="Anzahl der Bewerber" class="fas fa-users"></i></th>
                        <th><i  data-toggle="tooltip" data-placement="top" title="Verfügbaren/Vergebenen Themen" class="fas fa-question-circle"></i></th>
                    </tr> 

                    <?php
                    $anz_ab = "0";
                    $anz = "0";
                    $anz_th = "0";
                    $verfuegbarkeit = "Verfügbar";

                    $statement = $this->modul->getModulBySemester($semester);
                    $statement->bind_result($modul_id, $modulbezeichnung, $verfahren, $frist_start, $frist_ende, $nachrueckverfahren, $timestamp);
                    $statement->store_result();
                    while ($statement->fetch()) {
                        $date_single = date('d.m.Y', strtotime($timestamp));
                        $date[] = $date_single;
                        $start_anzeige = date("d-m-Y", strtotime($frist_start));
                        $ende_anzeige = date("d-m-Y", strtotime($frist_ende));
                      
                        $statement_thema = $this->thema->getModulThema($modul_id);
                        $statement_thema->bind_result($themenbezeichnung, $beschreibung, $thema_id, $thema_verfuegbarkeit);
                        $statement_thema->store_result();
                        while ($statement_thema->fetch()) {

                            $statement_themenanzahl = $this->thema->getModulThemaAnzahlById($modul_id);
                            $statement_themenanzahl->bind_result($anzahl);
                            $statement_themenanzahl->store_result();
                            while ($statement_themenanzahl->fetch()) {

                                $statement_themaVerfuegbar = $this->thema->getModulThemaAnzahlVerfuegbar($modul_id, $verfuegbarkeit);
                                $statement_themaVerfuegbar->bind_result($anzahl_thema_verfuegbar);
                                $statement_themaVerfuegbar->store_result();
                                while ($statement_themaVerfuegbar->fetch()) {             
                                }
                            }
            }

            if($verfahren=="Windhundverfahren"){
            $DBverfahren = "windhund";
            $statement_bew = $this->thema->getAnzahlWindhund($DBverfahren, $modul_id);
            $statement_bew->bind_result($ab);
            $statement_bew->store_result();
            }

            else if($verfahren =="Bewerbungsverfahren"){
            $DBverfahren = "bewerbung";
            $statement_bew = $this->thema->getAnzahlWindhund($DBverfahren, $modul_id);
            $statement_bew->bind_result($ab);
            $statement_bew->store_result();
            }
            else if($verfahren = "Belegwunschverfahren"){
            $DBverfahren = "belegwunsch";
            $statement_bew = $this->thema->getAnzahlBelegwunsch($DBverfahren, $modul_id);
            $statement_bew->bind_result($ab);
            $statement_bew->store_result();
            } 
            
            while ($statement_bew->fetch()) {            
                        $modul_array[] = "Modul_ID {$modul_id}";
                        $thema_insg[] = $anzahl;
                        $th_verfuegbar[] = $anzahl_thema_verfuegbar;
                        $anzahl_bewerber_semester[] = $ab;
                        ?>
                        <tr>  
                            <td> <?php echo "{$modul_id}" ?></td>  
                            <td> <?php echo "{$modulbezeichnung}" ?></td> 
                            <td> <?php echo "{$start_anzeige}" ?></td> 
                            <td> <?php echo "{$ende_anzeige}" ?></td> 
                            <td> <?php echo "{$verfahren}" ?></td> 
                            <td> <?php echo "{$nachrueckverfahren}" ?></td>
                            <td> <?php echo "{$ab}" ?></td>
                            <td><?php echo "{$anzahl}/{$anzahl_thema_verfuegbar}" ?></td>
                            <?php
                            $anz_ab += $ab;
                            $anz += $anzahl;
                            $anz_th += $anzahl_thema_verfuegbar; 
                            ?>
                <?php } }?>
                    </tr> 
                    <tr> 
                    <td colspan='6' style='text-align: right;'></td>
                    <td colspan='1'><?php echo "{$anz_ab}" ?></td>
                    <td colspan='1'><?php echo "{$anz}/{$anz_th}" ?></td>
                    </tr> 
                    <?php
                    $modul_array = json_encode($modul_array);       
                    $anz_insgesamt_array = json_encode($thema_insg);
                    $anzahl_thema_verfuegbar_array = json_encode($th_verfuegbar);
                    $anzahl_bewerber_semester_array = json_encode($anzahl_bewerber_semester);
                    ?> 
                </table>
            </semester>   
        </div>  

        <export> 
            <form action="excel_report_bySemester.php?action=export&semester=<?php echo $semester ?>" method="post">
                <button type="submit" name="export_excel" class="btn btn-primary"  value="Module exportieren"><i class="fas fa-align-justify"></i> Module exportieren</button>
            </form>
        </export>
        <graphik>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_report_semester"><i class="fas fa-chart-area"></i> Übersicht</button>
        </grapghik>
        </report> 

        <reportModal>
            <div class="modal hide fade in" id="modal_report_semester" tabindex="-1" role="dialog"  aria-hidden="true">
                <div style='min-width: 850px;' class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div style='border: 0px;' class="modal-body">   
                          <center><h3>Allgemeine Übersicht</h3></center>
<table> 
    <tr>
        <td>             
            <h5><u>Insgesamt und Vergebene Themen</u></h5>   
            <center><canvas id="bar_anzahl_semester"></canvas></center> 
        </td>
        <td>
            <h5><u>Anzahl der Bewerber in Abhängigkeit der Module</u></h5>   
            <center><canvas id="bar_anzahl_bewerber_semester"></canvas></center> 
        </td>
    </tr>
</table>
                        </div>
                        <div style='border: 0px;' class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </reportModal>

        <script>
            var ctx = document.getElementById("bar_anzahl_semester").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo $modul_array ?>,
                    datasets: [
                        {
                            label: "Insgesamt",
                            backgroundColor: "#3e95cd",
                            data: <?php echo $anz_insgesamt_array ?>
                        }, {
                            label: "Verfügbar",
                            backgroundColor: "#8e5ea2",
                            data: <?php echo $anzahl_thema_verfuegbar_array ?>
                        }
                    ]
                },
options: {
responsive: true,      
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    stepSize: 1,
                }
            }]
        }
    }
            });

            var ctx = document.getElementById("bar_anzahl_bewerber_semester").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo $modul_array ?>,
                    datasets: [
                        {
                            label: "Anzahl Bewerber",
                            backgroundColor: "#3e95cd",
                            data: <?php echo $anzahl_bewerber_semester_array ?>
                        }
                    ]
                },
options: {
responsive: true,      
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    stepSize: 1,
                }
            }]
        }
    }
  });

        </script>
        <?php
         $anzahl_bewerber = "0";
         $bew_sum = "0";
            $statement = $this->modul->getModulbezeichnungVerfahren($modul_id_aktuell);
            $statement->bind_result($modulbezeichnung, $verfahren);
            $statement->store_result();
               while ($statement->fetch()) {   
                echo"<br><br><report><div class='title'> Informationen zum Modul: {$modulbezeichnung}</div></report>";
        }        
        ?>      
        <report>
            <div class="table-responsive" id="thema">  
                <semester><table class="table table-bordered">  
                        <tr>  
                            <th><span class="column_sort_thema" id="thema_id" data-order_thema="desc" return false>ID</span></th>  
                            <th><span class="column_sort_thema" id="themenbezeichnung" data-order_thema="desc" return false>Themenbezeichnung</span></th> 
                            <th><span class="column_sort_thema" id="thema_verfuegbarkeit" data-order_thema="desc" return false>Verfügbarkeit</span></th> 
                            <th><i data-toggle="tooltip" data-placement="top" title="Anzahl der Bewerber auf das Thema" class="fas fa-question-circle"></i></th>
                        </tr> 
                        <?php
                        $statement = $this->thema->getThemenBez($modul_id_aktuell);
                        $statement->bind_result($thema_id, $themenbezeichnung, $thema_verfuegbarkeit);
                        $statement->store_result();
                        while ($statement->fetch()) {                           
                            if($verfahren == "Windhundverfahren"){
                                if($thema_verfuegbarkeit == "Vergeben"){
                                    $anzahl_bewerber = 1;
                                    $bew_sum += $anzahl_bewerber;
                                } else {
                                    $anzahl_bewerber = 0;           
                                }
                            }
                            else if($verfahren == "Bewerbungsverfahren"){
                                $statement_bew = $this->thema->getBewerberAufThema($thema_id);
                                $statement_bew->bind_result($anzahl_bewerberdb);
                                $statement_bew->store_result();
                                while ($statement_bew->fetch()) {
                                    $anzahl_bewerber=$anzahl_bewerberdb;
                                    $bew_sum += $anzahl_bewerber;
                                }
                            }
                            else if($verfahren == "Belegwunschverfahren"){                           
                                $statement_bew = $this->belegwunsch->getBewerberAufThema($thema_id);
                                $statement_bew->bind_result($anzahl_bewerberdb);
                                $statement_bew->store_result();
                                while ($statement_bew->fetch()) {
                                    $anzahl_bewerber=$anzahl_bewerberdb;
                                    $bew_sum += $anzahl_bewerber;
                                }
                            }
                                  
                            echo"<tr>";
                            echo"<td>{$thema_id}</td>";
                            echo"<td>{$themenbezeichnung}</td>";
                            echo"<td>{$thema_verfuegbarkeit}</td>";
                            echo"<td>{$anzahl_bewerber}</td>";
                            echo"</tr>";
                            
                        
                        }
                        ?>
                        <tr>
                            <td colspan='3'></td>
                            <td><?php echo $bew_sum ?></td>
                        </tr>
                    </table>    
                </semester>
            </div>
        </report>
        <export> 
           <form action="excel_report_bySemester.php?action=export&modul_id=<?php echo "{$modul_id_aktuell}" ?>" method="post">
           <button type="submit" name="export_excel" class="btn btn-primary"  value="Module exportieren"><i class="fas fa-align-justify"></i> Themen exportieren</button>
           </form> 
        </export>
        </report> 

        <br>
        <br><br>
        <br><br>

        <script>
            $(document).ready(function () {
                $(document).on('click', '.column_sort', function () {
                    var column_name = $(this).attr("id");
                    var order = $(this).data("order");
                    var semester = '<?php echo $semester ?>';
                    var bew_gesamt = <?php echo $anz_ab ?>; 
                    var ver_themen = <?php echo $anz ?>; 
                    var verg_themen = <?php echo $anz_th ?>; 
                    var arrow = '';
                    if (order == 'desc')
                    {
                        arrow = ' <i class="fas fa-angle-down"></i>';
                    } else
                    {
                        arrow = ' <i class="fas fa-angle-up"></i>';
                    }
                    $.ajax({
                        url: "sort_report_semester.php",
                        method: "POST",
                        data: {column_name: column_name, order: order, semester: semester, bew_gesamt:bew_gesamt, ver_themen:ver_themen, verg_themen:verg_themen},
                        success: function (data)
                        {
                            $('#module').html(data);
                            $('#' + column_name + '').append(arrow);
                        }
                    })
                });
            });
            $(document).ready(function () {
                $(document).on('click', '.column_sort_thema', function () {
                    var column_name_thema = $(this).attr("id");
                    var order_thema = $(this).data("order_thema");
                    var modulbezeichnung = '<?php echo $modulbezeichnung ?>';
                    var verfahren = '<?php echo $verfahren ?>';
                    var arrow_thema = '';
                    if (order_thema == 'desc')
                    {
                        arrow_thema = ' <i class="fas fa-angle-down"></i>';
                    } else
                    {
                        arrow_thema = ' <i class="fas fa-angle-up"></i>';
                    }
                    $.ajax({
                        url: "sort_report_modul.php",
                        method: "POST",
                        data: {column_name_thema: column_name_thema, order_thema: order_thema, modulbezeichnung: modulbezeichnung, verfahren:verfahren},
                        success: function (data)
                        {
                            $('#thema').html(data);
                            $('#' + column_name_thema + '').append(arrow_thema);
                        }
                    })
                });
            });

        </script> 
        <?php
    }

}
?>

