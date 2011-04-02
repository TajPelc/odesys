/* Index javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

Index = {};

Index.Rotation = function() {
    //Set the opacity of all images to 0
    $('#sidebar ul li').css({opacity: 0.0});

    //Get the first image and display it (gets set to full opacity)
    $('#sidebar ul li.show').css({opacity: 1});

    $('#sidebar ol li:first p').switchClass('', 'glow', 1000);

    //Call the rotator function to run the slideshow, 6000 = change to next image after 6 seconds
    setInterval('Index.Rotate()',3000);

}

Index.Rotate = function() {
    //Get the first image
    var currentImage = $('#sidebar ul li.show');

    //Get next image, when it reaches the end, rotate it back to the first image
    var nextImage = ((currentImage.next().length) ? ((currentImage.next().hasClass('show')) ? $('#sidebar ul li:first') : currentImage.next()) : $('#sidebar ul li:first'));

    //Set the fade in effect for the next image
    nextImage.css({opacity: 0.0}).addClass('show').animate({opacity: 1.0}, 500);

    //Hide the current image
    currentImage.animate({opacity: 0.0}, 500).removeClass('show');



    //Highlight list
    var currentList = $('#sidebar ol li.current');

    //Get next list
    var nextList = ((currentList.next().length) ? ((currentList.next().hasClass('glow')) ? $('#sidebar ol li:first') : currentList.next()) : $('#sidebar ol li:first'));

    //Set glow
    nextList.addClass('current').children('p').switchClass('', 'glow', 500);

    currentList.removeClass('current').children('p').removeClass('glow');
};


$(document).ready(function() {
    //Load the slideshow
    setTimeout('Index.Rotation()', 1000);
});