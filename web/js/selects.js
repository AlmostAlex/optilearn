

    $(document).ready(function(){
    var $select = $("select");
$select.on("change", function() {
    var selected = [];  
    $.each($select, function(index, select) {           
        if (select.value !== "") { selected.push(select.value); }
    });         
   $("option").prop("readonly", false);         
   for (var index in selected) { $('option[readonly]').prop("readonly", true); }
}); });
