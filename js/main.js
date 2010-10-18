// preload image
var loadingImage = $('<img>').attr('src', '/images/ajax-loader.gif');

/**
 * Extract numbers from a string
 * @param string
 */
function extractNumbers(str)
{
    return str.match(/\d+(,\d{3})*(\.\d{1,2})?/g);
}
/**
 * Escape HTML characters
 * @param str
 * @return str
 */
function escapeString(str) {
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
 * Show the loading image
 *
 * @return void
 */
function startLoading(showOverlayBg, overlayElement) {
    overlayBg = 'overlay_bg';
    if(true === showOverlayBg)
    {
        overlayBg = 'ui-widget-overlay';
    }
    if(overlayElement){
        overlay = $('<div />').attr('id', 'overlay_bg').addClass(overlayBg).appendTo(overlayElement);
        loadingBar = $('<div />').attr('id', 'loading').html(loadingImage).addClass('loadingImage').appendTo(overlayElement);
    }
    else{
        overlay = $('<div />').attr('id', 'overlay_bg').addClass(overlayBg).appendTo('body');
        loadingBar = $('<div />').attr('id', 'loading').html(loadingImage).addClass('loadingImage').appendTo('body');
    }

    if(undefined !== overlayElement)
    {
        if(!overlayElement instanceof Object)
        {
            element = $(overlayElement);
        }
        else
        {
            element = overlayElement;
        }
        position = element.position();
        position['left'] += parseInt(element.css('margin-left'), 10);
        position['top']  += parseInt(element.css('margin-top'), 10);
        width = element.outerWidth();
        height = element.outerHeight();

        overlay.css({
            position: 'absolute',
            width: width,
            height: height,
            left: position['left'],
            top: position['top'],
            MozBorderRadius: element.css('-moz-border-radius-topleft'),
        });

        loadingBar.css({
            position: 'absolute',
            left: position['left'] + parseInt(width / 2) - parseInt(loadingImage.parent().width() / 2),
            top: position['top'] + parseInt(height / 2) - parseInt(loadingImage.parent().height() / 2),
        });
    }

    overlay.show();
    loadingBar.show();
}

/**
 * Remove the overlay
 *
 * @return void
 */
function stopLoading(){
    $('#overlay_bg, #loading').fadeOut('slow').remove();
}


/**
 * Open project create/edit overlay
 *
 * @param url
 * @return
 */
function projectOverlay(url, rdr, forceNew, replaceWithData) {
    forceCreateNew = 'no';
    if(undefined != forceNew)
    {
        forceCreateNew = 'yes';
    }
    startLoading(true);
    $.post(
        url, {
            requesting: 'form',
            forceNew: forceCreateNew,
        },
        function(data){
            stopLoading();
            // set parameters
            title = 'Create a new project';
            if(data['edit'])
            {
                title = 'Edit project';
            }
            anchor = '#project'

             // create form element from the returned html
             form = $('<div></div>').attr('class', 'form').attr('title', title).attr('id', 'dialog-form').html(data['form']);

             // add dialog functionality to the form element
             form.dialog({
                 autoOpen: false,
                 width: 750,
                 modal: true,
                 resizable: false,
                 position:['center', 50],
                 buttons: {
                 // what goes on on create / edit
                 'Save': function() {

                 // disable buttons
                     $('button').attr('disabled', 'disabled');

                     // add an additional input to the form
                     $(anchor + '-form').append($('<input />').attr({
                         type: 'hidden',
                         name: 'requesting',
                         value: 'formPost',
                     }));

                     startLoading();

                     // post the form
                     $.ajax({
                         type: 'POST',
                         url: url,
                         data: $(anchor + '-form').serialize(), // serialize values from the form
                         success: function(data) {
                         stopLoading();
                         // errors
                         if(data['status'] == false)
                         {
                             // form returned
                             if(data.hasOwnProperty('form'))
                             {
                                 // replace the contents of the form
                                 form.html(data['form']);

                                 // reenable buttons
                                 $('button').removeAttr('disabled');
                                 $('button').removeClass('ui-state-focus');
                             }
                         }
                         else
                         {
                             stopLoading();

                             // close the dialog
                             form.dialog('close');
                             // remove form
                             form.remove();

                             // redirect to details page
                             if(undefined !== rdr)
                             {
                                 redirectUser('criteria/create');
                             }

                             if(replaceWithData)
                             {
                                 // replace title
                                 $('#projectUrl h1').fadeOut('slow', function(){
                                     $(this).html(escapeString(data['title'])).fadeIn('slow');
                                     $('#project-disabled').html(escapeString(data['title'])).fadeIn('slow');
                                 });

                                 $('#showProjectDescription dd').fadeOut('slow', function(){
                                     $(this).html(escapeString(data['description']).replace(/\n/g,'<br />')).fadeIn('slow');
                                 });
                             }
                         }
                     }
                 });

             },
             Cancel: function() {
                 if(forceNew)
                 {
                     redirectUser('site/index');
                 }
                 $(this).dialog('close');
                 form.remove();
             }
             },
             close: function() {
                 // remove focus from add button
                 $('#create').removeClass('ui-state-focus');
             }
             });

             // open dialog
             form.dialog('open');
             $('div.ui-widget-header').removeClass('ui-widget-header').addClass('overlay-heading');
             $('#dialog-form input:eq(0)').focus();
     });
}

/**
 * Add a notice that the project is still active
 * @return
 */
function addActiveProjectNotice()
{
    /**
     * Display active project floating warning
     */
    if($('#display-project-warning').length == 1)
    {
        // get position
        position = $('#display-project-warning').position();

        // append to page and calculate position
        $('#page').append($('<div id="hint"><p><em>Your project is still active!</em></p><p><i>Don\'t forget to add it to your bookmarks or save the link.</i></p><span>&nbsp;</span></div>').css({
            top: (position['top'] + 54) +'px',
            left: (position['left'] + 153) +'px',
        }).fadeIn(500));
        setTimeout("$('#hint').animate({opacity: 0}, 1000, function() {$('#hint').remove()});", 5000);
    }
}

/**
 * Add hint text to project menu
 *
 * @return
 */
function addRestrictedHintText()
{
    // hint text for buble
    var menuHintText = new Array();
    menuHintText['menu-alternatives'] = 'Define at least 2 criteria.';
    menuHintText['menu-evaluation'] = 'Define at least 2 alternatives.';
    menuHintText['menu-analysis'] = 'Complete the evaluation!';
    menuHintText['menu-overview'] = 'Complete the evaluation!';

    // get list element width
    projectLiWidth = $('#project li').width();

    // bind the hint buble to all restricted spans
    $('#project li span.restricted').live({
        mouseenter:
            function()
            {
                $(this).parent().append('<div id="hint"><p><em>To enable this step:</em></p><p><i>' + menuHintText[$(this).attr('id')] + '</i></p><span>&nbsp;</span></div>');
                $('#project li #hint').css({
                    top: (0) +'px',
                    left: (projectLiWidth) +'px',
                })
            },
         mouseleave:
            function()
            {
                $('#project li #hint').remove();
            }
        }
     );
}

/**
 * Enable a link in the menu
 * @param id
 * @return void
 */
function handleProjectMenu(menu) {
    // not a valid menu
    if(!menu instanceof Object)
    {
        return;
    }

    // loop through the menu items
    $('#project div ul li span, #project div ul li a').each(function(){
        newItem = menu[$(this).attr('id')];

        // disable item
        if($(this).is('a') && newItem['enabled'] == false)
        {
            $(this).fadeOut('slow', function(){
                span = $('<span></span>')
                    .attr('id', $(this).attr('id'))
                    .attr('class', 'restricted')
                    .html($(this).html())
                    .hide();
                $(this).after(span).remove();
                span.fadeIn('slow');
            });
        }

        // enable item
        if($(this).is('span') && $(this).attr('class') == 'restricted' && newItem['enabled'])
        {
            var url = 'index.php?r=' + newItem['route'][0];
            $(this).fadeOut('slow', function(){
                link = $('<a></a>')
                .attr('href', url)
                .attr('title', $(this).html())
                .attr('id', $(this).attr('id'))
                .html($(this).html())
                .hide();

                $(this).after(link).remove();
                link.fadeIn('slow');
            });
        }
    });
}


/**
 * Animate the element by chaing it's backgrond color
 *
 * @param element
 * @param blinkTo
 * @param speed1
 * @param speed2
 * @param codeOnFinish
 * @param anchor
 * @return void
 */
function animateByColorChange(element, blinkTo, speed1, speed2, codeOnFinish)
{
    /// get background color
    var originalBgColor = element.css('background-color');

    // animate the emenent to the specified color and back
    element.animate({
            backgroundColor: blinkTo,
        },
        speed1,
        'linear',
        function() {
            element.animate({
                backgroundColor: originalBgColor,
                },
                speed2,
                'linear',
                function(){
                    if(typeof codeOnFinish == 'string')
                    {
                        eval(codeOnFinish);
                    }
                });
    });
}

/**
 * On document load
 */
$(document).ready(function(){
    // make projectUrl selectable
    $("#projectUrl_input").click(function(){
        $(this).select();
    });

    // make Add to bookmarks real deal
    $('#addToBookMarks').jFav();

    // create new project
    $('#createNewProject').click(function(event){

        // create dialog
        div = $('<div></div>').attr({
                id: 'dialog-confirm',
                title: 'Create a new project?',
            }).html('<p style="color: #596171"><span class="ui-icon ui-icon-alert" style="float:left; margin:3px 7px 20px 4px;"></span>Are you sure you want to continue opening a new project? Your current project will be lost unless you have saved the URL or added it to your bookmarks!</p>');

            // url
            url = $(this).attr('href');

            // add dialog functionality to the form element
            div.dialog({
              autoOpen: false,
              height: 200,
              width: 750,
              modal: true,
              resizable: false,
              buttons: {
                  'Yes, continue': function() {

                    // disable buttons
                    $('button').attr('disabled', 'disabled');

                    // call project overlay
                    projectOverlay(url, 'criteria/create', true);

                    // close the dialog
                    div.dialog('close');
                    div.remove();
                  },
                  Cancel: function() {
                      $(this).dialog('close');
                      $(this).remove();
                  }
              },
              close: function() {
              }
          });

            div.dialog('open');
            $('div.ui-widget-header').removeClass('ui-widget-header').addClass('overlay-heading');
            event.preventDefault();

        event.preventDefault();
    });

    addRestrictedHintText();
    addActiveProjectNotice();
});