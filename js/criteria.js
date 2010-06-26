/**
 * On document load
 */
$(document).ready(function(){

    // change the submit buttons
    $(function() {
        $("input:submit, a.button").button();
    });

    // make the criteria sortable
    $(function() {
        $("#sortable").sortable({
            opacity: 0.90,
        });
        $("#sortable").disableSelection();
    });

    // rearrange order on sort
    $( "#sortable" ).bind( "sortupdate", function(event, ui) {
        $.get(location.href, {
            criteriaOrder: $(this).sortable('toArray').toString(),
        });
    });
});
