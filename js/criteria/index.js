/* Criteria javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

Criteria = {};

Criteria.FormAddButton = function(that){
    that.after('<span class="add">+</span>');
}

Criteria.FormListButtons = function(that){
    that.parent().append('<span class="remove">-</span>');
    that.parent().append('<span class="drag">&nbsp;</span>');
}

Criteria.FormErrorReporting = function(that, text){
    that.addClass('error');
    that.after('<div class="error"><p>'+text+'</p></div>');
    $('#content form div.error').css({'top': -that.height()+2});
    that.focus();
}

Criteria.SaveInput = function(that, add) {
    //trim input values
    var trimValue = $.trim(that.val());
    that.val(trimValue);
    //add preloader
    Criteria.SaveInput.Loading = $('<span class="loading">&nbsp;</span>');
    that.after(Criteria.SaveInput.Loading);
    //post
    if (!that.val() == ''){
        var data = {
                'criteria_id': add ? that.attr('id') : that.attr('id').split('_')[1],
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
                        $('#content form ol').append('<li id="criteria_'+data['criteria_id']+'"><input type="text" id="criteria_'+data['criteria_id']+'" name="" value="'+that.val()+'" /><span class="remove">-</span><span class="drag">&nbsp;</span></li>');
                        that.focus();
                        that.val('');
                        Criteria.SaveInput.Loading.remove();
                        Core.ProjectMenu(data['projectMenu']);

                        //errors
                    } else {
                        Criteria.SaveInput.Loading.remove();
                        Criteria.FormErrorReporting(that, data['errors']['title']);
                    }

                //update field
                } else {
                    if(data['status'] == true){
                        // here be returned shite

                        //errors
                    } else {
                        Criteria.FormErrorReporting(that, data['errors']['title']);
                    }

                }
            }
        });
    }
}

Criteria.DeleteInput = function(that) {
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
                Core.ProjectMenu(data['projectMenu']);
            }
        }
    });
}


/*
 * Document Ready
 * */
$(document).ready(function(){
    //add or remove necessary elements
    Criteria.FormAddButton($('#content form div input'));
    Criteria.FormListButtons($('#content form li input'));
    $('#content form input[type="submit"]').remove();
    $('#content form div input').focus();

    //copy input ID's to list items
    $('#content form li input').each(function(){
        $(this).parents('li').attr('id', $(this).attr('id'));
    });

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
            Criteria.SaveInput($(this), true);
        }
    });
    $('#content form > div .add').live('click', function(){
        var that = $(this);
        Criteria.SaveInput(that.siblings('input'), true);
    });

    //update field
    $('#content form ol li input').live('focus', function(){
        Criteria.tempInputValue = $(this).val();
    });

    $('#content form ol li input').live('blur', function(){
        var that = $(this);
        if (Criteria.tempInputValue !== that.val()){
            Criteria.SaveInput($(this), false);
        }
    });

    $('#content form ol li input').live('keypress', function(e){
        var that = $(this);
        if (Criteria.tempInputValue !== that.val() && e.which == 13) {
            that.blur();
        }
    });

    //remove field
    $('#content form li .remove').live('click', function(){
        var that = $(this);
        Criteria.DeleteInput(that);
    });

    // make criteria list sortable
    $('#content form ol').sortable({
        opacity: 0.70,
        placeholder: 'placeholder',
        handle: '.drag',
        sort: function(){ // Ordered list fix by Bryan Blakey
            var $lis = $(this).children('li');
            $lis.each(function(){
                var $li = $(this);
                var hindex = $lis.filter('.ui-sortable-helper').index();
                if( !$li.is('.ui-sortable-helper') ){
                    var index = $li.index();
                    index = index < hindex ? index + 1 : index;

                    $li.val(index);

                    if( $li.is('.placeholder') ){
                        $lis.filter('.ui-sortable-helper').val(index);
                    }
                }
            });
        }
    });

    // update the position of criteria
    $('#content form ol').live( 'sortupdate', function(event, ui) {
        $.post(location.href, {
            criteriaOrder: $(this).sortable('toArray').toString(),
        });
    });

    //prevent form submission
    $('#content form').submit(function(){
        return false;
    });
});