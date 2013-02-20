/* Core javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.3
*/

Core = {};

/**
 * Preload images
 * @param arrayOfImages
 */
function ImagePreload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        $('<img/>')[0].src = this;
    });
}

/**
 * Extract numbers from a string
 * @param string
 */
Core.ExtractNumbers = function (str)
{
    return str.match(/\d+(,\d{3})*(\.\d{1,2})?/g);
};

/**
 * Escape HTML characters
 * @param str
 * @return str
 */
Core.EscapeString = function (str) {
    var div = document.createElement('div');
    var text = document.createTextNode(str);
    div.appendChild(text);
    return div.innerHTML;
};

/**
 * Redirect
 *
 * @param string url
 * @return
 */
function redirectUser(url) {
    window.location.replace(location.protocol + '//'+ location.hostname + url);
}

/**
 * Overlay, currently create new project
 *
 * @param string
 * @returns void
 */
Core.Overlay = function(html, big){
    Core.Overlay.Close();

    $('body').append('<div id="overlay_bg"><div id="overlay" '+ (big ? 'class="big"' : "" ) +'>'+html+'<a href="#" class="close">X</a><div id="overlayBottom"></div></div></div>');
    $('#overlay').css({'left': ($(window).width()-$('#overlay').width())/2-40, 'top': '150px', 'transform': 'scale(1, 1)'});
    $('#overlay_bg').css('height', $('#wrapper').height());

    //delay input focus hack
    Core.Overlay.Focus = function() {
        $('#overlay').find('input[type="text"]').focus();
    };
    setTimeout('Core.Overlay.Focus()', 20);

    $('#overlay form input[type="text"]').keypress(function(e){
        if(e.which == 13){
            $(this).parents('form').triggerHandler('submit');
            return false;
        }
    });

    //on submit
    $('#overlay #projectCreate').submit(function() {
        var formObject = $(this).serializeObject();
        Core.Overlay.Url = location.href.split('/')[0]+'//'+location.href.split('/')[2]+'/project/create/';
        Core.Overlay.Data = {
            'title'   : $.trim(formObject.title),
            'privacy' : formObject.privacy,
            'action'  : 'create'
        };

        //post project title
        $.ajax({
            type: 'POST',
            url: Core.Overlay.Url,
            dataType: 'json',
            data: Core.Overlay.Data,
            success: function(data) {
                console.log(data);
                // success
                if(data['status'] == true)
                {
                    Core.Overlay.Close();
                    $(location).attr('href', data['redirectUrl']);
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

    $('#overlay .close, #cancel').click(function(){
        Core.Overlay.Close();
        return false;
    });
};

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
};

/**
 * Overlay close
 *
 * @param void
 * @returns void
 */
Core.Overlay.Close = function() {
    $('#overlay').remove();
    $('#overlay_bg').remove();
};

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
};

/**
 * Unblocker
 *
 * @param object
 * @returns void
 */
Core.Unblock = function(that){
    Core.Unblock.Block = that.find('.block').fadeOut(200);

    setTimeout('Core.Unblock.Block.remove()', 200);
};

/**
 * Animate Project Menu
 *
 * @param array
 * @returns void
 */
Core.ProjectMenu = function(projectMenu){
    // select menu elements and loding bar
    var ListElements = $('#project li span[id*=menu-], #project li a[id*=menu-]');


    console.log(projectMenu);
    ListElements.each(function(index, element) {
        // get new value for this element from the ajax supplied array
        var value = projectMenu[$(this).attr('id').split("-")[1]];

        // count how many need to be enabled
        if($(element).is('span') && $(element).hasClass('selected') === false && value !== false )
        {
            // create link
            var link = $('<a></a>')
                .attr('href', value)
                .attr('title', $(element).text())
                .attr('id', $(element).attr('id'))
                .html($(element).text())
                .css({display: 'block'}) // IE hack
                .hide();

            Core.ProjectMenu.Animate($(element), link);
        }
        // count how many need to be disabled
        else if($(element).is('a') && value === false )
        {
            // create span
            var span = $('<span></span>')
                .attr('id', $(element).attr('id'))
                .addClass('restricted')
                .html($(element).text())
                .css({display: 'block'}) // IE hack
                .hide();

            Core.ProjectMenu.Animate($(element), span);
        }
    });
};

/**
 * Animate Project Menu
 *
 * @param DOMelement oldElement
 * @param DOMelement newElement
 * @param integer width
 * @returns void
 */
Core.ProjectMenu.Animate = function(oldElement, newElement) {
    oldElement.after(newElement);
    oldElement.remove();
    newElement.show();
};

/**
 * Handle previous / next button
 */
Core.ContentNav = {};
Core.ContentNav.toggle = function(nextStep, menu) {
    var li = $('#content-nav li.next');
    var element = li.find('a, span:not(.doors)');
    if(menu[nextStep])
    {
        if(element.is('span'))
        {
            var a = $('<a></a>').attr('href', menu[nextStep]).html(element.html());
            element.remove();
            li.append(a);
            li.removeClass('disabled');
        }
    }
    else
    {
        if(element.is('a'))
        {
            var span = $('<span></span>').html(element.html());
            element.remove();
            li.append(span);
            li.addClass('disabled');
        }
    }
};

/*
 * Document Ready
 * */
$(document).ready(function() {
    /**
     * Serialize object
     * @return {Object}
     */
    jQuery.fn.extend({
        serializeObject: function() {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function() {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        }
    });

    // Preload images
    ImagePreload([
         '/images/bg/banner.png'
     ]);

    //call overlay and insert text
    $('.loginNew').click(function(){
            $.ajax({
                type: 'POST',
                url: '/login/',
                dataType: 'json',
                success: function(data) {
                    if(data['status'] == true)
                    {
                        Core.Overlay(data['html']);
                    }
                }
            });
        return false;
    });
    $('.decisionNew').click(function(){
        $.ajax({
            type: 'POST',
            url: '/project/create/',
            dataType: 'json',
            success: function(data) {
                if(data['status'] == true)
                {
                    Core.Overlay(data['html']);
                }
            }
        });
        return false;
    });
});