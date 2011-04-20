/* Core javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.2
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
}

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
}

/**
 * Redirect
 *
 * @param string url
 * @return
 */
function redirectUser(url) {
    window.location.replace(location.protocol + '//'+ location.hostname + location.pathname + '?r=' + url);
}

/**
 * Overlay, currently create new project
 *
 * @param string
 * @returns void
 */
Core.Overlay = function(html){
    Core.Overlay.Close();

    $('body').append('<div id="overlay_bg"><div id="overlay">'+html+'<a href="#" class="close">close</a><div id="overlayBottom"></div></div></div>');
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
                    $(location).attr('href', location.href.split('/')[0]+'//'+location.href.split('/')[2]+'/index.php?r=alternative/create');
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

    $('#overlay .close').click(function(){
        Core.Overlay.Close();
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
    // select menu elements and loding bar
    var ListElements = $('#project li span[id*=menu-], #project li a[id*=menu-]');
    var loadingBar = $('#project span.loadingBar');

    // init counters
    var i = 0;
    var j = 0;
    ListElements.each(function(index, element){
        // get new value for this element from the ajax supplied array
        var newValue = projectMenu[$(this).attr('id').split("-")[1]];

        // count how many need to be enabled
        if($(this).is('span') && $(this).hasClass('selected') === false && newValue !== false )
        {
            i++;
        }
        // count how many need to be disabled
        else if($(this).is('a') && newValue === false )
        {
            j++;
        }
    });

    // calculate widths
    var extendBy = loadingBar.outerWidth() + (loadingBar.parents('li').outerWidth(true) * i); // extend
    var shrinkBy = loadingBar.outerWidth() - (loadingBar.parents('li').outerWidth(true) * j); // shrink
    (i > 0) ? newWidth = extendBy : newWidth = shrinkBy;


    // add arrow
    if(loadingBar.outerWidth() == 960 && newWidth < 960)
    {
        loadingBar.addClass('end');
    }

    // animate progress bar
    loadingBar.animate({
        'width': newWidth
    }, 500, function(){
        // remove arrow on last element
        if(newWidth == 960)
        {
            loadingBar.removeClass('end');
        }
    });

    // iterate through the elements
    ListElements.each(function(index, element){
        // get new value for this element from the ajax supplied array
        var newValue = projectMenu[$(this).attr('id').split("-")[1]];

        // enable element
        if($(this).is('span') && $(this).hasClass('selected') === false && newValue !== false )
        {
            // create link
            var link = $('<a></a>')
                .attr('href', newValue)
                .attr('title', $(this).text())
                .attr('id', $(this).attr('id'))
                .html($(this).text())
                .css({display: 'block'}) // IE hack
                .hide();

            Core.ProjectMenu.Animate($(this), link, extendBy);
        }
        // disable element
        else if($(this).is('a') && newValue === false )
        {
            // create span
            var span = $('<span></span>')
                .attr('id', $(this).attr('id'))
                .addClass('restricted')
                .html($(this).text())
                .css({display: 'block'}) // IE hack
                .hide();

            Core.ProjectMenu.Animate($(this), span, shrinkBy);
        }
    });
}

/**
 * Animate Project Menu
 *
 * @param DOMelement oldElement
 * @param DOMelement newElement
 * @param integer width
 * @returns void
 */
Core.ProjectMenu.Animate = function(oldElement, newElement){
    // insert new element
    oldElement.after(newElement);

    // fade out and remove link, fade in span
    oldElement.fadeOut(200, function(){
        oldElement.remove()
        newElement.fadeIn(500);
    });
}

/**
 * Replace multiple spans by just the last one and resize it to fit
 */
Core.ProjectMenu.initMenu = function()
{
    var spans = $('#project li').children('span.loadingBar');
    var lastSpan = spans.last();
    var spanCount = spans.length;
    spans.remove();
    $('#project li:first-child').prepend(lastSpan);

    lastSpan.css({'width': 20});
    lastSpan.css({
        'width': lastSpan.outerWidth() + (lastSpan.parents('li').outerWidth(true) * spanCount)
    });
}

/**
 * Handle previous / next button
 */
Core.ContentNav = {};
Core.ContentNav.toggle = function(nextStep, menu) {
    var li = $('#content-nav li.next');
    var element = li.find('a, span');

    if(menu[nextStep])
    {
        if(element.is('span'))
        {
            element.animate({color: 'white'}, 250, 'linear', function(){
                var a = $('<a></a>').attr('href', menu['criteria']).text(element.text());
                element.remove();
                li.append(a);
                li.removeClass('disabled');
            });
        }
    }
    else
    {
        if(element.is('a'))
        {
            element.animate({color: '#444a56'}, 250, 'linear', function(){
                var span = $('<span></span>').text(element.text());
                element.remove();
                li.append(span);
                li.addClass('disabled');
            });
        }
    }
}

Core.Help = function(){
    var help = $('#help');
    var helpButton = $('#helpButton');

    if (help.hasClass('shown')){
        help.fadeOut('fast', function(){
            help.removeClass('shown');
            helpButton.removeClass('active');
        });
    } else {
        help.addClass('shown');
        helpButton.addClass('active');
        help.fadeIn('fast');
    }
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

    // init menu
    Core.ProjectMenu.initMenu();

    $('#login .projectNew').click(function(){
        if($(this).hasClass('active')){
            Core.Overlay.Html = '<h2>Name your new decision?</h2><p>You are in the middle of a decision process! Are you sure you want to start a new one? Don’t worry, everything is safely saved in our database for you to continue at your convenience.</p><form method="post" action=""><fieldset><input type="text" name="project_title" id="project_titile" /><span>Example: buying a car</span><input type="submit" name="project_save" id="project_save" value="Start" /></fieldset></form>'
            Core.Overlay(Core.Overlay.Html);
        } else {
            Core.Overlay.Html = '<h2>Name your new decision:</h2><form method="post" action=""><fieldset><input type="text" name="project_title" id="project_titile" /><span>Example: buying a car</span><input type="submit" name="project_save" id="project_save" value="Start" /></fieldset></form>';
            Core.Overlay(Core.Overlay.Html);
        }
        return false;
    });

    //show or hide help
    $('#helpButton').toggle(function(){
        Core.Help();
    }, function(){
        Core.Help();
    });
    $('#help .helpClose').click(function(){
        Core.Help();
    });

});