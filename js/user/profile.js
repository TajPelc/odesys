/* Profile Settings javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

ProfileSettings = {};

/*
 * Document Ready
 * */
$(document).ready(function(){
    $('#deleteUser').click(function() {
        $.ajax({
            type: 'POST',
            url: '/user/delete/',
            dataType: 'json',
            data: {
                'partial': true
            },
            success: function(data) {
                if(data['status'] == true)
                {
                    Core.Overlay(data['html']);
                }
            }
        });

        $('#overlay #cancel').click(function(){
            Core.Overlay.Close();
        });
        return false;
    });

    //handle delete action
    $('#overlay #deleteUser').live('submit', (function(){
        // post the form
        $.ajax({
            type: 'POST',
            url: '/user/delete/',
            dataType: 'json',
            data: {
                'deleteUser': true
            },
            success: function(data) {
                if(data['status'] == true){
                    location.href = data['logoutUrl'];
                } else { // errors
                    Core.Overlay.Close();
                }
            }
        });
        return false;
    }));

    // delete decisions
    $('table .delete, table .edit').click(function() {
        ProfileSettings.getDecision = $(this);

        $.ajax({
            type: 'POST',
            url: $(this).attr('href'),
            dataType: 'json',
            data: {
                'partial': true
            },
            success: function(data) {
                if(data['status'] == true)
                {
                    Core.Overlay(data['html']);
                }
            }
        });

        $('#overlay #cancel').click(function(){
            Core.Overlay.Close();
        });
        return false;
        //remember decision object
        //DashboardList.Item = $(this);

        //open overlay and fill it
        //Core.Overlay.Html = '<h2>Are you sure?</h2><p>You are about to delete decision model named "'+DashboardList.Item.parents('td').siblings('td:first-child').text()+'". This action is irreversible.</p><div><a href="#" class="buttonBig" id="deleteYes">Yes<span class="doors">&nbsp;</span></a><a href="#" class="buttonBig" id="deleteNo">No<span class="doors">&nbsp;</span></a></div>';
        //Core.Overlay(Core.Overlay.Html);
    });


    //handle delete action
    $('#overlay #deleteDecision').live('submit', (function(){
        var data = {
            'decision': ProfileSettings.getDecision.parents('tr').attr('id')
        };
        // post the form
        $.ajax({
            type: 'POST',
            url: ProfileSettings.getDecision.attr('href'),
            dataType: 'json',
            data: data,
            success: function(data) {
                if(data['status'] == true){
                    //here be returned shite
                    ProfileSettings.getDecision.parents('tr').fadeOut('slow', function() {
                        $(this).remove();
                    });
                    Core.Overlay.Close();
                    //errors
                } else {

                }
            }
        });
        return false;
    }));

    //handle delete action
    $('#overlay #editDecision').live('submit', (function(){
        var newDecisionTitle = $(this).find('#title').val()
        var data = {
            'decision': ProfileSettings.getDecision.parents('tr').attr('id'),
            'title' : newDecisionTitle
        };
        // post the form
        $.ajax({
            type: 'POST',
            url: ProfileSettings.getDecision.attr('href'),
            dataType: 'json',
            data: data,
            success: function(data) {
                if(data['status'] == true){
                    //update title in the table
                    ProfileSettings.getDecision.parents('tr').find('td:first a').text(newDecisionTitle);
                    //update to the correct url
                    ProfileSettings.getDecision.parents('tr').find('td:first a').attr('href', data['url']+'.html');
                    Core.Overlay.Close();
                    //errors
                } else {

                }
            }
        });
        return false;
    }));
});