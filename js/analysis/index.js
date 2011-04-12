/* Analysis javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

Analysis = {};

/*
 * Document Ready
 * */
$(document).ready(function(){
    //accordion
    $( "#accordion" ).accordion({
        autoHeight: false,
        animated: false

    });

    // init score
    Score.init();

    // init abacon
    Abacon.init();

    /**
     * Draw when u first switch tab
     */
    var initDraw = true;
    $('#abacon-tab').click(function(){
        if(initDraw)
        {
            Abacon.Legend.rebuildDropdown();

            // draw the two best alternatives
            Abacon.Legend.LegendList.children().each(function(){
                // get id
                var id = Core.ExtractNumbers($(this).attr('id'));

                // draw alternatives
                Abacon.DrawAlternative(id);
            });

            // disable
            initDraw = false;
        }
    });
});