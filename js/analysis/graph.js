/* Raphael graph javascript
 * @author        Taj Pelc
 * @version       1.0
*/

Graph = {};

Graph.Data = {};

Graph.Elements = [];

Graph.Config = {
    'width': 666,
    'rowHeight': 60,
    'bottomLegend': 25,
    'leftLegendOffset': 157,
    'tickWidth': 50,
};

Graph.initAbacon = function(){

    // get container
    Graph.Container = $('#abacon');

    // calculate abacon height
    Graph.Height = Graph.Data['criteriaNr'] * Graph.Config['rowHeight'] + Graph.Data['criteriaNr'] + Graph.Config['bottomLegend'];

    // resize abacon container
    Graph.Container.css({
        height: Graph.Height,
        width: Graph.Config['width'],
    });

    // resize accoredion container
    Graph.Container.parent('.ui-accordion-content').css({
        height: Graph.Height + 20,
    });

    // create canvas
    Graph.Canvas = Raphael("abacon", Graph.Config['width'], Graph.Height);

    // draw background
    Graph.Background = Graph.Canvas.rect(1, 0, Graph.Config['width']-1, '100%', 10).attr({
        stroke: '#dddee2',
    });

    // draw horizontal grid
    for(i=0; i<Graph.Data['criteriaNr']; i++)
    {
        Graph.Canvas.path('M 0 ' + (60 * (i+1)) + '.5 h ' + Graph.Config['width']).attr({
            'stroke': '#dddee2',
            'stroke-dasharray': '-',
            'stroke-width': 1
        });
    }

    // draw vertical grid
    for(i=0; i<=10; i++)
    {
        Graph.Canvas.path('M ' + (Graph.Config['leftLegendOffset'] + (i*Graph.Config['tickWidth'])) + ' 0 v ' + Graph.Height).attr({
            'stroke': '#dddee2',
            'stroke-dasharray': '-',
            'stroke-width': 1
        });
    }
}

/**
 * Calculates the points and calls animate path
 */
Graph.DrawAlternative = function(n)
{
    // create & draw data points
    var dataPoints = [];
    for (i=0; i<Graph.Data['criteriaNr']; i++)
    {
        // calculate x postion
        var x = Graph.Config['leftLegendOffset'] + parseInt(Graph.Data['Alternatives'][n]['criteria'][i]['weightedScore'] * 5, 10);

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

    // array for elements
    Graph.Elements[n] = [];

    // animate paths
    Graph.AnimateDrawPath(0, n, Graph.Data['Alternatives'][n]['color'], paths, dataPoints);
}

/**
 * Animates draw path and data points
 */
Graph.AnimateDrawPath = function(i, n, color, paths, dataPoints)
{
    // draw data points shadow /** EXPERIMENTAL **/
    var shadowDot = Graph.Canvas.circle(dataPoints[i]['x'] + 1, dataPoints[i]['y'] + 1, 0).attr({
        'stroke-width': '5px',
        stroke: '#000',
        fill: 'none',
        opacity: 0.3,
    }).animate({r: 3}, 500, 'elastic');
    Graph.Elements[n].push(shadowDot);

    // draw path shadow /** EXPERIMENTAL **/
    if(i < paths.length - 1)
    {
        var pathShadow = Graph.Canvas.path('M' + paths[i]).attr({
            'stroke-width': 3,
            stroke: "#000",
            'opacity': 0.4,
        }).animate({
            'path': 'M'+ (dataPoints[i]['x'] + 2) + ' ' + (dataPoints[i]['y'] + 1) + ' L' + (dataPoints[i+1]['x'] + 1) + ' ' + (dataPoints[i+1]['y'] + 2),
        }, 500, 'cubic-bezier(p1)');
        Graph.Elements[n].push(pathShadow);
        pathShadow.blur(1);
    }


    // draw path
    Graph.Elements[n].push(Graph.Canvas.path('M' + paths[i]).translate(5,0).attr({"stroke-width": 3, "stroke": '#000'}).animate({
        'path': 'M'+ paths[i] + ' L' + paths[i+1],
        "stroke": color,
    }, 500, 'cubic-bezier(p1)', function(){
        // not all lines yet drawn
        if(i < paths.length - 1)
        {
            // recursion
            Graph.AnimateDrawPath(i+1, n, color, paths, dataPoints);
        }
        else // fade in sidebar
        {
            $('#abacon-sidebar ul span.remove').fadeIn();
        }
    }));

    // draw data points
    var dot = Graph.Canvas.circle(dataPoints[i]['x'], dataPoints[i]['y'], 0).attr({
        'stroke-width': '5px',
        stroke: '#000',
        fill: '#000',
    }).animate({r: 3, stroke: color, fill: color}, 500);

    // draw dot for hovering
    var hoverDot = Graph.Canvas.circle(dataPoints[i]['x'], dataPoints[i]['y'], 15).attr({
        'stroke-width': '5px',
        stroke: 'red',
        fill: 'red',
        'opacity': 0,
    })

    // hover over dot (to make life easier)
    hoverDot.mouseover(function (event) {
        dot.animate({r: 6}, 1000, 'elastic');
        shadowDot.animate({r: 6}, 1000, 'elastic');
    });
    hoverDot.mouseout(function (event) {
        dot.animate({r: 3}, 1000, 'elastic');
        shadowDot.animate({r:3}, 1000, 'elastic');
    });

    // push to elements
    Graph.Elements[n].push(dot);
    Graph.Elements[n].push(hoverDot);
}

/**
 * Document load
 */
$(document).ready(function(){
    Graph.Data = data;
    Graph.initAbacon();

    // hide ui
    $('#abacon-sidebar ul span.remove').hide();

    // draw all selected alternaitves
    $('#abacon-sidebar ul li').each(function(){
        //get id
        var id = Core.ExtractNumbers($(this).attr('id'));

        // remove all selected options from the drop down
        $('#abacon-sidebar select option[value="'+ id + '"], ul.selectBox-dropdown-menu li a[rel="'+ id +'"]').remove();

        // draw alternatives
        Graph.DrawAlternative(Core.ExtractNumbers($(this).attr('id')));
    });

    // draw on demand
    $('ul.selectBox-dropdown-menu li a, #abacon-sidebar input[type="submit"]').live('click', function(){
        //get id
        var id = Core.ExtractNumbers($(this).attr('rel'));

        // draw alternative
        Graph.DrawAlternative(id);

        // remove link
        $(this).remove();
        // remove label
        $('span.selectBox-label').remove();

        // @TODO prepare li etc ...
        var li = $('<li>' + Graph.Data['Alternatives'][id]['title'] + '</li>')
            .attr('id', 'alternative_' + id)
            .append($('<span>&nbsp;</span>')
                .addClass('color')
                .css({'background-color': Graph.Data['Alternatives'][id]['color']})
            )
            .append($('<span>X</span>')
                .addClass('remove')
                .css({'display': 'block'})
            )
            .hide();

        // append li
        $('#abacon-sidebar ul').append(li);

        // fade in
        li.fadeIn();
    });

    // remove alternative
    $('#abacon-sidebar ul li span.remove').live('click', function(){
        // get id
        var id = Core.ExtractNumbers($(this).parent().attr('id'));

        /**
         * @TODO - FIX ADDING ELEMENTS BACK TO THE MENU
         */
        var li = $('<li></li>').attr('rel', id).val(Graph.Data['Alternatives'][id]['title']);
        $('ul.selectBox-dropdown-menu').append(li);

        // fadeout & remove elements
        for(i=0; i < Graph.Elements[id].length; i++)
        {
            Graph.Elements[id][i].animate({'opacity': 0}, 300, function(){
                this.remove();
            });
        }

        // fadeout legend item
        $(this).parent().fadeOut(300, function(){
            $(this).remove();
        });
    });
});
