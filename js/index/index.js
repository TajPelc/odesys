/* Index javascript
 * @author        Frenk T. Sedmak Nahtigal
 * @version       1.0
*/

Index = {};

$(document).ready(function() {
    $('img').error(function() {
        $(this).attr('src', "/images/gravatar_default.png");
    });
});