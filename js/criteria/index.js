/* Criteria javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

Criteria = {};

Criteria.FormAddButton = function(){
    $('#content form li:last-child input').after('<span class="add">+</span>');
}

Criteria.FormRemoveButton = function(){
    $('#content form li input').not(':last').parent().append('<span class="remove">-</span>');
}

Criteria.FormErrorReporting = function(that, text){
    if(that.siblings('div.error').length == 0){
        that.after('<div class="error"><p>'+text+'</p></div>');
        $('#content form div.error').css({'top': -that.height()-5});
        that.focus();
    }
}

$(document).ready(function(){
    Criteria.FormAddButton();
    Criteria.FormRemoveButton();
    $('#content form input[type="submit"]').css('display', 'none');
    $('#content form li:last-child input[type="text"]').focus();

    // prepare ajax
    url = $('#content form').attr('action');
    $.ajaxSetup({
        type: 'POST',
        url: url,
        dataType: 'json',
    });

    //if enter is pressed on input fields except last, jump to the next field
    $('#content form li:not(:last-child) input[type="text"]').live('blur', function(){
        var that = $(this);
        var trimValue = $.trim(that.val());
        that.val(trimValue);
        var data = {
                'criteria_id': that.attr('id').split('_')[1],
                'value'      : that.attr('value'),
                'action'     : 'save'
        };
        // post the form
        $.ajax({
            data: data,
            success: function(data) {
                // success
                if(data['status'] == true)
                {
                    // here be returned shite
                    that.removeClass('error');
                    that.siblings('div.error').remove();
                    that.attr('id', 'criteria_'+data['criteria_id']);
                }
                else {
                    that.addClass('error');
                    Criteria.FormErrorReporting(that, data['errors']['title']);
                }
            }
        });
    });

    Criteria.DREKSMRDI = function(that) {
        var trimValue = $.trim(that.val());
        that.val(trimValue);
        if (!that.val() == ''){
            var data = {
                    'criteria_id': that.attr('id'),
                    'value'      : that.attr('value'),
                    'action'     : 'save'
            };
            // post the form
            $.ajax({
                data: data,
                success: function(data) {
                    // success
                    if(data['status'] == true)
                    {
                        // here be returned shite
                        that.removeClass('error');
                        that.siblings('div.error').remove();
                        that.attr('id', 'criteria_'+data['criteria_id']);
                        that.parents('ol').append('<li><input type="text" id="newCriteria" name="" value="" /><span class="add">+</span></li>');
                        that.siblings('.add').remove();
                        that.parent().append('<span class="remove">-</span>');
                        that.parent().next().children().focus();
                    }
                    //errors
                    else {
                        that.addClass('error');
                        Criteria.FormErrorReporting(that, data['errors']['title']);
                    }
                }
            });
        }
    }
    $('#content form li:last-child input[type="text"]').live('blur', function(){
        var that = $(this);
        if (!that.val() == '') {
            Criteria.DREKSMRDI($(this));
        }
    });
    $('#content form li:last-child input[type="text"]').live('keypress', function(e){
        var that = $(this);
        if (!that.val() == '' && e.which == 13) {
            Criteria.DREKSMRDI($(this));
        }
    });

    // if enter, fake blur
    $('#content form li:not(:last-child) input[type="text"]').live('keypress', function(e){
        if(e.which == '13' && !$(this).hasClass('error')){
            $(this).parent().next().children().focus();
        }
    });

    // clicking remove
    $('#content form li .remove').live('click', function(){
        var that = $(this);
        data = {
                'criteria_id': that.siblings('input').attr('id').split('_')[1],
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
                    $('#content form li:last-child input[type="text"]').focus();
                }
            }
        });
    });

    // clicking add button fakes blur event
    $('#content form li .add').live('click', function(){
        Criteria.DREKSMRDI($(this));
    });

    $('#content form').submit(function(){
        return false;
    });
});