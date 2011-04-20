Evaluation = {};

/**
 * Change select input fields to sliders
 */
function handleSlider()
{
    // remove submit
    $('#evaluation input[type=submit]').remove();

    // slidify
    $('#evaluation div select').each(function() {
        val = $(this).find('option:selected').val();
        name = $(this).attr('name');

        $(this).parent().append($('<input type="hidden"></input>').attr('value', val).attr('name', name));
        $(this).parent().find('.worst').after($('<div></div>').slider({
            value: val,
            min: 0,
            max: 100,
            step: 1,
            range: "min",
            animate: true,
            stop: function(event, ui) {
                sliderSlider = $(this).parents('li');
                Core.Block(sliderSlider, true);
                $(this).parent().find('input').attr('value', ui.value);
                params = Core.ExtractNumbers($(this).parent().find('input').attr('name'));
                $.post(
                    'index.php?r=evaluation/update', {
                        grade: ui.value,
                        params: params,
                    },
                    function(data) {
                        if (data['status'] == true){
                            if (sliderSlider.attr('class') == ''){
                                sliderSlider.addClass('saved');
                                Core.ProjectMenu(data['projectMenu']);
                            }
                            Core.Unblock(sliderSlider);
                            if( $('#evaluation li').length == $('#evaluation li.saved').length) {
                                $('#sidebar li.current').addClass('saved');
                            }
                        }
                });
            }
        }));
        $(this).remove();
    });
}

Evaluation.NextCriteria = function(that) {
    // block page
    Core.Block($('#main'));

    // get unsaved and saved items
    var unsavedList = $('#evaluation ul li:not(.saved)');
    var list = $('#evaluation ul li');

    // non evaluated
    if(unsavedList.length == list.length && that.parent().hasClass('next'))
    {
        if(false === confirm('Are you sure you want to proceed without evaluating?'))
        {
            Core.Unblock($('#main'));
            return false;
        }
    }

    // change page
    if(that.hasClass('changePage'))
    {
        return true;
    }

    // get unsaved values
    var unsaved = [];
    if(that.parent().hasClass('next'))
    {
        unsavedList.each(function(){
            unsaved.push(Core.ExtractNumbers($(this).find('div:first input').attr('name')));
        });
    }

    Evaluation.NextCriteria.Url = that.attr('href');
    $.post(Evaluation.NextCriteria.Url, {
        'action': 'getContent',
        'unsaved': unsaved
    }, function(data){
        if(data['status'] == true){

            // make forms height fixed
            var formHeight = $('#content form').height();
            $('#content form').css('height', formHeight);

            // insert new criteria
            $('#content form ul').fadeOut(100, function(){$(this).remove()});
            var html = function() {
                $('#content form').append(data['html']);
                $('#content form ul').hide().fadeIn(100);
                handleSlider();
            }
            setTimeout(html, 120);

            var prevButton = $('#content-nav li:eq(0) a');
            var nextButton = $('#content-nav li:eq(1) a');

            prevButton.attr('href', data['previous']);
            nextButton.attr('href', data['next']);

            prevButton.removeClass('changePage');
            nextButton.removeClass('changePage');
            if(data['forward'])
            {
                nextButton.addClass('changePage');
            }
            if(data['back'])
            {
                prevButton.addClass('changePage');
            }

            Core.Unblock($('#main'));
            Evaluation.Sidebar(data['sideBar']);
        }
    });

}

Evaluation.Sidebar = function(sidebar) {
    var sidebarUl = $('#sidebar ul.steps');
    var sidebarUlHeight = sidebarUl.height();
    sidebarUl.height(sidebarUlHeight);
    sidebarUl.children().remove();
    sidebarUl.append(sidebar);
}

/**
 * On document load
 */
$(document).ready(function(){
    handleSlider();

    // load next criteria for evaluation
    $('#content-nav li a, #sidebar ul li a').live('click', function(){
        if(Evaluation.NextCriteria($(this)))
        {
            return true;
        }
        return false;
    });
});
