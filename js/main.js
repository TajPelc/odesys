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
 * Redirect
 *
 * @param string url
 * @return
 */
function redirectUser(url) {
    window.location.replace(location.protocol + '//'+ location.hostname + location.pathname + '?r=' + url);
}

/**
 * Unset Project
 */
function unsetProject() {
    $('#project a.close').live('click', function(event){
        div = $(this).parent();
        link = $(this);

        // fadeout
        div.fadeOut(500, function(){
            $.get(link.attr('href'), function(data){
                window.location.replace(location.protocol + '//'+ location.hostname + location.pathname + '?r=site/index');
            });
        });

        event.preventDefault();
    });
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
    overlay = $('<div />').attr('id', 'overlay_bg').addClass(overlayBg).appendTo('body');
    loadingBar = $('<div />').attr('id', 'loading').html(loadingImage).addClass('loadingImage').appendTo('body');

    if(undefined !== overlayElement)
    {
        element = $(overlayElement);
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
function projectOverlay(url, rdr) {
    startLoading();
    $.post(
        url, {
        requesting: 'form'
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
                             // close the dialog
                             form.dialog('close');

                             // remove form
                             form.remove();

                             // redirect to details page
                             if(undefined !== rdr)
                             {
                                 stopLoading();
                                 redirectUser('criteria/create');
                             }
                         }
                     }
                 });

             },
             Cancel: function() {
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
     });
}


/**
 * On document load
 */
$(document).ready(function(){
    unsetProject();

    // make projectUrl selectable
    $("#projectUrl_input").click(function(){
        $(this).select();
    });

    // show projectMenu hint if conditions are not met
    var projectLi = $('#project li');
    projectLiWidth = projectLi.width();
    projectLi.children('span').hover(function(){
        $(this).parent().append('<div id="hint"><p>You cannot continue until all conditions are met!</p><em><i>Note: You need at least 2 criterias and 2 alternatives.</i></em><span></span></div>');
        $('#project li #hint').css({
            top: (0) +'px',
            left: (projectLiWidth) +'px',
        })
    }, function(){
        $('#project li #hint').remove();
    });


    $('#project li').each(function(){

    })

    // make Add to bookmarks real deal
    $('#addToBookMarks').jFav();

    /**
     * Display active project floating warning
     */
    if($('#display-project-warning').length == 1)
    {
        // get position
        position = $('#display-project-warning').position();

        // append to page and calculate position
        $('#page').append($('<div id="hint"><p>Your project is still active!</p><span>&nbsp;</span></div>').css({
            top: (position['top'] + 52) +'px',
            left: (position['left'] + 153) +'px',
        }).fadeIn(500));
        setTimeout("$('#hint').animate({opacity: 0}, 1000, function() {$('#hint').remove()});", 5000);
    }

});