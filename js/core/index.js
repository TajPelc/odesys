/* Core javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

function ImagePreload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        $('<img/>')[0].src = this;
    });
}

$(document).ready(function(){
    // Preload images
    ImagePreload([
             '/images/bg/ferlauf.png',
             '/images/logo.png'
     ]);
});