/* Public javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       3.0
 */

Public = {};

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

    //description
    $('#accordion form').live('submit', (function(){

        var that = $(this);
        $.ajax({
            type: 'POST',
            url: location.href,
            dataType: 'json',
            data: {
                'description' : that.find('textarea').val()
            },
            success: function(data) {
                if(data['status'] == true){
                    that.after(data['html']);
                    that.remove();

                    //errors
                } else {

                }
            }
        });
        return false;
    }));

    //live edit description
    $('#description a').live('click', function(){
        $(this).parent().hide();
        $(this).parent().siblings('form').show();
        return false;
    });
});