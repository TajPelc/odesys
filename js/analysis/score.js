/* Raphael graph javascript
 * @author        Taj Pelc
 * @version       1.0
*/

// define Score object
Score = {};
Score.Container = {};
Score.Canvas = {};
Score.Legend = {};
Score.nrAlternatives = 0;
Score.Scores = [];
Score.Alternatives = [];

/**
 * Score config
 */
Score.Config = {
    'height': 0, // dynamically set
    'width': 666,
    'rowHeight': 60,
    'bottomLegend': 25,
    'leftLegendOffset': 155,
    'scoreOffset': 2,
    'tickWidth': 50,
};

/**
 * Create raphael container and draw grid
 */
Score.init = function(){
    // get container
    Score.Container = $('#score');

    // build the score aray from Graph.Data array
    for (i=0; i<Graph.Data['orderOfAlternatives'].length; i++) {
        var id = Graph.Data['orderOfAlternatives'][i];
        Score.Scores[i] = {
                'weightedTotal': Graph.Data['Alternatives'][id]['weightedTotal'],
                'color': Graph.Data['Alternatives'][id]['color'],
        };
        Score.nrAlternatives++;
    }

    // calculate Score height
    Score.Config['height'] = Score.nrAlternatives * Score.Config['rowHeight'] + Graph.Data['criteriaNr'] + Score.Config['bottomLegend'];

    // create canvas
    Score.Canvas = Raphael("score", Score.Config['width'], Score.Config['height']);

    // container
    Score.Canvas.rect(0, 0, Score.Config['width'], Score.Config['height']).attr({'stroke': '#c7cacf'});

    // cotainer for Score drawn elements
    Score.Elements = Score.Canvas.set();

    // draw horizontal grid
    for(i=0; i<Score.nrAlternatives; i++)
    {
        var line = Score.Canvas.path('M 0 ' + (60 * (i+1)) + '.5 h ' + (Score.Config['width']-8.5)).attr({
            'stroke': '#dedfe3',
            'stroke-width': 1
        });
    }

    // draw vertical grid
    for(i=0; i<=9; i++){
        var dashArray = '';

        if(i>0){
            dashArray = '-';
        }

        var path = Score.Canvas.path('M ' + (Score.Config['leftLegendOffset'] + (i*Score.Config['tickWidth'])) + '.5 0 v ' + Score.Config['height']).attr({
            'stroke': '#dedfe3',
            'stroke-dasharray': dashArray,
            'stroke-width': 1
        });
    }

    // create a set for alternatives
    Score.Alternatives = Score.Canvas.set();

    // draw alternatives
    Score.CreateAlternative(0);
}

/**
 * Recursively draw all alternatives
 */
Score.CreateAlternative = function(i)
{
    // the best scored alternative has value 0, everyone is zero
    if(Score.Scores[0]['weightedTotal'] == 0)
    {
        // set the same width
        width = 500;
    }
    else
    {
        // calculate width
        Score.Scores[i]['width'] = parseInt(((Score.Scores[i]['weightedTotal'] / Score.Scores[0]['weightedTotal'])*100)*5);
    }

    // calculate x postion
    var x = Score.Config['leftLegendOffset'] + Score.Config['scoreOffset'];

    // calculate y position
    var y = Score.Config['rowHeight'] * i + (Score.Config['rowHeight']/2) - 10;

    // rectangle
    var Alternative = Score.Canvas.rect(x-1.5, y+0.5, 0, 20, 0).attr({
        'fill': '#fff',
        'fill': Score.Scores[i]['color'],
        'stroke': '#596171',
        'opacity': 0.5,
        'stroke-width': 1,
    });

    // hover over dot (to make life easier)
    Alternative.mouseover(function (event) {
        Alternative.animate({'opacity': 1}, 500);
    });
    Alternative.mouseout(function (event) {
        Alternative.animate({'opacity': 0.5}, 500);
    });

    // add to set
    Score.Alternatives.push(Alternative);

    // not last => create more
    if(i < Score.Scores.length-1)
    {
        i++;
        Score.CreateAlternative(i);
    }
    else // last => draw alternatives
    {
        Score.DrawAlternatives();
    }

    Score.Elements.push(Alternative);
}

/**
 * Draw alternatives
 */
Score.DrawAlternatives = function(){
    $(Score.Alternatives).each(function(index, Alternative) {
        Alternative.animate({
            'fill': Score.Scores[index]['color'],
            width: Score.Scores[index]['width'],
            }, 1000, '<>');
    });
}