/* Dashboard index javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

DashboardFeed = {};
DashboardFeed.nextPage = 1;

DashboardFeed.showMore = function() {
    var data = {
            'showMore': true,
            'page': DashboardFeed.nextPage,
    };
    // post the form
    $.ajax({
        data: data,
        success: function(data) {
            if(data['status'] == true){
                DashboardFeed.nextPage++;

                //here be returned shite
                $('#content > ul').append(data['notifications']);
                if(data['pageCount'] == DashboardFeed.nextPage)
                {
                    $('#showMore').hide();
                }
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
