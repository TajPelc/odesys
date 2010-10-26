/**
 * Animate how to use odesys list
 * @params: List items, animate from class, animate to class
 * @return
 */
function animateListElements(lists, classFrom, classTo){
    startTime = -1000;
    $(lists).each(function(index, element){
        startTime = startTime + 2000;
        start2ndTime = startTime + 1500;
        setTimeout(function(){
            $(element).children('p').switchClass(classFrom, classTo, 500);
        }, startTime);
        setTimeout(function(){
            $(element).children('p').switchClass(classTo, classFrom, 500);
        }, start2ndTime);
    });
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

// iterate the animation "i" times
function animateList(){
    timer = -26000;
    for (x = 0; x < 50; x++) {
        timer = timer + 26000;
        setTimeout(function(){
            animateListElements('#content li', '', 'bg');
        }, timer);
        x++;
    }
}

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

    // animate list
    animateList();
});
