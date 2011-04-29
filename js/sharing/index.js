/* Sharing javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

Sharing = {};

/**
 * Initialize Dropdown
 */
Sharing.Dropdown = function(that)
{
    // define Dropdown items
    Sharing.Dropdown.Select = $(that);
    Sharing.Dropdown.Fieldset = $(that).parent();
    Sharing.Dropdown.DropdownList = $('<ul></ul>').addClass('selectBox-dropdown-menu').hide();

    // hide select box
    Sharing.Dropdown.Select.hide();

    // append dropdown list
    Sharing.Dropdown.Fieldset.append(Sharing.Dropdown.DropdownList);

    // populate ul
    Sharing.Dropdown.Select.find('option').each(function(index){
        Sharing.Dropdown.DropdownList.append($('<li></li>')
           .attr('id', 'dropdown-' + $(this).attr('value'))
           .append($('<a></a>')
               .attr('rel', $(this).attr('value')).html($(this).html()))
       );

       if (index == 0){
           Sharing.Dropdown.Fieldset.find('.selectBox-label').text($(this).text());
       }
    });

    //calculate and set dropdown's width as wide the widest list element
    Sharing.Dropdown.DropdownList.ListWidth = 0;
    Sharing.Dropdown.DropdownList.children('li').each(function(index, element){
        var fakeWidth = $('<span></span>').append($(this).children().text()).css('display', 'none').appendTo('body');
        var elementWidth = fakeWidth.outerWidth();
        if (elementWidth > Sharing.Dropdown.DropdownList.ListWidth){
            Sharing.Dropdown.DropdownList.ListWidth = elementWidth;
        }
    });
    Sharing.Dropdown.DropdownList.width(Sharing.Dropdown.DropdownList.ListWidth+31);

    //Dropdown position
    Sharing.Dropdown.DropdownList.css('bottom', function(){
        return -$(this).height()-6;
    });
}

/**
 * Dropdown Toggle
 */
Sharing.Dropdown.Toggle = function(that) {
    if (that.is(':hidden')){
        that.show();
        that.parent().find('span.selectBox-arrow').attr('class', 'selectBox-arrow-reverse');
    } else {
        that.hide();
        that.parent().find('span.selectBox-arrow-reverse').attr('class', 'selectBox-arrow');

    }

}

$(document).ready(function() {
    $('#content form select').each(function(index, element){
        Sharing.Dropdown($(element));
    });

    //toggle dropdown open/closed
    $('#content .selectBox-dropdown').toggle(function(){
        Sharing.Dropdown.Toggle($(this).siblings('.selectBox-dropdown-menu'));

    }, function(){
        Sharing.Dropdown.Toggle($(this).siblings('.selectBox-dropdown-menu'));
    });

    $('#content .selectBox-dropdown-menu a').click(function(){
        Sharing.Dropdown.Toggle($(this).parents('.selectBox-dropdown-menu'));

        // rewrite label
        $(this).parent().parent().parent().find('.selectBox-label').text($(this).text());

        // prepare native select for submit
        Sharing.Dropdown.AnchorID = $(this).parent().attr('id').split('-')[1];
        $(this).parent().parent().parent().find('option').each(function(index, element){
            if ($(element).attr('value') == Sharing.Dropdown.AnchorID){
                $(element).attr('selected', 'selected');
            }
        });
    });

    //make dropdown the same width as the longest option
    $('.selectBox-dropdown').each(function(){
        var ulWidth = $(this).siblings('.selectBox-dropdown-menu').width();
        $(this).width(ulWidth);
    });

    //on load put focus in textarea
    $('#content form textarea').select();
});