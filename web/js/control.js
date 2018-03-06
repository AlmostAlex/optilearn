

$(document).ready(function () {
        //group add limit
        var maxGroup = 10;

        //add more fields group        
                $(".addMore2").click(function() {
            if ($('feld2').find('.fieldGroup').length < maxGroup) {
                var fieldHTML = '<div class="form-group fieldGroup">' + $(".fieldGroupCopy").html() + '</div>';
                $('feld2').find('.fieldGroup:last').after(fieldHTML);
            } else {
                alert('Maximum ' + maxGroup + ' groups are allowed.');
            }
        });
        
        $(".addMore3").click(function() {
            if ($('feld3').find('.fieldGroup').length < maxGroup) {
                var fieldHTML = '<div class="form-group fieldGroup">' + $(".fieldCopy2").html() + '</div>';
                $('feld3').find('.fieldGroup:last').after(fieldHTML);
            } else {
                alert('Maximum ' + maxGroup + ' groups are allowed.');
            }
        });


        //remove fields group
                $("feld2").on("click", ".remove", function () {
            $(this).parents(".fieldGroup").remove();
        });
        
                $("feld3").on("click", ".remove", function () {
            $(this).parents(".fieldGroup").remove();
        });
        
    });
    
    /*Without jQuery Cookie*/
$(document).ready(function(){
        $("#seminar").css("display","none");
            
    $(".Kategorie").click(function(){
        if ($('input[name=Kategorie]:checked')){
            $("#seminar").slideDown("slow");
            $("#meldung").slideUp("slow");
        }      
        
        
     });            
});

    $(function() {
    $("#WindUndBew").css("display", "none"); 
    $("#Belegwunschverfahren").css("display", "none"); 
        
    $('#row_dim').hide(); 
    $('#verfahren1').change(function(){
                      
        if($('#verfahren1').val() == '') {
            $('#meldung2').slideDown("slow");
            $('#Belegwunschverfahren').slideUp("slow"); 
            $('#WindUndBew').slideUp("slow"); 
        }
        else if($('#verfahren1').val() == 'Windhundverfahren') {
            $('#meldung2').slideUp("slow");
            $('#Belegwunschverfahren').slideUp("slow"); 
            $('#WindUndBew').slideDown("slow");                   
        } 
        
       else if($('#verfahren1').val() == 'Bewerbungsverfahren') {
            $('#meldung2').slideUp("slow");
            $('#Belegwunschverfahren').slideUp("slow"); 
            $('#WindUndBew').slideDown("slow");                   
        } 
            
       else if($('#verfahren1').val() == 'Belegwunschverfahren') {
            $('#meldung2').slideUp("slow");  
            $('#WindUndBew').slideUp("slow");
            $('#Belegwunschverfahren').slideDown("slow");
       }
           
 
    });
});
$(function() {
    $("#WindUndBew").css("display", "none"); 
    $("#Belegwunschverfahren").css("display", "none"); 
        
    $('#row_dim').hide(); 
    $('#Verfahren').change(function(){
                      
        if($('#Verfahren').val() == '') {
            $('#meldung2').slideDown("slow");
            $('#Belegwunschverfahren').slideUp("slow"); 
            $('#WindUndBew').slideUp("slow"); 
        }
        else if($('#Verfahren').val() == 'Windhundverfahren') {
            $('#meldung2').slideUp("slow");
            $('#Belegwunschverfahren').slideUp("slow"); 
            $('#WindUndBew').slideDown("slow");                   
        } 
        
       else if($('#Verfahren').val() == 'Bewerbungsverfahren') {
            $('#meldung2').slideUp("slow");
            $('#Belegwunschverfahren').slideUp("slow"); 
            $('#WindUndBew').slideDown("slow");                   
        } 
            
       else if($('#Verfahren').val() == 'Belegwunschverfahren') {
            $('#meldung2').slideUp("slow");  
            $('#WindUndBew').slideUp("slow");
            $('#Belegwunschverfahren').slideDown("slow");
       }
           
 
    });
});