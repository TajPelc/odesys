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
    Evaluation.NextCriteria.Url = that.attr('href');
    $.post(Evaluation.NextCriteria.Url, {
        'action': 'getContent'
    }, function(data){
        if(data['status'] == true){

            //make forms height fixed
            var formHeight = $('#content form').height();
            $('#content form').css('width', formHeight);

            //insert new criteria
            $('#content h2, #content form').remove();
            $('#content p').after(data['html']);
        }
    });

}

/**
 * On document load
 */
$(document).ready(function(){
    handleSlider();

    // align navigation
    $('#content > ul').css('left', ($('#content').width()-$('#content > ul').width())/2);

    // load next criteria for evaluation
    $('#content .next, #content .previous').click(function(){
        Evaluation.NextCriteria($(this));
        return false;
    });
});
