
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('.js-tilt').tilt({
        scale: 0.9
    })
});

$(document).ready(function () {
    $('#purpose').on('change', function () {
        if (this.value == '1')
        {
            $("#business").slideDown("slow")
        } else
        {
            $("#business").hide();
        }
    });
});

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
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
                $("#waehle_stadt").slideUp();
                $("#bezirk").slideDown();
            }
        };
        xmlhttp.open("GET", "getBezirk.php?q=" + str, true);
        xmlhttp.send();
    }
}
$(document).ready(function () {
    $('.tab a').on('click', function (e) {
        e.preventDefault();

        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');

        var href = $(this).attr('href');
        $('.forms > form').hide();
        $(href).fadeIn(500);
    });
});