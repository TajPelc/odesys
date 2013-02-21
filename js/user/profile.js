/* Profile Settings javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

ProfileSettings = {};

/*
 * Document Ready
 * */
$(document).ready(function(){
    $('#deleteUser').click(function() {
        $.ajax({
            type: 'POST',
            url: '/user/delete/',
            dataType: 'json',
            data: {
                'partial': true
            },
            success: function(data) {
                if(data['status'] == true)
                {
                    Core.Overlay(data['html']);
                }
            }
        });

        $('#overlay #cancel').click(function(){
            Core.Overlay.Close();
        });
        return false;
    });

    //handle delete action
    $('#overlay #deleteUser').live('submit', (function(){
        // post the form
        $.ajax({
            type: 'POST',
            url: '/user/delete/',
            dataType: 'json',
            data: {
                'deleteUser': true
            },
            success: function(data) {
                if(data['status'] == true){
                    location.href = data['logoutUrl'];
                } else { // errors
                    Core.Overlay.Close();
                }
            }
        });
        return false;
    }));

    // delete decisions
    $('table .delete, table .edit').click(function() {
        ProfileSettings.getDecision = $(this);

        $.ajax({
            type: 'POST',
            url: $(this).attr('href'),
            dataType: 'json',
            data: {
                'partial': true
            },
            success: function(data) {
                if(data['status'] == true)
                {
                    Core.Overlay(data['html']);
                }
            }
        });

        $('#overlay #cancel').click(function(){
            Core.Overlay.Close();
        });
        return false;
    });


    //handle delete action
    $('#overlay #deleteDecision').live('submit', (function(){
        var data = {
            'decision': ProfileSettings.getDecision.parents('tr').attr('id')
        };
        // post the form
        $.ajax({
            type: 'POST',
            url: ProfileSettings.getDecision.attr('href'),
            dataType: 'json',
            data: data,
            success: function(data) {
                if(data['status'] == true){
                    //here be returned shite
                    ProfileSettings.getDecision.parents('tr').fadeOut('slow', function() {
                        $(this).remove();
                    });
                    Core.Overlay.Close();
                    //errors
                } else {

                }
            }
        });
        return false;
    }));

    //handle delete action
    $('#overlay #editDecision').live('submit', (function(){
        var newDecisionTitle = $(this).find('#title').val();
        var newDecisionDescription = $(this).find('#description').val();
        var data = {
            'decision': ProfileSettings.getDecision.parents('tr').attr('id'),
            'title' : newDecisionTitle,
            'description' : newDecisionDescription
        };
        // post the form
        $.ajax({
            type: 'POST',
            url: ProfileSettings.getDecision.attr('href'),
            dataType: 'json',
            data: data,
            success: function(data) {
                if(data['status'] == true){
                    //update title in the table
                    ProfileSettings.getDecision.parents('tr').find('td:first a').text(newDecisionTitle);
                    //update to the correct url
                    ProfileSettings.getDecision.parents('tr').find('td:first a').attr('href', '/decision/' + data['id'] + '-' + data['url'] + '.html');
                    Core.Overlay.Close();
                    //errors
                } else {

                }
            }
        });
        return false;
    }));

    /*var facebook = 'facebook';
    var twitter = 'twitter';
    var google = 'google_oauth';
    var linkedin = 'linkedin';
    var github = 'github';

    //handle connected accounts
    if( $('section.accounts h1').hasClass(facebook)){
        $('.services').find('li.' + facebook).addClass('connected');
    }
    if( $('section.accounts h1').hasClass(twitter) ){
        $('.services').find('li.' + twitter).addClass('connected');
    }
    if( $('section.accounts h1').hasClass(google) ){
        $('.services').find('li.' + google).addClass('connected');
    }
    if ( $('section.accounts h1').hasClass(linkedin) ){
        $('.services').find('li.' + linkedin).addClass('connected');
    }
    if ( $('section.accounts h1').hasClass(github) ){
        $('.services').find('li.' + github).addClass('connected');
    }*/

    var sns = {
        'facebook': 'facebook',
        'twitter':  'twitter',
        'google':   'google_oauth',
        'linkedin': 'linkedin',
        'github':   'github'
    };

    $.each(sns, function(key, value){
        if( $('section.accounts h1').hasClass(key)){
            var that = $('.services').find('li.' + value);
            that.addClass('connected');

            var aHtml = that.children('a').html();
            var aClass = that.children('a').attr('class');
            that.children('a').after('<span></span>')
            that.children('a').remove();
            that.children('span').html(aHtml).addClass(aClass).append('<div class="enabled"></div>');
            that.children('span.auth-link').css('opacity', 0.5);


            that.children('a').click(function(e){
                var html = $(this).html();
                var cssClass = $(this).attr('class');
                $(this).remove();
                alert(cssClass);
                //$(this).css('cursor', 'normal')
                return false;
            })
        }
    })
});