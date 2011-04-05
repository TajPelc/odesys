Evaluation = {};

/**
 * Extract the numbers from a given string
 *
 * @param str
 * @returns int
 */
function extractNumbers(str)
{
    return str.match(/\d+(,\d{3})*(\.\d{1,2})?/g);
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
                $(this).parent().find('input').attr('value', ui.value);
                params = extractNumbers($(this).parent().find('input').attr('name'));
                $.post(
                    'index.php?r=evaluation/update', {
                        grade: ui.value,
                        params: params,
                    },
                    function(data) {
                        if (sliderSlider.attr('class') == ''){
                            sliderSlider.addClass('saved');
                        }
                });
            }
        }));
        $(this).remove();
    });
}

Evaluation.NextCriteria = function(that) {
    Core.Block($('#content'));

    Evaluation.NextCriteria.Url = that.attr('href');
    $.post(Evaluation.NextCriteria.Url, {
        'action': 'getContent'
    }, function(data){
        if(data['status'] == true){

            //make forms height fixed
            var formHeight = $('#content form').height();
            $('#content form').css('height', formHeight);

            //insert new criteria
            $('#content form ul').fadeOut(100, function(){$(this).remove()});
            var html = function() {
                $('#content form').append(data['html']);
                $('#content form ul').hide().fadeIn(100);
                handleSlider();
            }
            setTimeout(html, 120);
            $('#content h2 b').text(data['title']);
            Evaluation.Navigation(that, data['previous'], data['next'], data['pageNr'], data['criteriaNr']);
            Core.Unblock($('#content'));
        }
    });

}

Evaluation.Navigation = function(that, prev, next, pageNr, criteriaNr) {
    var prevButton = $('#content > ul li:eq(0)');
    var pageNumber = $('#content > ul li:eq(1)');
    var nextButton = $('#content > ul li:eq(2)');

    pageNumber.text('Criteria '+pageNr+' of '+criteriaNr+'')

    if (next == false){
        nextButton.find('a').remove();
    } else {
        if (nextButton.find('a').length > 0){
            nextButton.children('a').attr('href', next);
        } else {
            nextButton.append('<a href="'+next+'" class="next">Next</a>');
        }
    }

    if (prev == false){
        prevButton.find('a').remove();
    } else {
        if (prevButton.find('a').length > 0){
            prevButton.children('a').attr('href', prev);
        } else {
            prevButton.append('<a href="'+prev+'" class="next">Next</a>');
        }
    }
}

/**
 * On document load
 */
$(document).ready(function(){
    handleSlider();

    // align navigation
    $('#content > ul').css('left', ($('#content').width()-$('#content > ul').width())/2);

    // load next criteria for evaluation
    $('#content .next, #content .previous').live('click', function(){
        Evaluation.NextCriteria($(this));
        return false;
    });
});
