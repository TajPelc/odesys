/* Public javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       3.0
 */

Public = {};

/*
 * Document Ready
 * */
$(document).ready(function(){
    // init score
    Score.init();

    // init abacon
    Abacon.init();

    // rebuild dropdown
    Abacon.Legend.rebuildDropdown();

    // draw the two best alternatives
    Abacon.Legend.LegendList.children().each(function(){
        // get id
        var id = Core.ExtractNumbers($(this).attr('id'));
        // draw alternatives
        Abacon.DrawAlternative(id);
    });

    /**
     * @todo - add comment, post to /project/opinion/
     */
});