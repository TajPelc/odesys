/**
 * Unset Project
 */
function unsetProject() {
    var allowedToBeRun = true;
    $('#project a.close').click(function(event){
        if(allowedToBeRun)
        {
            allowedToBeRun = false;
            div = $(this).parent();
            link = $(this);

            div.fadeOut(500, function(){
                link.remove();
                div.find('span.title:last, ul').remove();
                div.find('h1, p').removeAttr('style');
                div.find('div').attr('class', 'dotted');
                div.fadeIn(500, function(){
                    $.get(link.attr('href'), function(data){
                        window.location.replace(location.protocol + '//'+ location.hostname + location.pathname + '?r=project/index');
                        allowedToBeRun = false;
                    });
                });
            });

        }
        event.preventDefault();
    });
}

/**
 * On document load
 */
$(document).ready(function(){
    unsetProject();
});
