/* Core javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

function ImagePreload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        $('<img/>')[0].src = this;
    });
}

Core = {};

Core.Overlay = function(html){
    Core.Overlay.Close();

    $('body').append('<div id="overlay_bg"><div id="overlay">'+html+'</div></div>');
    $('#overlay').css({'left': ($(window).width()-$('#overlay').width())/2, 'top': '150px'});

    //delay input focus hack
    Core.Overlay.Focus = function() {
        $('#overlay').find('input[type="text"]').focus();
    }
    setTimeout('Core.Overlay.Focus()', 20);

    $('#overlay form input[type="text"]').keypress(function(e){
        if(e.which == 13){
            $(this).parents('form').triggerHandler('submit');
            return false;
        }
    });
    //on submit
    $('#overlay form').submit(function(){
        Core.Overlay.Url = location.href.split('/')[0]+'//'+location.href.split('/')[2]+'/index.php?r=project/create';
        Core.Overlay.Data = {
            'title'   : $.trim($(this).find('input[type="text"]').val()),
            'action'  : 'create'
        }

        //post project title
        $.ajax({
            type: 'POST',
            url: Core.Overlay.Url,
            dataType: 'json',
            data: Core.Overlay.Data,
            success: function(data) {
                // success
                if(data['status'] == true)
                {
                    Core.Overlay.Close();
                    $(location).attr('href', location.href.split('/')[0]+'//'+location.href.split('/')[2]+'/index.php?r=criteria/create');
                }
                else {
                    //$('#overlay form').insertAfter('<span>'+data['errors']['title']+'</span>');
                    Core.Overlay.FormErrorReporting($('#overlay form'), data['errors']['title']);
                }
            }
        });
        return false;
    });

    $('body').live('keyup', function(e){
        if(e.which == 27){
            Core.Overlay.Close();
        }
    });
}


Core.Overlay.FormErrorReporting = function(that, text){
    if(!$('#overlay .error').length == 0){
        $('#overlay .error').remove();
    }
    that.append('<div class="error"><p>'+text+'</p></div>');
    that.find('input[type="text"]').focus();
}

Core.Overlay.Close = function() {
    $('#overlay').remove();
    $('#overlay_bg').remove();
}

/*
 * Document Ready
 * */

$(document).ready(function(){
    // Preload images
    ImagePreload([
             '/images/bg/ferlauf.png',
             '/images/logo.png'
     ]);

    $('#login .projectNew').click(function(){
        if($(this).hasClass('active')){
            Core.Overlay.Html = '<h2>Make a new decision?</h2><form method="post" action=""><fieldset><input type="text" name="project_title" id="project_titile" /><input type="submit" name="project_save" id="project_save" value="Start" /><p>Do not panic. Your project is saved safely in our database. With creating a new project you will deactivate "<i>'+$('#headings h2').text().split('"')[1]+'</i>".</p></fieldset></form>'
            Core.Overlay(Core.Overlay.Html);
        } else {
            Core.Overlay.Html = '<h2>Name your decision:</h2><form method="post" action=""><fieldset><input type="text" name="project_title" id="project_titile" /><input type="submit" name="project_save" id="project_save" value="Start" /></fieldset></form>';
            Core.Overlay(Core.Overlay.Html);
        }
        return false;
    });
});