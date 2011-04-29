/* Public javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
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
        dataType: 'json',
    });

    // override values
    Score.Config['leftLegendOffset'] = 157;
    Score.Config['scoreOffset'] = 2;

    // init score
    Score.init();
});