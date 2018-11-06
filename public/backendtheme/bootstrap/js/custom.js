$(".fbutton").click(function (e) {
    $(".fbutton").removeClass("fcurrent");
    $(this).addClass("fcurrent");
});
$(function () {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});

$(".fbutton").click(function (e) {
    $(".fbutton").removeClass("fcurrent");
    $(this).addClass("fcurrent");
});
$(function () {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange1 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange1').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});

$(document).ready(function () {
    $('#spouse_name').attr('disabled', 'disabled');
    $('select[name="marital_status"]').on('change', function () {
        var married = $(this).val();
        if (married == "Married") {
            $('#spouse_name').removeAttr('disabled');
        } else {
            $('#spouse_name').attr('disabled', 'disabled');
        }

    });
});
$(function () {
    $("#tabs").tabs();
});
// Parent Name copy function
function copyTextValue(bf) {
    if (bf.checked) {
        var text1 = document.getElementById("guardian_name").value;
        var text2 = document.getElementById("guardian_phone").value;
        $('#parent_name').attr('disabled', 'disabled');
        $('#parent_phone').attr('disabled', 'disabled');
    }
    else {
        text1 = '';
        text2 = '';
        $('#parent_name').removeAttr('disabled');
        $('#parent_phone').removeAttr('disabled');

    }
    document.getElementById("parent_name").value = text1;
    document.getElementById("parent_phone").value = text2;

    // document.getElementById("Name3").value=text1;

}
// Room Filter


$(function () {
    $("#tabs").tabs();
});

$(function () {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);


});

$(function () {
    $('input[id="date"]').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },

            singleDatePicker: true,
            showDropdowns: true
        },
        function (start, end, label) {
            var years = moment().diff(start, 'years');
            // alert("You are " + years + " years old.");
            $("#target").text(years);
            document.getElementById("target").value = years;
        });
});