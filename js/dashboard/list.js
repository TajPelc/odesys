/* Dashboard List javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.1
*/

DashboardList = {};

DashboardList.DeleteItem = function(that) {
    var data = {
            'delete': that.parents('tr').attr('id'),
    };
    // post the form
    $.ajax({
        data: data,
        success: function(data) {
            if(data['status'] == true){
                //here be returned shite
                that.parents('tr').remove();
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
    $('table div span').click(function() {
        DashboardList.DeleteItem($(this));
    });
});