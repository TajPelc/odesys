/* Alternatives javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.1
*/

Alternatives = {};

Alternatives.FormAddButton = function(that){
    that.after('<span class="add">+</span>');
}

Alternatives.FormListButtons = function(that){
    that.parent().append('<span class="remove">-</span>');
}

Alternatives.FormErrorReporting = function(that, text){
    that.addClass('error');
    that.after('<div class="error"><p>'+text+'</p></div>');
    $('#content form div.error').css({'top': -that.height()+2});
    that.focus();
}

Alternatives.SaveInput = function(that, add) {
    //trim input values
    var trimValue = $.trim(that.val());
    that.val(trimValue);
    //post
    if (!that.val() == ''){
        //add preloader
        Alternatives.SaveInput.Loading = $('<span class="loading">&nbsp;</span>');
        that.after(Alternatives.SaveInput.Loading);
        var data = {
                'alternative_id': add ? that.attr('id') : that.attr('id').split('_')[1],
                'value'      : that.attr('value'),
                'action'     : 'save'
        };
        // post the form
        $.ajax({
            data: data,
            success: function(data) {
                //if previous error exist, remove them
                if (that.hasClass('error')){
                    that.removeClass('error');
                    that.siblings('div.error').remove();
                }
                //add new field
                if (add){
                    if(data['status'] == true){
                        // here be returned shite
                        $('#content form ol').append('<li><input type="text" id="alternative_'+data['alternative_id']+'" name="" value="'+that.val()+'" /><span class="remove">-</span></li>');
                        that.focus();
                        that.val('');
                        Alternatives.SaveInput.Loading.remove();
                        Core.ProjectMenu(data['projectMenu']);
                        Alternatives.handleButtons(data['projectMenu']);

                        //errors
                    } else {
                        Alternatives.SaveInput.Loading.remove();
                        Alternatives.FormErrorReporting(that, data['errors']['title']);
                    }

                //update field
                } else {
                    if(data['status'] == true){
                        // here be returned shite
                        that.siblings('.loading').remove();

                        //errors
                    } else {
                        that.siblings('.loading').remove();
                        Alternatives.FormErrorReporting(that, data['errors']['title']);
                    }

                }
            }
        });
    }
}

Alternatives.DeleteInput = function(that) {
    //add preloader
    Alternatives.DeleteInput.Loading = $('<span class="loading">&nbsp;</span>');
    that.after(Alternatives.DeleteInput.Loading);
    data = {
            'alternative_id': that.siblings('input').attr('id').split('_')[1],
            'action'     : 'delete'
    };
    // post the form
    $.ajax({
        data: data,
        success: function(data) {
            // success
            if(data['status'] == true)
            {
                that.parents('li').remove();
                Core.ProjectMenu(data['projectMenu']);
                Alternatives.handleButtons(data['projectMenu']);
                Alternatives.DeleteInput.Loading.remove();
            } else {
                Alternatives.DeleteInput.Loading.remove();
            }
        }
    });
}

/**
 * Handle next button
 */
Alternatives.handleButtons = function(menu) {
    // next button
    var next = $('#content-nav li.next a');

    // check if next button should be enabled or disabled
    var nextEnabled = false;
    if(menu == undefined)
    {
        nextEnabled = $('#menu-criteria').is('a');
    }
    else
    {
        nextEnabled = (false != menu['criteria']);
    }

    // hide next button
    if(nextEnabled)
    {
        next.fadeIn(500);
    }
    else
    {
        next.fadeOut(500);
    }
}


/*
 * Document Ready
 * */
$(document).ready(function(){
    //add or remove necessary elements
    Alternatives.FormAddButton($('#content form div input'));
    Alternatives.FormListButtons($('#content form li input'));
    $('#content form input[type="submit"]').remove();
    $('#content form div input').focus();

    // hide navigation
    $('#content-nav').find('li a').hide();
    Alternatives.handleButtons();

    //prepare ajax
    url = $('#content form').attr('action');
    $.ajaxSetup({
        type: 'POST',
        url: url,
        dataType: 'json',
    });

    //add new field
    $('#content form > div input').live('keypress', function(e){
        if (e.which == 13) {
            var that = $(this);
            Alternatives.SaveInput($(this), true);
        }
    });
    $('#content form > div .add').live('click', function(){
        var that = $(this);
        Alternatives.SaveInput(that.siblings('input'), true);
    });

    //update field
    $('#content form ol li input').live('focus', function(){
        Alternatives.tempInputValue = $(this).val();
    });

    $('#content form ol li input').live('blur', function(){
        var that = $(this);
        if (Alternatives.tempInputValue !== that.val()){
            Alternatives.SaveInput($(this), false);
        }
    });

    $('#content form ol li input').live('keypress', function(e){
        var that = $(this);
        if (Alternatives.tempInputValue !== that.val() && e.which == 13) {
            that.blur();
        }
    });

    //remove field
    $('#content form li .remove').live('click', function(){
        var that = $(this);
        Alternatives.DeleteInput(that);
    });

    //prevent form submission
    $('#content form').submit(function(){
        return false;
    });
});