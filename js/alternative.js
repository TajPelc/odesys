/**
 * On document load
 */
$(document).ready(function(){
    $(function() {
        $("input:submit, a.button").button();
    });

    // disable the non-ajax form
    $('div.form').remove();
});
