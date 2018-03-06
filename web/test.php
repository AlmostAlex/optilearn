
<head>


  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $("#datepicker").datepicker($.extend({}, $.datepicker.regional["de"], {
        prevText: '&#x3c;zurück', prevStatus: '',
        prevJumpText: '&#x3c;&#x3c;', prevJumpStatus: '',
        nextText: 'Vor&#x3e;', nextStatus: '',
        nextJumpText: '&#x3e;&#x3e;', nextJumpStatus: '',
        currentText: 'heute', currentStatus: '',
        todayText: 'heute', todayStatus: '',
        clearText: '-', clearStatus: '',
        closeText: 'schließen', closeStatus: '',
        monthNames: ['Januar','Februar','März','April','Mai','Juni',
        'Juli','August','September','Oktober','November','Dezember'],
    monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
        'Jul','Aug','Sep','Okt','Nov','Dez'],
        dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
        dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
        dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
    showButtonPanel : true,
    altField : "#datepicker_input",
    dateFormat : "yy-mm-dd"
}));
  } );
  </script>

<p>Date: <input type="text" id="datepicker"></p>
 
 
</body>
</html>