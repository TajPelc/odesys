/**
 * On document load
 */
$(document).ready(function(){
    $(function() {
        $("input:submit, a.button").button();
    });

    $('ul.projects li a').click(function(event){
        title = $(this).html();
        link = $(this);
        li = $(this).parent();

        $.get(link.attr('href'), function(data){
            // fadeout selected span and remove it
            $('ul.projects li span').fadeOut(200, function(){
                $(this).parent().find('a').fadeIn(200);
                $(this).remove();
            });

            // fadeout link and show the span
            link.fadeOut(200, function(){
                li.append('<span style="display: none;">' + title +' (Active)</span>');
                li.find('span').fadeIn(200);
            });

            $.get('/index.php?r=project/menu', function(data){
                $('#project div').fadeOut(200, function(){
                    $(this).remove();
                    $('#project').append(data['menu']);
                    $('#project div').fadeIn();
                    unsetProject();
                });
            });
        });

        event.preventDefault();
    });
});
