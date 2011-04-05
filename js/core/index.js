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

Core.Overlay = function(){
    $('body').append('<div id="overlay_bg"><div id="overlay"><h2>Name your decision:</h2><form method="post" action=""><fieldset><input type="text" name="project_title" id="project_titile" /><input type="submit" name="project_save" id="project_save" value="Start" /></fieldset></form></div></div>');
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
            'title'   : $.trim($(this).serialize()),
            'action'  : 'create'
        }
        $.ajax({
            type: 'POST',
            url: Core.Overlay.Url,
            dataType: 'json',
            data: Core.Overlay.Data,
            success: function(data) {
                // success
                if(data['status'] == true)
                {
                    $('#overlay_bg').remove();
                    $(location).attr('href', location.href.split('/')[0]+'//'+location.href.split('/')[2]+'/index.php?r=criteria/create');
                }
                else {
                    $('#overlay').remove();
                    $('#overlay_bg').append('<div id="overlay"><h2>Error!</h2><p>'+data['errors'][0]+'</p></div>')
                    $('#overlay').css({'left': ($(window).width()-$('#overlay').width())/2, 'top': '150px'});
                }
            }
        });
        return false;
    });
}

Core.Overlay.Warning = function(){
    $('body').append('<div id="overlay_bg"><div id="overlay"><h2>Make a new decision?</h2><p>Do not panic. Your project is saved safely in our database, no worries. With creating a new project you will deactivate your current one <i>'+$('#headings h2').text().split('"')[0]+'</i>.</p><a class="button" href="#">YES, continue!</a></div></div>');
    $('#overlay').css({'left': ($(window).width()-$('#overlay').width())/2, 'top': '150px'});
    $('#overlay .button').click(function(){
        $('#overlay_bg').remove();
        Core.Overlay();
    });
}

$(document).ready(function(){
    // Preload images
    ImagePreload([
             '/images/bg/ferlauf.png',
             '/images/logo.png'
     ]);

    $('#login .projectNew').click(function(){
        if($(this).hasClass('active')){
            Core.Overlay.Warning();
        } else {
            Core.Overlay();
        }
        return false;
    });
});