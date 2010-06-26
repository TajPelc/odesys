/**
 * Unset Project
 */
function unsetProject() {
    $('#project div a.title').click(function(event){
        div = $(this).parent();
        url = $(this).attr('href');

        div.fadeOut(500, function(){
                div.find('a.title, ul').remove();
                div.find('h1, p').removeAttr('style');
                div.attr('class', 'dotted');
                div.fadeIn(500, function(){
                    $.get(url, function(data){
                        window.location.replace(location.protocol + '//'+ location.hostname + location.pathname + '?r=project/index');
                    });
                });
            });

        event.preventDefault();
    });
}

/**
 * On document load
 */
$(document).ready(function(){
    unsetProject();
});
