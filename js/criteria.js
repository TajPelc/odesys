/**
 * On document load
 */
$(document).ready(function(){

    // change the submit buttons
    $(function() {
        $("input:button, a.button").button();
    });

    // disable the non-ajax form
    $('div.form').remove();

    // handle the continue link
    handleSortableList();

    // rearrange order on sort
    $('#sortable').live( "sortupdate", function(event, ui) {
        $(this).sortable('disable');
        animateByColorChange(ui.item, '#FFD700', 200, 200, '$("#sortable").sortable("enable");');
        $.get(location.href, {
            criteriaOrder: $(this).sortable('toArray').toString(),
        });
    });

    // bind create and edit events
    bindCreateOverlay('#create', '#criteria');
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
            placeholder: 'placeholder',
    });
    $("#sortable").disableSelection();
}