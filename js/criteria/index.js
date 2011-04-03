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
                }
            }
        });
    });

    Criteria.DREKSMRDI = function(that) {
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
                        that.siblings('.add').remove();
                        that.parent().append('<span class="remove">-</span>');
                        that.attr('id', 'criteria_'+data['criteria_id']);
                        that.parents('ol').append('<li><input type="text" id="newCriteria" name="" value="" /><span class="add">+</span></li>');
                        that.parent().next().children().focus();
                    }
                    //errors
                    else {
                    }
                }
            });
        }

    }

    $('#content form li:last-child input[type="text"]').live('blur', function(){
        Criteria.DREKSMRDI($(this));
    });

    $('#content form li:last-child input[type="text"]').live('keypress', function(e){
        if(e.which == '13'){
            Criteria.DREKSMRDI($(this));
        }
    });


    // if enter, fake blur
    $('#content form li:not(:last-child) input[type="text"]').live('keypress', function(e){
        if(e.which == '13'){
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
                }
            }
        });
    });

    // clicking add button fakes blur event
    $('#content form li .add').live('click', function(){
        $('#content form li:last-child input[type="text"]').blur();
    });

    $('#content form').submit(function(){
        return false;
    });
});