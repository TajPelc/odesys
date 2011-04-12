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
    }).animate({r: 3}, 250, 'elastic');
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
        }, 250, 'cubic-bezier(p1)');
        Graph.Elements[n].push(pathShadow);
        pathShadow.blur(1);
    }

    // draw path
    Graph.Elements[n].push(Graph.Canvas.path('M' + paths[i]).translate(5,0).attr({"stroke-width": 3, "stroke": '#000'}).animate({
        'path': 'M'+ paths[i] + ' L' + paths[i+1],
        "stroke": color,
    }, 200, 'cubic-bezier(p1)', function(){
        // not all lines yet drawn
        if(i < paths.length - 1)
        {
            // recursion
            Graph.AnimateDrawPath(i+1, n, color, paths, dataPoints);
        }
        else // fade in sidebar
        {
            $('#abacon-sidebar ul li[id="alternative_' + n + '"] span.remove').fadeIn();
        }
    }));

    // draw data points
    var dot = Graph.Canvas.circle(dataPoints[i]['x'], dataPoints[i]['y'], 0).attr({
        'stroke-width': '5px',
        stroke: '#000',
        fill: '#000',
    }).animate({r: 3, stroke: color, fill: color}, 250);

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
        $('ul.selectBox-dropdown-menu li a[rel="'+ id +'"]').hide().addClass('hidden');

        // draw alternatives
        Graph.DrawAlternative(Core.ExtractNumbers($(this).attr('id')));
    });

    // draw on demand
    $('ul.selectBox-dropdown-menu li a').live('click', function(){
        //get id
        var id = Core.ExtractNumbers($(this).attr('rel'));

        // draw alternative
        Graph.DrawAlternative(id);

        // hide dropdown element
        $(this).hide().addClass('hidden');

        // select all non-draw alternatives
        var alternativePool = $('ul.selectBox-dropdown-menu li a:not(.hidden)');

        // select label
        var label = $('#abacon-sidebar form span.selectBox-label');

        // empty label
        label.empty();

        // set label value
        if(alternativePool.length > 0)
        {
            label.html(alternativePool.first().html());
        }
        else
        {
            $('#abacon-sidebar form fieldset span.selectBox-arrow').fadeOut(500, function(){
                $('#abacon-sidebar form fieldset').hide();
                $('#abacon-sidebar form').append($('<span id="disabledDropdown">&nbsp;</span>').addClass('selectBox-dropdown').css({display: 'block'}));
            });
        }

        // remove span
        var x = $('<span>X</span>')
            .addClass('remove')
            .css({'display': 'block'})
            .hide();

        // legend list element
        var li = $('<li>' + Graph.Data['Alternatives'][id]['title'] + '</li>')
            .attr('id', 'alternative_' + id)
            .append($('<span>&nbsp;</span>')
                .addClass('color')
                .css({'background-color': Graph.Data['Alternatives'][id]['color']})
            ).append(x);

        // append li
        $('#abacon-sidebar ul').append(li);

        // fade in
        li.fadeIn();

        return false;
    });

    // remove alternative
    $('#abacon-sidebar ul li span.remove').live('click', function(){
        // get id
        var id = Core.ExtractNumbers($(this).parent().attr('id'));

        // get list element link
        var link = $('ul.selectBox-dropdown-menu li a[rel="' +  id+ '"]');

        // all elements hidden
        if($('ul.selectBox-dropdown-menu li a.hidden').length ==  $('ul.selectBox-dropdown-menu li a').length)
        {
            $('#abacon-sidebar form fieldset').show();
            $('#disabledDropdown').remove();
            $('#abacon-sidebar form fieldset span.selectBox-arrow').fadeIn();
            $('#abacon-sidebar form span.selectBox-label').html(link.html());
        }

        // reenable dropdown element
        link.show().removeClass('hidden');

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
