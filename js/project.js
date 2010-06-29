/**
 * On document load
 */
$(document).ready(function(){
    // make input buttons pretty
    $(function() {
        $("input:submit, a.button").button();
    });

    runnable = true;
    // handle the setting of projects as active
    $('ul.projects li a').click(function(event){
        if(runnable)
        {
            runnable = false;
            title = $(this).attr('title');
            link = $(this);
            li = $(this).parent();
            activeLi = $('ul.projects li.active');

            // request clicked project to be set as active
            $.get(link.attr('href'), function(data){
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
                        runnable = true;
                });
            });

            // request project menu HTML and replace the current menu
            $.get('/index.php?r=project/menu', function(data){
                projectMenu =  data['menu'];
                $('#project div').fadeOut(150, function(){
                    $(this).remove();
                    $('#project').append(projectMenu);
                    $('#project div').animate({ opacity: 1,}, 150, 'linear');
                });
            });

            // call unset method again
            unsetProject();
        }
        event.preventDefault();
    });
});
