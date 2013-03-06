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

    //post favourite
    $('#score table tr td.name').click(function(){
        if(!$(this).siblings('.fav').hasClass('selected')){
            $('table.alternatives td.selected').removeClass('selected');
            $(this).siblings('.fav').addClass('selected');
            $.ajax({
                type: 'POST',
                url: location.href,
                dataType: 'json',
                data: {
                    'favourite' : true,
                    'alternative' : $(this).attr('id')
                },
                success: function(data) {
                    if(data['status'] == true){
                        //errors
                    } else {
                    }
                }
            });
        }
    });
    $('#score table tr td.fav').click(function(){
        if(!$(this).hasClass('selected')) {
            $('table.alternatives td.selected').removeClass('selected');
            $(this).addClass('selected');
            $.ajax({
                type: 'POST',
                url: location.href,
                dataType: 'json',
                data: {
                    'favourite' : true,
                    'alternative' : $(this).siblings('.name').attr('id')
                },
                success: function(data) {
                    if(data['status'] == true){
                        //errors
                    } else {
                    }
                }
            });
        }
    });
});