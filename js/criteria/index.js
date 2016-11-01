/* Criteria javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.2
*/

Criteria = {};

Criteria.FormAddButton = function(that){
    that.after('<span class="add" onclick = "void(0)">+</span>');
}

Criteria.FormListButtons = function(that){
    that.parent().append('<span class="remove" onclick = "void(0)">&ndash;</span>');
    that.parent().append('<span class="drag" onclick = "void(0)">&nbsp;<span></span></span>');
}

Criteria.FormErrorReporting = function(that, text){
    that.addClass('error');
    that.after('<div class="error"><p>'+text+'</p></div>');
    thatthat = $('#content form div.error').outerWidth();
    $('#content form div.error').css({'right': -thatthat-20});
    that.focus();
}

Criteria.SaveInput = function(that, add) {
    // trim input values
    var trimValue = $.trim(that.val());
    that.val(trimValue);
    // post
    if (!that.val() == ''){
        // add preloader
        Criteria.SaveInput.Loading = $('<span class="loading">&nbsp;</span>');
        that.after(Criteria.SaveInput.Loading);
        //disable input field
        that.attr('disabled', 'disabled');
        var data = {
                'criteria_id': add ? that.attr('id') : that.attr('id').split('_')[1],
                'value'      : that.attr('value'),
                'action'     : 'save'
        };
        // post the form
        $.ajax({
            data: data,
            success: function(data) {
                // if previous error exist, remove them
                if (that.hasClass('error')){
                    that.removeClass('error');
                    that.siblings('div.error').remove();
                }
                // add new field
                if (add){
                    if(data['status'] == true){
                        // here be returned shite
                        $('#content form ol').append('<li id="criteria_'+data['criteria_id']+'"><input type="text" id="criteria_'+data['criteria_id']+'" name="" value="'+that.val()+'" /><span class="remove" onclick ="void(0)">&ndash;</span><span class="drag" onclick ="void(0)">&nbsp;<span></span></span></li>');
                        that.focus();
                        that.val('');
                        //remove preloader
                        Criteria.SaveInput.Loading.remove();
                        //enable input field
                        that.removeAttr('disabled');
                        Core.ProjectMenu(data['projectMenu']);
                        Core.ContentNav.toggle('evaluation', data['projectMenu']);
                        Criteria.handleListFontSize($('#content form ol li'));

                        // errors
                    } else {
                        //remove preloader
                        Criteria.SaveInput.Loading.remove();
                        //enable input field
                        that.removeAttr('disabled');
                        Criteria.FormErrorReporting(that, data['errors']['title']);
                    }

                // update field
                } else {
                    if(data['status'] == true){
                        // here be returned shite
                        that.siblings('.loading').remove();
                        that.removeAttr('disabled');

                        // errors
                    } else {
                        that.siblings('.loading').remove();
                        that.removeAttr('disabled');
                        Criteria.FormErrorReporting(that, data['errors']['title']);
                    }

                }
            }
        });
    }
}

Criteria.DeleteInput = function(that) {
    // add preloader
    Criteria.DeleteInput.Loading = $('<span class="loading">&nbsp;</span>');
    that.after(Criteria.DeleteInput.Loading);
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
                Core.ContentNav.toggle('evaluation', data['projectMenu']);
                Criteria.DeleteInput.Loading.remove();
                Criteria.handleListFontSize($('#content form ol li'));
            } else {
                Criteria.DeleteInput.Loading.remove();
            }

        }
    });
}

/**
 * Handle previous / next button
 */
Criteria.handleButtons = function(menu) {
    // next button
    var next = $('#content-nav li.next a');

    // check if next button should be enabled or disabled
    var nextEnabled = false;
    if(menu == undefined)
    {
        nextEnabled = $('#menu-evaluation').is('a');
    }
    else
    {
        nextEnabled = (false != menu['evaluation']);
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

/**
 * Handle criteria list font-size
 */
Criteria.handleListFontSize = function(that) {
        $(that).not('.ui-sortable-helper').each(function(index, that){
            var fontSizes = new Array(35, 31, 26, 22, 18, 15, 12, 11, 10, 9, 8);
            var fontRatio = (fontSizes[index]);
            var fontSizesMin = 8;
            
            // min font size failsafe
            if (index < fontSizes.length) {
                $(that).css('font-size', fontRatio);
            } else {
                $(that).css('font-size', fontSizesMin);
            }
        });
}
/*
 * Document Ready
 */
$(document).ready(function(){
    // add or remove necessary elements
    Criteria.FormAddButton($('#content form div input'));
    Criteria.FormListButtons($('#content form li input'));
    $('#content form input[type="submit"]').remove();
    $('#content form div input').focus();

    // copy input ID's to list items
    $('#content form li input').each(function(){
        $(this).parents('li').attr('id', $(this).attr('id'));
    });

    // prepare ajax
    url = $('#content form').attr('action');
    $.ajaxSetup({
        type: 'POST',
        url: url,
        dataType: 'json',
    });

    // add new field
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

    // update field
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

    // remove field
    $('#content form li .remove').live('click', function(){
        var that = $(this);
        Criteria.DeleteInput(that);
    });

    // make criteria list sortable
    $('#content form ol').sortable({
        opacity: 0.90,
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
            Criteria.handleListFontSize($('#content form ol li'));
        },
        start: function(e, ui) {
            Criteria.handleListFontSize($('#content form ol li'));
            ui.placeholder.append('<div>Drop your criteria to this position.</div>');
        },
        beforeStop: function() {
            Criteria.handleListFontSize($('#content form ol li'));
        },
        stop: function() {
            Criteria.handleListFontSize($('#content form ol li'));
        }
    });

    $('#content form ol .drag').live('click', function(){
        return false;
    });

    // update the position of criteria
    $('#content form ol').live( 'sortupdate', function(event, ui) {
        $.post(location.href, {
            criteriaOrder: $(this).sortable('toArray').toString()
        });
    });

    // prevent form submission
    $('#content form').submit(function(){
        return false;
    });
    
    // handle list font size
    Criteria.handleListFontSize($('#content form ol li'));
});
