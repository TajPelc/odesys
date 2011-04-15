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

/**
 * Score config
 */
Score.Config = {
    'height': 0, // dynamically set
    'width': 666,
    'rowHeight': 60,
    'bottomLegend': 25,
    'leftLegendOffset': 157,
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

    // cotainer for Score drawn elements
    Score.Elements = Score.Canvas.set();

    // draw horizontal grid
    for(i=0; i<Score.nrAlternatives; i++)
    {
        Score.Canvas.path('M 0 ' + (60 * (i+1)) + '.5 h ' + Score.Config['width']).attr({
            'stroke': '#dddee2',
            'stroke-dasharray': '-',
            'stroke-width': 1
        });
    }

    // draw vertical grid
    for(i=0; i<=10; i++)
    {
        Score.Canvas.path('M ' + (Score.Config['leftLegendOffset'] + (i*Score.Config['tickWidth'])) + ' 0 v ' + Score.Config['height']).attr({
            'stroke': '#dddee2',
            'stroke-dasharray': '-',
            'stroke-width': 1
        });
    }

    // draw alternatives
    Score.DrawAlternative(0);
}

/**
 * Recursively draw all alternatives
 */
Score.DrawAlternative = function(i)
{
    // avoid division by zero
    if(Score.Scores[0]['weightedTotal'] == 0)
    {
        Score.Scores[0]['weightedTotal'] = 1;
    }

    // calculate width
    width = parseInt(((Score.Scores[i]['weightedTotal'] / Score.Scores[0]['weightedTotal'])*100)*5);

    // calculate x postion
    var x = Abacon.Config['leftLegendOffset']+0.5;

    // calculate y position
    var y = Abacon.Config['rowHeight'] * i + (Abacon.Config['rowHeight']/2) - 10;

    // create a set for alternatives
    var Alternative = Score.Canvas.set();
    // shadow
    Alternative.push(Score.Canvas.rect(x+2, y+2, 0, 20).attr({
        'fill': '#000',
        'stroke-width': 0,
        'opacity': 0.4,
    }).animate({
        width: width,
    }, 500, '<>').blur(1));

    // rectangle
    Alternative.push(Score.Canvas.rect(x-1, y, 0, 20, 0).attr({
        'fill': '#000',
        'stroke': '#000',
        'stroke-width': 0,
    }).animate({
        'fill': Score.Scores[i]['color'],
        'stroke': Score.Scores[i]['color'],
        width: width,
    }, 500, '<>', function(){
        if(i < Score.Scores.length-1)
        {
            i++;
            Score.DrawAlternative(i);
        }
    }));

    Score.Elements.push(Alternative);
}