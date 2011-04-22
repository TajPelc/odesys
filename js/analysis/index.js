/* Analysis javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
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
        dataType: 'json',
    });

    // init score
    Score.init();

    // init abacon
    Abacon.init();
});