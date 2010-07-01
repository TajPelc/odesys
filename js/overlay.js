/**
 * Binds click event on edit link
 *
 * var selector
 *
 * @return void
 */
function bindEditOverlay(selector, anchor) {
    $(selector).live('click', function(event) {
        createDialog($(this).attr('href'),anchor);
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
function bindCreateOverlay(selector, anchor) {
    $(selector).css({marginBottom: '10px'}).click(function(event) {
        createDialog(undefined, anchor);
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
function bindDeleteOverlay(selector, anchor) {
    $(selector).live('click', function(event) {
        div = $('<div></div>').attr({
            id: 'dialog-confirm',
            title: 'Delete criteria?',
        }).html('<p style="color: #596171"><span class="ui-icon ui-icon-alert" style="float:left; margin:3px 7px 20px 4px;"></span>Are you sure you want to delete criteria "' + $(this).parent().find('span').html()  + '"?</p>');

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
                                $(anchor + '_' + data['id']).fadeOut(1000, function(){
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
function createDialog(url, anchor) {
    editing = true;
    title = 'Edit ' + anchor.substr(1);
    if(url == undefined)
    {
        editing = false;
        title = 'Add ' + anchor.substr(1);
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
                    $(anchor + '-overlay-form').append($('<input />').attr({
                        type: 'hidden',
                        name: 'requesting',
                        value: 'formPost',
                    }));

                    // post the form
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: $(anchor + '-overlay-form').serialize(), // serialize values from the form
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
                                $(anchor).append($('<ul></ul>').attr('id', 'sortable'));
                                makeSortable();
                            }

                            // create the list element and html
                            liHtml = '<span>' + data['title'] + '</span><a class="delete" href="/index.php?r=' + anchor.substr(1) + '/delete&' + anchor.substr(1) + '_id=' + data['id'] + '">delete</a><a class="edit" href="/index.php?r=' + anchor.substr(1) + '/create&' + anchor.substr(1) + '_id=' + data['id'] + '">edit</a>';

                            // edit mode, replace the edited item
                            if(editing)
                            {
                                animateByColorChange($(anchor + '_' + data['id']).html(liHtml), 1000, 1000);
                            }
                            else // create mode, append the new element
                            {
                                li = $('<li id="' + anchor.substr(1) + '_' + data['id'] + '"></li>');

                                // if this is criteria
                                if(anchor == '#criteria')
                                {
                                    li.attr('class', 'movable');
                                }

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
                $('#create-' + anchor.substr(1)).removeClass('ui-state-focus');
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