/* Core javascript
 * @author        Frenk
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
             '/images/ferlauf.png',
             '/images/logo.png'
     ]);
});