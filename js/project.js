/**
 * On document load
 */
$(document).ready(function(){
    // make input buttons pretty
    $("input:submit, a.button").button();

    var allowedToBeRun = true;
    // handle the setting of projects as active
    $('ul.projects li a').click(function(event){
        if(allowedToBeRun)
        {
            startLoading(false, '#project');
            allowedToBeRun = false;
            title = $(this).attr('title');
            link = $(this);
            li = $(this).parent();
            activeLi = $('ul.projects li.active');

            // get project id
            linkParts = link.attr('href').split('=');
            projectId = linkParts.pop();

            // change the current active li to non active
            activeLi.animate({
                borderBottomColor: '#596171;',
                borderLeftColor: '#596171;',
                borderRightColor: '#596171;',
                },
                300,
                'linear',
                function() {
                    $(this).removeAttr('class');
                    $(this).find('a').removeAttr('style');
            });
            activeLi.find('span').animate({
                backgroundColor: '#596171;',
                },
                300,
                'linear',
                function() {
                    $(this).remove();
            });

            // change the clicked element to active
            li.animate({
                borderBottomColor: '#ffd700;',
                borderLeftColor: '#ffd700;',
                borderRightColor: '#ffd700;',
                },
                300,
                'linear',
                function() {
                li.prepend('<span>' + title + '</span>');
                li.attr('class', 'active');
            });
            link.animate({
                backgroundColor: '#ffd700;',
                },
                300,
                'linear',
                function() {
                    $(this).attr('style', 'display: none;');
                    $('html, body').animate({scrollTop:0}, 'slow');
                    allowedToBeRun = true;
            });

            // request project menu HTML and replace the current menu
            $.get('/index.php?r=project/menu&project_id=' + projectId, function(data){
                $('#project span.title:last').fadeOut(150, function() {
                        $('#project').empty();
                        $('#project').append(data['menu']);
                        $('#project span.title:last').css({opacity: 0});
                        $('#project span.title:last').animate({opacity: 1}, 300);
                        stopLoading();
                });
            });
        }
        event.preventDefault();
    });

    // trigger a click function
    $('ul.projects p, ul.projects ul').click(function(){
        $(this).parent().find('a:visible').trigger('click');
    });
});
