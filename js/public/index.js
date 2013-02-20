/* Public javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.3
*/

Public = {};
Public.OpinionNextPage = 1;

Public.FormErrorReporting = function(that, text){
    that.append('<div class="error"><p>'+text+'</p></div>');
    $('#content form div.error').css({'top': -$('#content form div.error').height()+12});
    that.find('textarea').focus();
}

Public.Comment = function(commentForm) {
    //add blocker
    Core.Block(Public.CommentForm.find('.textarea'), true);
    Public.CommentForm.find('.button').unbind('click');
    //ajax comment post
    $.ajax({
        data: commentForm,
        success: function(data) {
            // remove errors
            Public.CommentForm.find('div.error').remove();

            //add new field
            if(data['status'] == true){
                //here be returned shite
                $('#opinions ul.comments li.new').after(data['opinion']);
                Public.CommentForm.find('textarea').val('');
                //unblock and bind button back
                Core.Unblock(Public.CommentForm.find('.textarea'));
                Public.CommentForm.find('.button').bind('click', eSubmit);
                //errors
            } else {
                //unblock and bind button back
                Core.Unblock(Public.CommentForm.find('.textarea'));
                Public.CommentForm.find('.button').bind('click', eSubmit);
                //display error
                Public.FormErrorReporting(Public.CommentForm.find('div.textarea'), data['errors']['opinion']);
            }
        }
    });
}

//display more comments
Public.Comment.ShowMore = function(that) {
    that.unbind('click.ShowMore');
    //data
    var data = {
        'showMore': true,
        'opinionPage': Public.OpinionNextPage,
    };

    $.ajax({
        data: data,
        success: function(data) {
            if(data['status'] == true){
                Public.OpinionNextPage++;
                //here be returned shite
                $('#content ul').append(data['more']);

                //rebind button click event
                that.bind('click.ShowMore', function(){
                    Public.Comment.ShowMore($(this));
                });

                // hide show more?
                if(data['pageCount'] == Public.OpinionNextPage)
                {
                    $('#showMore').hide();
                }
            //errors
            } else {

            }
        }
    });
}

/*
 * Document Ready
 * */
$(document).ready(function(){
    // setup ajax
    $.ajaxSetup({
        type: 'POST',
        url: location.href,
        dataType: 'json'
    });

    // get comment form
    Public.CommentForm = $('#opinions ul.comments form');

    // override values
    Score.Config['leftLegendOffset'] = 157;
    Score.Config['scoreOffset'] = 2;

    // init score
    Score.init();

    //ajax post
    Public.CommentForm.submit(function(){
        // trim
        var textArea = $(this).find('textarea');
        textArea.val($.trim(textArea.val()));

        //post
        Public.Comment($(this).serialize());
        return false;
    });

    // remove error field on keypress
    Public.CommentForm.find('textarea').keypress(function(){
        $(this).siblings('div.error').remove();
    });

    //replace button for anchor
    Public.CommentForm.find('input[type=submit]').hide();
    Public.CommentForm.find('fieldset').append('<a href="#" class="button">'+Public.CommentForm.find('input[type=submit]').attr('value')+'<span>&nbsp;</span></a>');
    Public.CommentForm.find('.button').bind('click', eSubmit = function(){
        Public.CommentForm.triggerHandler('submit');
        return false;
    });

    //show more comments
    $('#showMore').click(function(){
        return false;
    });

    // show more click action
    $('#showMore').bind('click.ShowMore', function(){
        Public.Comment.ShowMore($(this));
    });

    // save html to a variable and remove it from the dom
    Public.DetailedComparison = $('#overlayDetails').html();
    $('#overlayDetails').remove();

    //open detailed comparison - abacon
    $('#detailed_comparison').click(function(){
        Core.Overlay(Public.DetailedComparison, true);

        // init abacon
        Abacon.init();

        Abacon.Legend.rebuildDropdown();
        // draw the two best alternatives
        Abacon.Legend.LegendList.children().each(function(){
            // get id
            var id = Core.ExtractNumbers($(this).attr('id'));
            // draw alternatives
            Abacon.DrawAlternative(id);
        });
        return false;
    });
});