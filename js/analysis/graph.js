/* Raphael graph javascript
 * @author        Taj Pelc
 * @version       1.0
*/

Graph = {};

Graph.Data = {};

Graph.Config = {
    'width': 666,
    'rowHeight': 60,
    'lineWidth': 2,
    'bottomLegend': 25
};

Graph.initAbacon = function(){

    // get container
    var container = $('#abacon');

    // calculate abacon height
    var height = Graph.Data['criteriaNr'] * Graph.Config['rowHeight'] + Graph.Data['criteriaNr'] * Graph.Config['rowHeight'];

    // resize abacon container
    container.css({
        height: height,
        width: Graph.Config['width'],
//        border: '1px solid red',
    });

    // resize accoredion container
    container.parents().find('.ui-accordion-content').css({
        height: height + 20,
    });

    // create canvas
    var canvas = Raphael("abacon", Graph.Config['width'], height);

    // draw background
    var graph = canvas.rect(1, 0, Graph.Config['width']-1, '100%', 10).attr({
        stroke: '#dddee2',
    });

    return;

    // datapoints
    var dataPoints = [];

    for (i=0; i<Graph.Data.length; i++)
    {
        var x = parseInt(Graph.Data[i]*4, 10);
        var y = 30*i + 15;
        var element = canvas.circle(x, y, 6);
        element.attr({
            stroke: '#4b7eda',
            fill: '#4b7eda',
        });

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

    var path = canvas.path(pathString).toBack();
    path.attr({"stroke-width": 3, "stroke": '#4b7eda'});
}

$(document).ready(function(){
    Graph.Data = data;
    Graph.initAbacon();
});