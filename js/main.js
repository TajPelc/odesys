// preload image
var loadingImage = $('<img>').attr('src', '/images/ajax-loader.gif');

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
 * On document load
 */
$(document).ready(function(){
    unsetProject();
});