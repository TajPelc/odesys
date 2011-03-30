/* Criteria javascript
 * @author        Frenk
 * @version       1.0
*/

Criteria = {};

Criteria.FormAddButton = function(){
    $('#content form li:last-child input').after('<span>+</span>');
}

$(document).ready(function(){
    Criteria.FormAddButton();

    //if enter is pressed on input fields except last, jump to the next field
    $('#content form li input[type="text"]').not(':last').focus(function(){
        $(this).keypress(function(e){
            if(e.which == '13') {
                e.preventDefault();
                $(this).parent().next().children().focus();
            }
        });
    });
});