/**
 * On document load
 */
$(document).ready(function(){
    $('#evaluation input[type=submit]').remove();
    $(function() {
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
                    $(this).parent().parent().find('input').attr('value', ui.value);
                    params = extractNumbers($(this).parent().find('input').attr('name'));

                    $.post(
                        'index.php?r=evaluation/update', {
                            grade: ui.value,
                            params: params,
                        },
                        function(data) {
                    });
                }
            }));
            $(this).remove();
        });
    });
    $(function() {
        $("input:submit, a.button").button();
    });

    $('#sort-type').click(function(){
        $.post(
            window.location.toString(), {
                sortType: 'kek',
            },
            function(data) {
        });
    });
});
