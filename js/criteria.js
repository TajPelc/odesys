/**
 * On document load
 */
$(document).ready(function(){

    // change the submit buttons
    $(function() {
        $("input:submit, a.button").button();
    });

    // disable the non-ajax form
    $('div.form').remove();

    // handle the continue link
    handleSortableList();

    // rearrange order on sort
    $('#sortable').bind( "sortupdate", function(event, ui) {
        $(this).sortable('disable');
        animateByColorChange(ui.item, 200,200, '$("#sortable").sortable("enable");');
        $.get(location.href, {
            criteriaOrder: $(this).sortable('toArray').toString(),
        });
    });

    // bind create and edit events
    bindCreateOverlay('#create-criteria', '#criteria');
    bindEditOverlay('#sortable li a.edit', '#criteria');
    bindDeleteOverlay('#sortable li a.delete', '#criteria');

    // make the ul sortable
    makeSortable();
});

/**
 * Make the criteria list sortable
 *
 * @return void
 */
function makeSortable() {
    //
    $("#sortable").sortable({
            opacity: 0.90,
    });
    $("#sortable").disableSelection();
}