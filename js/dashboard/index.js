/* Dashboard index javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

DashboardFeed = {};

DashboardFeed.showMore = function() {
    var data = {
            'showMore': true
    };
    // post the form
    $.ajax({
        data: data,
        success: function(data) {
            if(data['status'] == true){
                //here be returned shite
                $('#content ul').append(data['more']);

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
    //prepare ajax
    url = window.location;
    $.ajaxSetup({
        type: 'POST',
        url: url,
        dataType: 'json',
    });
    $('#showMore').click(function() {
        DashboardFeed.showMore();
        return false;
    });
});