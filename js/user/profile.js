/* Profile Settings javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

ProfileSettings = {};

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

    $('#content .buttonBig').click(function() {
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
});