/* Public javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.2
*/

Public = {};

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
                //count comments and show/hide "show more" button
                Public.Comment.Count();
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

//display show more opinons button if more than 5 comments
Public.Comment.Count = function() {
    var comment = $('.comments');
    var commentNr = comment.find('li:not(.new)').length;
    /* @ToDo
    if(commentNr >= 5){
        comment.siblings('#comments_more').show();
    } else {
        comment.siblings('#comments_more').hide();
    }*/
    comment.siblings('#comments_more').hide();
}

//display more comments
Public.Comment.ShowMore = function(that) {
    that.unbind('click.ShowMore');
    //data
    var data = {
        'showMore': true
    };
    
    $.ajax({
        data: data,
        success: function(data) {
            if(data['status'] == true){
                //here be returned shite
                $('#content ul').append(data['more']);
                
                //rebind button click event
                that.bind('click.ShowMore', function(){
                    Public.Comment.ShowMore($(this));
                });

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
        dataType: 'json',
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

    //count comments and show/hide "show more" button
    Public.Comment.Count();

    //show more comments
    $('#comments_more').click(function(){
        return false;
    });

    $('#comments_more').bind('click.ShowMore', function(){
        Public.Comment.ShowMore($(this));
    });
});