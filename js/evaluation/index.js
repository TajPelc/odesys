function saveAndContinue()
{
    startLoading();
    $.post(window.location.toString(), $('#evaluation').serialize(), function(data){
        window.location.replace(location.protocol + '//'+ location.hostname + location.pathname + '?r=' + data['redirect']);
    });
}


/**
 * Change select input fields to sliders
 */
function handleSlider()
{
    // remove submit
    $('#evaluation input[type=submit]').remove();

    // prettyfy links
    $("input:submit, a.button").button();

    // slidify
    $('#evaluation ul li p > select').each(function() {
        val = $(this).find('option:selected').val();
        name = $(this).attr('name');

        $(this).parent().parent().append($('<input type="hidden"></input>').attr('value', val).attr('name', name));
        $(this).parent().parent().append($('<div></div>').slider({
            value: val,
            min: 0,
            max:10,
            step: 1,
            range: "min",
            animate: true,
            stop: function(event, ui) {
                sliderSlider = $(this).parent();
                startLoading(true, sliderSlider);
                $(this).parent().parent().find('input').attr('value', ui.value);
                params = extractNumbers($(this).parent().find('input').attr('name'));
                $.post(
                    'index.php?r=evaluation/update', {
                        grade: ui.value,
                        params: params,
                        fetchMenu: true,
                    },
                    function(data) {
                        stopLoading();

                        // check menu items
                        handleProjectMenu(data['menu']);

                        // show continue link
                        if(data['menu']['menu-analysis']['enabled'])
                        {
                            $('#continue').fadeIn(2000);
                        }
                        if (sliderSlider.hasClass('new')){
                            sliderSlider.removeClass('new');
                            animateByColorChange(sliderSlider, '#FFD700', 500, 500);
                        }
                });
            }
        }));
        $(this).remove();
    });
}

/**
 * On document load
 */
$(document).ready(function(){
    handleSlider();

    // disable continue link
    if(!$('#menu-analysis').is('a'))
    {
        $('#continue').hide();
    }

    $('#sortByCriteria, #sortByAlternatives').live('click', function(event){
        startLoading(true);
        $.post(
            window.location.toString(), {
                sortType: $(this).attr('id'),
            },
            function(data) {
                $('#content').html(data['html']);

                // linkify
                $('#continue').click(function(event){
                    saveAndContinue();
                    event.preventDefault();
                });

                handleSlider();
                stopLoading();
        });
        event.preventDefault();
    });
});