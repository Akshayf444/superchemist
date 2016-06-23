$('document').ready(function () {
//    $(".datepicker").datepicker({
//        changeMonth: true,
//        changeYear: true,
//        dateFormat: 'yy-mm-dd'
//    });
    var dateToday = new Date();

    $('.datepicker').datepicker({
        dateFormat: "yy-mm-dd",
        minDate: null,
    });
});