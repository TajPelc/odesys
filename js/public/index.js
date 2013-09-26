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

    $('#weights').click(function (e) {
        $.ajax({
            type: 'POST',
            url: location.href,
            data: {
                "generateGraph" : true,
                "disableWeights" : ($(this).is(':checked') ? 'disable' : 'enable')
            },
            success: function(data) {
                Graph.Data = data.data;
                $('svg').remove();
                $('#score').removeAttr('style');
                renderGraph();
            }
        });
    });

    function renderGraph() {
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
    }

    renderGraph();
    /**
     * @todo - add comment, post to /project/opinion/
     */
});