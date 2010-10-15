/**
 * On document load
 */
$(document).ready(function(){
    $(function() {
        $("a.button").button();
    });

    $('#create').click(function(event){
        projectOverlay($(this).attr('href'), true);
        event.preventDefault();
    });

    var olHeight = $('#content ol').height();

    $('#content li').hide().parent().height(olHeight);

    setTimeout(function(){
        $('#content li:eq(0)').fadeIn(500);
    }, 1000);
    setTimeout(function(){
        $('#content li:eq(1)').fadeIn(500);
    }, 3000);
    setTimeout(function(){
        $('#content li:eq(2)').fadeIn(500);
    }, 5000);
    setTimeout(function(){
        $('#content li:eq(3)').fadeIn(500);
    }, 7000);
    setTimeout(function(){
        $('#content li:eq(4)').fadeIn(500);
    }, 9000);
    setTimeout(function(){
        $('#content li:eq(5)').fadeIn(500);
    }, 11000);
    setTimeout(function(){
        $('#content li:eq(6)').fadeIn(500);
    }, 13000);
    setTimeout(function(){
        $('#content #create').animate({
            opacity: 0.2
        }, 300).addClass('glow')
    }, 15000);
    setTimeout(function(){
        $('#content #create').animate({
            opacity: 1
        }, 300).removeClass('glow')
    }, 15300);
});
