<?php
include ("header.php");
include ("Controllers/modul_controller.php");
?>

<form method="post">
    <div class='add_thema'>
        <feld2>  
            <div class="form-group fieldGroup">
                <table class="add_table">
                    <tr>
                        <td colspan="3"><h5>Thema zusätzlich hochladen:</h5></td>
                    </tr>
                    <tr>
                        <td><label for="titel"><b>Titel:</b></label></td>
                        <td><input type="text" name="themenbezeichnung[]" class="form-control" placeholder="Titel des Themas" required /></td>  
                        <td><a href="javascript:void(0)" class="btn btn-success addMore2"> <i class="fas fa-plus"></i> Hinzufügen</a></td>
                    </tr>
                    <tr>
                        <td><b>Beschreibung:</b></td>
                        <td>
                            <textarea cols="60" rows="5" type="text" name="themenbeschreibung[]" class="form-control" placeholder="Beschreibung des Themas"/></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 20px; border-bottom: 1px dotted #d9d9d9;" colspan="3"></td>
                    </tr>
                </table>    
            </div> 
            <table class="add_table" style='margin-bottom: 5%;'>        
                <tr>
                    <td colspan="1"></td>
                    <td><input type="submit" name="addthema" class="btn btn-primary" value="Hochladen"/></td>                 
                </tr>
            </table>       
        </feld2>
    </div>
</form>
<br><br>

<?php
if (isset($_POST["addthema"])) {
    $id = base64_decode($_GET['id']);
    $modul_id = $id;
    $thema = new modul_controller();
    $thema->addThema($modul_id);
}
?>
<div class="form-group fieldGroupCopy" style="display: none;">     
    <table class="add_table">
        <tr> 
            <td><label for="titel"><b>Titel:</b></label></td>
            <td><input type="text" name="themenbezeichnung[]" class="form-control" required placeholder="Titel des Themas"/></td>
            <td><a href="javascript:void(0)" class="btn btn-danger remove"><i class="fas fa-minus-square"></i> Entfernen</a></td>
        </tr>
        <tr>
            <td><b>Beschreibung:</b></td>
            <td><textarea type="text" cols="60" rows="5" name="themenbeschreibung[]" class="form-control" placeholder="Beschreibung des Themas"/></textarea></td>
        </tr>
    </table>
</div> 
<?php
include("navi.php");
include("footer.php");
?>