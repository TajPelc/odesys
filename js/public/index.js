/* Public javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

Public = {};

Public.Comment = function(commentForm) {
    $.ajax({
        data: commentForm,
        success: function(data) {
            //add new field
            if(data['status'] == true){
                //here be returned shite
                $('#opinions ul.comments li.new').after(data['opinion']);
                Public.CommentForm.find('textarea').val('');
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

    //replace button for anchor
    Public.CommentForm.find('input[type=submit]').hide();
    Public.CommentForm.find('fieldset').append('<a href="#" class="button">'+Public.CommentForm.find('input[type=submit]').attr('value')+'<span>&nbsp;</span></a>');
    Public.CommentForm.find('.button').click(function(){
        Public.CommentForm.triggerHandler('submit');
        return false;
    });
});