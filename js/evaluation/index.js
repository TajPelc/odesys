Evaluation = {};

/**
 * Blocker for Entire Evaluation
 *
 * @param object
 * @returns void
 */
Evaluation.Block = function(that){
    that.append('<div class="block"><img src="/images/ajax-loader.gif" /></div>');
    $('.block').each(function(index, element){
        $(element).addClass('roundedBottom');
        $(element).width($(element).parent().outerWidth()-4);
        $(element).height($(element).parent().outerHeight()+10);
        $(element).find('img').css({
            'top': ($(element).height()-$(element).children('img').height())/2,
            'left': ($(element).width()-$(element).children('img').width())/2
        });
    });
}

/**
 * Unblocker for Entire Evaluation
 *
 * @param object
 * @returns void
 */
Evaluation.Unblock = function(that){
    Core.Unblock.Block = that.find('.block').fadeOut(200);

    setTimeout('Core.Unblock.Block.remove()', 200);
}

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
                    location.href, {
                        action: 'update',
                        grade: ui.value,
                        params: params
                    },
                    function(data) {
                        if (data['status'] == true){
                            Core.ProjectMenu(data['projectMenu']);

                            if (sliderSlider.attr('class') == ''){
                                sliderSlider.addClass('saved');
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
    Evaluation.Block($('section.content'));

    // get unsaved and saved items
    var unsavedList = $('#evaluation ul li:not(.saved)');
    var list = $('#evaluation ul li');

    // non evaluated
    if(unsavedList.length == list.length && that.parent().hasClass('next'))
    {
        if(false === confirm('Are you sure you want to proceed without evaluating?'))
        {
            Evaluation.Unblock($('section.content'));
            return false;
        }
    }


    // get unsaved values
    var unsaved = [];
    if(that.parent().hasClass('next'))
    {
        unsavedList.each(function(){
            unsaved.push(Core.ExtractNumbers($(this).find('div:first input').attr('name')));
        });
    }

    // change page
    if(that.hasClass('changePage'))
    {
        // going to analysis
        if(that.parent().hasClass('next') && unsaved.length > 0)
        {
            // post empty criteria
            $.post(location.href, {'action': 'save', 'unsaved': unsaved}, function(data){
                if(data['status'] == true)
                {
                    redirectUser(data['projectMenu']['analysis']);
                }
            });
        }
        else
        {
            return true;
        }
    }

    // navigate criteria
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
            };
            setTimeout(html, 120);

            $('#main > h2 em').text(data['title']);

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

            Evaluation.Unblock($('section.content'));
            Evaluation.Sidebar(data['sideBar']);
        }
    });

};

Evaluation.Sidebar = function(sidebar) {
    var sidebarUl = $('#sidebar ul.steps');
    var sidebarUlHeight = sidebarUl.height();
    sidebarUl.height(sidebarUlHeight);
    sidebarUl.children().remove();
    sidebarUl.append(sidebar);
};

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
        else
        {
            return false;
        }
    });
});
