/* Raphael graph javascript
 * @author        Taj Pelc
 * @version       1.0
*/

Graph = {};

Graph.Data = {};

Graph.Config = {
    'width': 666,
    'rowHeight': 60,
    'bottomLegend': 25,
    'leftLegendOffset': 157,
    'tickWidth': 50,
};

Graph.initAbacon = function(){

    // get container
    var container = $('#abacon');

    // calculate abacon height
    var height = Graph.Data['criteriaNr'] * Graph.Config['rowHeight'] + Graph.Data['criteriaNr'] + Graph.Config['bottomLegend'];

    // resize abacon container
    container.css({
        height: height,
        width: Graph.Config['width'],
    });

    // resize accoredion container
    container.parent('.ui-accordion-content').css({
        height: height + 20,
    });

    // create canvas
    var canvas = Raphael("abacon", Graph.Config['width'], height);

    // draw background
    var graph = canvas.rect(1, 0, Graph.Config['width']-1, '100%', 10).attr({
        stroke: '#dddee2',
    });

    // draw horizontal grid
    for(i=0; i<Graph.Data['criteriaNr']; i++)
    {
        canvas.path('M 0 ' + (60 * (i+1)) + '.5 h ' + Graph.Config['width']).attr({
            'stroke': '#dddee2',
            'stroke-dasharray': '-',
            'stroke-width': 1
        });
    }

    // draw vertical grid
    for(i=0; i<=10; i++)
    {
        canvas.path('M ' + (Graph.Config['leftLegendOffset'] + (i*Graph.Config['tickWidth'])) + ' 0 v ' + height).attr({
            'stroke': '#dddee2',
            'stroke-dasharray': '-',
            'stroke-width': 1
        });
    }

    // get alternative
    var Alternative = Graph.Data['Alternatives'][0];


    // create & draw data points
    var dataPoints = [];
    for (i=0; i<Graph.Data['criteriaNr']; i++)
    {
        // calculate x postion
        var x = Graph.Config['leftLegendOffset'] + parseInt(Alternative['criteria'][i]['score'] * 5, 10);

        // calculate y position
        var y = Graph.Config['rowHeight'] * i + (Graph.Config['rowHeight']/2);

        // add to arr
        dataPoints.push({
            x: x,
            y: y
        });
    }

    // build pathstring and draw line
    paths = [];
    for (i=0; i<dataPoints.length; i++)
    {
        var x = dataPoints[i]['x']; // get x position
        var y = dataPoints[i]['y']; // get y position

        // build path string
        paths.push(x + ' ' + y);
    }

    // animate paths
    Graph.AnimateDrawPath(0, paths, dataPoints, canvas);
}

Graph.AnimateDrawPath = function(i, paths, dataPoints, canvas)
{
    canvas.circle(dataPoints[i]['x'], dataPoints[i]['y'], 0).attr({
        stroke: '#000',
        fill: '#000',
    }).toFront().animate({r: 5, stroke: '#4b7eda', fill: '#4b7eda'}, 500);

    canvas.path('M' + paths[i]).attr({"stroke-width": 3, "stroke": '#000'}).animate({
        'path': 'M'+ paths[i] + ' L' + paths[i+1],
        "stroke": '#4b7eda',
    }, 500, 'cubic-bezier(p1)', function(){
        if(i < paths.length - 1)
        {
            Graph.AnimateDrawPath(i+1, paths, dataPoints, canvas);

        }
    });
}


$(document).ready(function(){
    Graph.Data = data;
    Graph.initAbacon();
});