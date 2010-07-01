/**
 * On document load
 */
$(document).ready(function(){

    // change the submit buttons
    $(function() {
        $("input:submit, a.button").button();
    });


    // disable the non-ajax form
    $('div.form').remove();

    // handle the continue link
    handleSortableList();

    // rearrange order on sort
    $('#sortable').bind( "sortupdate", function(event, ui) {
        $(this).sortable('disable');
        animateByColorChange(ui.item, 200,200, '$("#sortable").sortable("enable");');
        $.get(location.href, {
            criteriaOrder: $(this).sortable('toArray').toString(),
        });
    });

    // bind create and edit events
    bindCreateOverlay('#create-criteria');
    bindEditOverlay('#sortable li a.edit');
    bindDeleteOverlay('#sortable li a.delete');

    // make the ul sortable
    makeSortable();
});

/**
 * Make the criteria list sortable
 *
 * @return void
 */
function makeSortable() {
    //
    $("#sortable").sortable({
            opacity: 0.90,
    });
    $("#sortable").disableSelection();
}

/**
 * Binds click event on edit link
 *
 * var selector
 *
 * @return void
 */
function bindEditOverlay(selector) {
    $(selector).live('click', function(event) {
        createDialog($(this).attr('href'));
        event.preventDefault();
    });
}

/**
 * Binds click event on add link
 *
 * var selector
 *
 * @return void
 */
function bindCreateOverlay(selector) {
    $(selector).css({marginBottom: '10px'}).click(function(event) {
        createDialog();
        event.preventDefault();
    });
}

/**
 * Open the overlay in delete mode
 *
 * var selector
 *
 * @return
 */
function bindDeleteOverlay(selector) {
    $(selector).live('click', function(event) {
        div = $('<div></div>').attr({
            id: 'dialog-confirm',
            title: 'Delete criteria?',
        }).html('<p style="color: #596171"><span class="ui-icon ui-icon-alert" style="float:left; margin:3px 7px 20px 4px;"></span>Are you sure you want to delete criteria "' + $(this).parent().find('span').html().substr(3)  + '"?</p>');

        // url
        url = $(this).attr('href');

        // add dialog functionality to the form element
        div.dialog({
          autoOpen: false,
          height: 200,
          width: 750,
          modal: true,
          resizable: false,
          buttons: {
              'Delete': function() {

                // disable buttons
                $('button').attr('disabled', 'disabled');

                // post the form
                $.ajax({
                        type: 'get',
                        url: url,
                        success: function(data) {
                            // errors
                            if(data['status'] == false)
                            {
                                alert('Delete failed.');
                                // close the dialog
                                div.dialog('close');
                            }
                            else
                            {
                                $('#criteria_' + data['id']).fadeOut(1000, function(){
                                    $(this).remove();
                                    handleSortableList();
                                });

                                // close the dialog
                                div.dialog('close');
                                div.remove();
                            }
                        }
                    });
              },
              Cancel: function() {
                  $(this).dialog('close');
                  $(this).remove();
              }
          },
          close: function() {
          }
      });

        div.dialog('open');
        $('div.ui-widget-header').removeClass('ui-widget-header').addClass('overlay-heading');
        event.preventDefault();
    });
}

/**
 * Create a dialog for create / edit of criteria
 */
function createDialog(url) {
    editing = true;
    title = 'Edit criteria';
    if(url == undefined)
    {
        editing = false;
        title = 'Add criteria';
        url = location.href;
    }

    $.ajax({
        url: url,
        data: {requesting: 'form'},
        success: function(data) {

            // create form element from the returned html
            form = $('<div></div>').attr('class', 'form').attr('title', title).attr('id', 'dialog-form').html(data['form']);

            // add dialog functionality to the form element
            form.dialog({
                autoOpen: false,
                height: 530,
                width: 750,
                modal: true,
                resizable: false,
                buttons: {
                // what goes on on create / edit
                'Save': function() {

                    // disable buttons
                    $('button').attr('disabled', 'disabled');

                    // add an additional input to the form
                    $('#criteria-overlay-form').append($('<input />').attr({
                        type: 'hidden',
                        name: 'requesting',
                        value: 'formPost',
                    }));

                    // post the form
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: $('#criteria-overlay-form').serialize(), // serialize values from the form
                        success: function(data) {
                        // errors
                        if(data['status'] == false)
                        {
                            // form returned
                            if(data.hasOwnProperty('form'))
                            {
                                // replace the contents of the form
                                form.html(data['form']);
                                form.find('input').removeClass('text ui-widget-content ui-corner-all');

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

                            // create the ul if it doesn't exist
                            if( $('#sortable').length == 0 )
                            {
                                $('#criteria').append($('<ul></ul>').attr('id', 'sortable'));
                                makeSortable();
                            }

                            // create the list element and html
                            liHtml = '<span>&uarr;&darr; ' + data['title'] + '</span><a class="delete" href="/index.php?r=criteria/delete&criteria_id=' + data['id'] + '">delete</a><a class="edit" href="/index.php?r=criteria/create&criteria_id=' + data['id'] + '">edit</a>';

                            // edit mode, replace the edited item
                            if(editing)
                            {
                                animateByColorChange($('#criteria_' + data['id']).html(liHtml), 1000, 1000);
                            }
                            else // create mode, append the new element
                            {
                                li = $('<li id="criteria_' + data['id'] + '" class="movable"></li>');
                                $('#sortable').append(li.html(liHtml));
                                handleSortableList();
                                animateByColorChange($('#sortable li:last'), 1000, 1000);
                            }
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
                $('#create-criteria').removeClass('ui-state-focus');
            }
            });

            form.dialog('open');
            $('div.ui-widget-header').removeClass('ui-widget-header').addClass('overlay-heading');
        }
    });
}

/**
 * Remove ul / handle continue link
 */
function handleSortableList() {
    size = $('#sortable').children().size();
    if(size  < 2)
    {
        if( size == 0)
        {
            $('#sortable').remove();
        }
        $('a.right').hide();
    }
    else
    {
        $('a.right').show();
    }
}

/**
 * Animate the element by chaing it's backgrond color
 *
 * @param element
 * @param speed1
 * @param speed2
 * @param codeOnFinish
 * @return void
 */
function animateByColorChange(element, speed1, speed2, codeOnFinish)
{
    element.animate({
            backgroundColor: '#ffd700;',
        },
        speed1,
        'linear',
        function() {
            element.animate({
                backgroundColor: '#DBE3F0;',
                },
                speed2,
                'linear',
                function(){
                    eval(codeOnFinish);
                });
    });
}