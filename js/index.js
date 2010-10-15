/**
 * On document load
 */
$(document).ready(function(){
    $(function() {
        $("a.button").button();
    });
    
    $('#create').click(function(event){
    	url = $(this).attr('href');
    	$.post(
		   url, {
		   requesting: 'form'
		   },
		   function(data){
			   // set parameters
			   title = 'Create a new project';
			   if(data['edit'])
			   {
				   title = 'Edit project';
			   }
			   anchor = '#project'
			   
	            // create form element from the returned html
	            form = $('<div></div>').attr('class', 'form').attr('title', title).attr('id', 'dialog-form').html(data['form']);

	            // add dialog functionality to the form element
	            form.dialog({
	                autoOpen: false,
	                width: 750,
	                modal: true,
	                resizable: false,
	                position:['center', 50],
	                buttons: {
	                // what goes on on create / edit
	                'Save': function() {

	            	// disable buttons
	                    $('button').attr('disabled', 'disabled');

	                    // add an additional input to the form
	                    $(anchor + '-form').append($('<input />').attr({
	                        type: 'hidden',
	                        name: 'requesting',
	                        value: 'formPost',
	                    }));

	                    startLoading();
	                    // post the form
	                    $.ajax({
	                        type: 'POST',
	                        url: url,
	                        data: $(anchor + '-form').serialize(), // serialize values from the form
	                        success: function(data) {
	                        stopLoading();
	                        // errors
	                        if(data['status'] == false)
	                        {
	                            // form returned
	                            if(data.hasOwnProperty('form'))
	                            {
	                                // replace the contents of the form
	                                form.html(data['form']);

	                                // reenable buttons
	                                $('button').removeAttr('disabled');
	                                $('button').removeClass('ui-state-focus');
	                            }
	                        }
	                        else
	                        {
	                            // close the dialog
	                            form.dialog('close');

	                            // remove form
	                            form.remove();
	                        }
	                    }
	                });

	            },
	            Cancel: function() {
	                $(this).dialog('close');
	                form.remove();
	            }
	            },
	            close: function() {
	                // remove focus from add button
	                $('#create').removeClass('ui-state-focus');
	            }
	            });

	            // open dialog
	            form.dialog('open');
	            $('div.ui-widget-header').removeClass('ui-widget-header').addClass('overlay-heading');
	    });
    	event.preventDefault();
    });
});
