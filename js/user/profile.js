/* Profile Settings javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

ProfileSettings = {};

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
    $('#delete').click(function() {
        //open overlay and fill it
        Core.Overlay.Html = '<h2>Are you sure?</h2><p>You are about to delete your profile. This action is irreversible.</p><div><a href="#" class="buttonBig" id="deleteYes">Yes<span class="doors">&nbsp;</span></a><a href="#" class="buttonBig" id="deleteNo">No<span class="doors">&nbsp;</span></a></div>';
        Core.Overlay(Core.Overlay.Html);

        //handle delete action
        $('#deleteYes').click(function(){
            // post the form
            $.ajax({
                data: {'deleteProfile': true},
                success: function(data) {
                    if(data['status'] == true){
                        location.href = data['logoutUrl'];
                    } else { // errors
                        Core.Overlay.Close();
                    }
                }
            });
        });
        $('#deleteNo').click(function(){
            Core.Overlay.Close();
        });
        return false;
    });

    //prepare ajax
    url = '/user/decisions/';
    $.ajaxSetup({
        type: 'POST',
        url: url,
        dataType: 'json'
    });
    $('table .delete').click(function() {
        //remember decision object
        DashboardList.Item = $(this);

        //open overlay and fill it
        Core.Overlay.Html = '<h2>Are you sure?</h2><p>You are about to delete decision model named "'+DashboardList.Item.parents('td').siblings('td:first-child').text()+'". This action is irreversible.</p><div><a href="#" class="buttonBig" id="deleteYes">Yes<span class="doors">&nbsp;</span></a><a href="#" class="buttonBig" id="deleteNo">No<span class="doors">&nbsp;</span></a></div>';
        Core.Overlay(Core.Overlay.Html);


        //handle delete action
        $('#deleteYes').click(function(){
            DashboardList.DeleteItem(DashboardList.Item);
            Core.Overlay.Close();
        });
        $('#deleteNo').click(function(){
            Core.Overlay.Close();
        });
        return false;
    });


});