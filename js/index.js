/**
 * On document load
 */
$(document).ready(function(){
    $(function() {
        $("a.button").button();
    });

    // open project overlay
    $('#create').click(function(event){
        projectOverlay($(this).attr('href'), 'criteria/create');
        event.preventDefault();
    });

    // animate the list
    animateList();
});

/**
 * Animate how to use odesys list
 * @return
 */
function animateList()
{
    setTimeout(function(){
        $('#content li:eq(0) p').switchClass('','bg', 500);
    }, 1000);

    setTimeout(function(){
        $('#content li:eq(0) p').switchClass('bg','basic', 500);
    }, 2500);

    setTimeout(function(){
        $('#content li:eq(1) p').switchClass('','bg', 500);
    }, 3000);
    setTimeout(function(){
        $('#content li:eq(1) p').switchClass('bg','basic', 500);
    }, 4500);

    setTimeout(function(){
        $('#content li:eq(2) p').switchClass('','bg', 500);
    }, 5000);
    setTimeout(function(){
        $('#content li:eq(2) p').switchClass('bg','basic', 500);
    }, 6500);

    setTimeout(function(){
        $('#content li:eq(3) p').switchClass('','bg', 500);
    }, 7000);
    setTimeout(function(){
        $('#content li:eq(3) p').switchClass('bg','basic', 500);
    }, 8500);

    setTimeout(function(){
        $('#content li:eq(4) p').switchClass('','bg', 500);
    }, 9000);
    setTimeout(function(){
        $('#content li:eq(4) p').switchClass('bg','basic', 500);
    }, 10500);

    setTimeout(function(){
        $('#content li:eq(5) p').switchClass('','bg', 500);
    }, 11000);
    setTimeout(function(){
        $('#content li:eq(5) p').switchClass('bg','basic', 500);
    }, 12500);

    setTimeout(function(){
        $('#content li:eq(6) p').switchClass('','bg', 500);
    }, 13000);
    setTimeout(function(){
        $('#content li:eq(6) p').switchClass('bg','basic', 500);
    }, 14500);

    setTimeout(function(){
        $('#content #create').animate({
        opacity: 0.2
        }, 300).addClass('glow')
    }, 15300);
    setTimeout(function(){
        $('#content #create').animate({
        opacity: 1
        }, 300).removeClass('glow')
    }, 15600);
}