/**
 * On document load
 */
$(document).ready(function(){
    $(function() {
        $("#sortable").sortable({
            opacity: 0.90,
        });
        $("#sortable").disableSelection();
    });

    $( "#sortable" ).bind( "sortupdate", function(event, ui) {
        $.get(location.href, {
            criteriaOrder: $(this).sortable('toArray').toString(),
        });
    });
});
