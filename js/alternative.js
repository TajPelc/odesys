/**
 * On document load
 */
$(document).ready(function(){
    $(function() {
        $("input:submit, a.button").button();
    });

    // disable the non-ajax form
    $('div.form').remove();

    // handle the continue link
    handleSortableList();

    // bind create and edit events
    bindCreateOverlay('#create-alternative', '#alternative');
    bindEditOverlay('#sortable li a.edit', '#alternative');
    bindDeleteOverlay('#sortable li a.delete', '#alternative');
});