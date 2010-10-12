/**
 * On document load
 */
$(document).ready(function(){
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
                slide: function(event, ui) {
                    $(this).parent().parent().find('input').attr('value', ui.value);
                }
            }));
            $(this).remove();
        });
    });
    $(function() {
        $("input:submit").button();
    });
});
