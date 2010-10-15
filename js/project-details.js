/**
 * On document load
 */
$(document).ready(function(){
    // make input buttons pretty
    $("a.button").button();

    // open project overlay
    $('#create').click(function(event){
        projectOverlay($(this).attr('href'));
        event.preventDefault();
    });
});
