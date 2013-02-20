/* Analysis javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       3.0
*/

Analysis = {};

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

    // init score
    Score.init();

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

    // check if guest and offer login
    if($('header.content section nav p').length == 0){
        // post the form
        $.ajax({
            type: 'POST',
            url: '/login/index/',
            dataType: 'json',
            data: {
                'isGuest' : true
            },
            success: function(data) {
                if(data['status'] == true){
                    Core.Overlay(data['html']);
                    //errors
                } else {

                }
            }
        });
    }
});