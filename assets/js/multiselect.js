$('document').ready(function () {
    function initialise() {
        $('.multiselect option').each(function () {
            $(this).attr('selected', 'selected')
        });
    }

    function dropdown(selector) {
        $(selector).multiselect({
            numberDisplayed: 1,
            enableFiltering: true

        });
    }
});

