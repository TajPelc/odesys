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

    var dataPoints = [];
    for (i=0; i<Graph.Data['criteriaNr']; i++)
    {
        var x = parseInt(Alternative['criteria'][i]['score'] * 5, 10);
        var y = Graph.Config['rowHeight']*i + (Graph.Config['rowHeight']/2);
        var element = canvas.circle(x, y, 6).attr({
            stroke: '#4b7eda',
            fill: '#4b7eda',
        }).toFront();

        // add to arr
        dataPoints.push({
            element: element,
            x: x,
            y: y
        });
    }

    pathString = '';
    start = true;
    for (i=0; i<dataPoints.length; i++)
    {
        var char = 'L';
        if(start)
        {
            char = 'M';
            start = false;
        }
        var x = dataPoints[i]['x'];
        var y = dataPoints[i]['y'];
        pathString = pathString + ' ' + char + ' '+ x + ' ' + y;
    }

    var path = canvas.path(pathString);
    path.attr({"stroke-width": 3, "stroke": '#4b7eda'});
}

$(document).ready(function(){
    Graph.Data = data;
    Graph.initAbacon();
});