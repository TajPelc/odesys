/**
 * On document load
 */
$(document).ready(function(){
    $(function() {
        $("a.button").button();
    });

    $('#create').click(function(event){
        projectOverlay($(this).attr('href'), true);
        event.preventDefault();
    });
});
