/* Core javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.2
*/

Core = {};

function ImagePreload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        $('<img/>')[0].src = this;
    });
}

/**
 * Overlay, currently create new project
 *
 * @param string
 * @returns void
 */
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

    // on escape, close overlay
    $('html').live('keyup', function(e){
        if(e.which == 27){
            Core.Overlay.Close();
        }
    });
}

/**
 * Overlay errors
 *
 * @param object, str
 * @returns void
 */
Core.Overlay.FormErrorReporting = function(that, text){
    if(!$('#overlay .error').length == 0){
        $('#overlay .error').remove();
    }
    that.append('<div class="error"><p>'+text+'</p></div>');
    that.find('input[type="text"]').focus();
}

/**
 * Overlay close
 *
 * @param void
 * @returns void
 */
Core.Overlay.Close = function() {
    $('#overlay').remove();
    $('#overlay_bg').remove();
}

/**
 * Blocker
 *
 * @param object
 * @returns void
 */
Core.Block = function(that, rounded){
    that.append('<div class="block"><img src="/images/ajax-loader.gif" /></div>');
    $('.block').each(function(index, element){
        if (rounded){
            $(element).addClass('rounded');
        }
        $(element).width($(element).parent().outerWidth());
        $(element).height($(element).parent().outerHeight());
        $(element).find('img').css({
            'top': ($(element).height()-$(element).children('img').height())/2,
            'left': ($(element).width()-$(element).children('img').width())/2
        });
    });
}

/**
 * Unblocker
 *
 * @param object
 * @returns void
 */
Core.Unblock = function(that){
    Core.Unblock.Block = that.find('.block').fadeOut(200);

    setTimeout('Core.Unblock.Block.remove()', 200);
}

/**
 * Animate Project Menu
 *
 * @param array
 * @returns void
 */
Core.ProjectMenu = function(projectMenu){
    //define
    /*Core.ProjectMenu.Selected = $('#project .selected');
    Core.ProjectMenu.Next = Core.ProjectMenu.Selected.parents('li').next();

    if (url !== false) {
        if (Core.ProjectMenu.Next.find('a').length == 0){
            //animate progress bar - extend
            Core.ProjectMenu.Selected.siblings('.loadingBar.end').animate({
                'width': Core.ProjectMenu.Selected.siblings('.loadingBar.end').outerWidth() + Core.ProjectMenu.Selected.parents('li').outerWidth(true)
            }, 500);
            //remove span, add link
            Core.ProjectMenu.Next.append('<a href="'+url+'" id="'+Core.ProjectMenu.Next.find('span').attr('id')+'" title="'+Core.ProjectMenu.Next.find('span').text()+'">'+Core.ProjectMenu.Next.find('span').text()+'</a>');
            Core.ProjectMenu.Next.find('span').remove();
        }
    } else {
        if (Core.ProjectMenu.Next.find('a').length > 0){
            //animate progress bar - shrink
            Core.ProjectMenu.Selected.siblings('.loadingBar.end').animate({
                'width': Core.ProjectMenu.Selected.siblings('.loadingBar.end').outerWidth() - Core.ProjectMenu.Selected.parents('li').outerWidth(true)
            }, 500);
            //remove link, add span
            Core.ProjectMenu.Next.append('<span id="'+Core.ProjectMenu.Next.find('a').attr('id')+'" title="'+Core.ProjectMenu.Next.find('a').text()+'">'+Core.ProjectMenu.Next.find('a').text()+'</span>');
            Core.ProjectMenu.Next.find('a').remove();
        }
    }*/





  //define
    Core.ProjectMenu.Lists = $('#project li');
    Core.ProjectMenu.LoadingBar = $('#project .loadingBar.end');

    Core.ProjectMenu.Lists.each(function(index, element){
        Core.ProjectMenu.Lists.Span = $(element).children('span').not('loadingBar');
        Core.ProjectMenu.Lists.Anchor = $(element).children('a');

        if (!Core.ProjectMenu.Lists.Span.hasClass('loadingBar')){
            Core.ProjectMenu.Lists.Span.Id = Core.ProjectMenu.Lists.Span.attr('id').split("-")[1];
            if ($(element).children('span').not('.loadingBar').length > 0 && projectMenu[Core.ProjectMenu.Lists.Span.Id] !== false){
                Core.ProjectMenu.Lists.A = $('<a></a>')
                .attr('href', projectMenu[Core.ProjectMenu.Lists.Span.Id])
                .attr('title', Core.ProjectMenu.Lists.Span.text())
                .attr('id', Core.ProjectMenu.Lists.Span.attr('id'))
                .html(Core.ProjectMenu.Lists.Span.text())
                .css({display: 'block'}) // IE hack
                .hide();

                //animate progress bar - extend
                Core.ProjectMenu.LoadingBar.animate({
                    'width': Core.ProjectMenu.LoadingBar.outerWidth() + Core.ProjectMenu.LoadingBar.parents('li').outerWidth(true)
                }, 500);

                Core.ProjectMenu.Lists.Span.fadeOut(200, function(){
                    $(this).remove()
                    Core.ProjectMenu.Lists.A.appendTo($(element)).fadeIn(500);
                });
            } else if (Core.ProjectMenu.Lists.Anchor.length > 0 && projectMenu[Core.ProjectMenu.Lists.Anchor.attr('id')] == false) {
                Core.ProjectMenu.Lists.S = $('<span></span>')
                .attr('id', Core.ProjectMenu.Lists.Anchor.attr('id'))
                .html(Core.ProjectMenu.Lists.Anchor.text())
                .css({display: 'block'}) // IE hack
                .hide();

              //animate progress bar - shrink
                Core.ProjectMenu.LoadingBar.animate({
                    'width': Core.ProjectMenu.LoadingBar.outerWidth() - Core.ProjectMenu.LoadingBar.parents('li').outerWidth(true)
                }, 500);
            }

        }


    });
}

/*
 * Document Ready
 * */
$(document).ready(function(){
    // Preload images
    ImagePreload([
             '/images/bg/ferlauf.png',
             '/images/bg/overlay.png',
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