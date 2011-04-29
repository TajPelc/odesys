/* Public javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

Public = {};

Public.Comment = function(that) {
    $.ajax({
        data: that,
        success: function(data) {
            //add new field
            if(data['status'] == true){
                //here be returned shite

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

    // override values
    Score.Config['leftLegendOffset'] = 157;
    Score.Config['scoreOffset'] = 2;

    // init score
    Score.init();

    //ajax post
    $('.comments form').submit(function(){
        //trim input values
        var trimValue = $.trim($(this).find('textarea').val());
        //serialize input valus
        var serializeValue = $(this).serialize().split('=')[0]+'='+trimValue;
        //post
        Public.Comment(serializeValue);
        return false;
    });
});