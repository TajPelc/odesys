/* Raphael graph javascript
 * @author        Taj Pelc
 * @version       1.0
*/

// define Abacon object
Abacon = {};
Abacon.Container = {};
Abacon.Canvas = {};
Abacon.Legend = {};

// cotainer for Abacon drawn elements
Abacon.Elements = [];

/**
 * Abacon config
 */
Abacon.Config = {
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
Abacon.init = function(){
    // init legend
    Abacon.Legend.init();

    // get container
    Abacon.Container = $('#abacon');

    // calculate abacon height
    Abacon.Config['height'] = Graph.Data['criteriaNr'] * Abacon.Config['rowHeight'] + Graph.Data['criteriaNr'] + Abacon.Config['bottomLegend'];

    // create canvas
    Abacon.Canvas = Raphael("abacon", Abacon.Config['width'], Abacon.Config['height']);

    // draw horizontal grid
    for(i=0; i<Graph.Data['criteriaNr']; i++)
    {
        Abacon.Canvas.path('M 0 ' + (60 * (i+1)) + '.5 h ' + Abacon.Config['width']).attr({
            'stroke': '#dddee2',
            'stroke-dasharray': '-',
            'stroke-width': 1
        });
    }

    // draw vertical grid
    for(i=0; i<=10; i++)
    {
        Abacon.Canvas.path('M ' + (Abacon.Config['leftLegendOffset'] + (i*Abacon.Config['tickWidth'])) + ' 0 v ' + Abacon.Config['height']).attr({
            'stroke': '#dddee2',
            'stroke-dasharray': '-',
            'stroke-width': 1
        });
    }
}

/**
 * Calculates the points and calls animate path
 */
Abacon.DrawAlternative = function(n)
{
    // create data point positions
    var dataPoints = [];
    for (i=0; i<Graph.Data['criteriaNr']; i++)
    {
        // calculate x postion
        var x = Abacon.Config['leftLegendOffset'] + parseInt(Graph.Data['Alternatives'][n]['criteria'][i]['weightedScore'] * 5, 10);

        // calculate y position
        var y = Abacon.Config['rowHeight'] * i + (Abacon.Config['rowHeight']/2);

        // add to arr
        dataPoints.push({
            x: x,
            y: y
        });
    }

    // build path strings
    paths = [];
    for (i=0; i<dataPoints.length; i++)
    {
        var x = dataPoints[i]['x']; // get x position
        var y = dataPoints[i]['y']; // get y position

        // build path string
        paths.push(x + ' ' + y);
    }

    // array for elements
    Abacon.Elements[n] = Abacon.Canvas.set();

    // animate paths
    Abacon.AnimateDrawPath(0, n, Graph.Data['Alternatives'][n]['color'], paths, dataPoints);
}

/**
 * Animates draw path and data points
 */
Abacon.AnimateDrawPath = function(i, n, color, paths, dataPoints)
{
    // draw data points shadow /** EXPERIMENTAL **/
    var shadowDot = Abacon.Canvas.circle(dataPoints[i]['x'] + 1, dataPoints[i]['y'] + 1, 0).attr({
        'stroke-width': '5px',
        stroke: '#000',
        fill: 'none',
        opacity: 0.3,
    }).animate({r: 3}, 250, 'elastic');
    Abacon.Elements[n].push(shadowDot);

    // draw path shadow /** EXPERIMENTAL **/
    if(i < paths.length - 1)
    {
        var pathShadow = Abacon.Canvas.path('M' + paths[i]).attr({
            'stroke-width': 3,
            stroke: "#000",
            'opacity': 0.4,
        }).animate({
            'path': 'M'+ (dataPoints[i]['x'] + 2) + ' ' + (dataPoints[i]['y'] + 1) + ' L' + (dataPoints[i+1]['x'] + 1) + ' ' + (dataPoints[i+1]['y'] + 2),
        }, 250, 'cubic-bezier(p1)');
        Abacon.Elements[n].push(pathShadow);
        pathShadow.blur(1);
    }

    // draw path
    Abacon.Elements[n].push(Abacon.Canvas.path('M' + paths[i]).translate(5,0).attr({"stroke-width": 3, "stroke": '#000'}).animate({
        'path': 'M'+ paths[i] + ' L' + paths[i+1],
        "stroke": color,
    }, 200, 'cubic-bezier(p1)', function(){
        // not all lines yet drawn
        if(i < paths.length - 1)
        {
            // recursion
            Abacon.AnimateDrawPath(i+1, n, color, paths, dataPoints);
        }
        else // fade in sidebar
        {
            $('#abacon-sidebar ul.legend li[id="alternative_' + n + '"] span.remove').fadeIn();
        }
    }));

    // draw data points
    var dot = Abacon.Canvas.circle(dataPoints[i]['x'], dataPoints[i]['y'], 0).attr({
        'stroke-width': '5px',
        stroke: '#000',
        fill: '#000',
    }).animate({r: 3, stroke: color, fill: color}, 250);

    // draw dot for hovering
    var hoverDot = Abacon.Canvas.circle(dataPoints[i]['x'], dataPoints[i]['y'], 15).attr({
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
    Abacon.Elements[n].push(dot);
    Abacon.Elements[n].push(hoverDot);
}

/**
 * Initialize legend
 */
Abacon.Legend.init = function()
{
    // define legend items
    Abacon.Legend.Select = $('#abacon-sidebar form fieldset select');
    Abacon.Legend.Fieldset = $('#abacon-sidebar form fieldset');
    Abacon.Legend.LegendList = $('#abacon-sidebar ul.legend');
    Abacon.Legend.DropdownList = $('<ul></ul>').attr('id', 'abacon-dropdown').addClass('selectBox-dropdown-menu').hide();

    // handle click functionality to remove an alternative from abacon and legend
    Abacon.Legend.removeAlternative();

    // hide select box
    Abacon.Legend.Select.hide();

    // hide remove buttons
    Abacon.Legend.LegendList.find('span.remove').hide();

    // append dropdown list
    Abacon.Legend.Fieldset.append(Abacon.Legend.DropdownList);

    // populate ul
    Abacon.Legend.Select.find('option').each(function(){
        Abacon.Legend.DropdownList.append($('<li></li>')
           .attr('id', 'abacon-dropdown-' + $(this).attr('value'))
           .append($('<a></a>')
               .attr('rel', $(this).attr('value')).html($(this).html()))
       );
    });

    // hide alternatives drawn by default
    Abacon.Legend.LegendList.children().each(function(){
        Abacon.Legend.DropdownList.find('li a[rel="'+ Core.ExtractNumbers($(this).attr('id')) +'"]').parent().hide().addClass('hidden');
    });

    // recalculate dropdown position
    Abacon.Legend.rebuildDropdown();

    // display menu on click
    var a = true;
    Abacon.Legend.Fieldset.find('a').click(function () {
        // handle click functionality to show an alternative from dropdown
        if(a)
        {
            Abacon.Legend.displayFromDropdown();
            a = false;
        }

        // extend / shrink menu
        if(Abacon.Legend.DropdownList.find('li:not(.hidden)').length > 0)
        {
            if(Abacon.Legend.DropdownList.is(':hidden'))
            {
                Abacon.Legend.DropdownList.show();
                $(this).find('span.selectBox-arrow').attr('class', 'selectBox-arrow-reverse');
            }
            else
            {
                Abacon.Legend.DropdownList.hide();
                $(this).find('span.selectBox-arrow-reverse').attr('class', 'selectBox-arrow');
            }
        }
    });
}

/**
 * Display an alternative from the drop down menu
 */
Abacon.Legend.displayFromDropdown = function()
{
    Abacon.Legend.DropdownList.find('li a').click(function(){
        // get id
        var id = Core.ExtractNumbers($(this).attr('rel'));

        // switch arrrow
        Abacon.Legend.Fieldset.find('span.selectBox-arrow-reverse').attr('class', 'selectBox-arrow');

        // draw alternative
        Abacon.DrawAlternative(id);

        // hide dropdown element
        $(this).parent().hide().addClass('hidden');

        // recalculate position
        Abacon.Legend.rebuildDropdown();

        // select all non-draw alternatives
        var nonHidden = Abacon.Legend.DropdownList.find('li:not(.hidden)');

        // set label value
        if(nonHidden.length == 0)
        {
            Abacon.Legend.Fieldset.find('a span[class*=selectBox-arrow]').fadeOut();
            Abacon.Legend.Fieldset.find('span.selectBox-label').html('All alternatives are drawn');
        }

        // create span
        var x = $('<span>X</span>')
            .addClass('remove')
            .css({'display': 'block'})
            .hide();

        // create legend list element
        var li = $('<li>' + Graph.Data['Alternatives'][id]['title'] + '</li>')
            .attr('id', 'alternative_' + id)
            .append($('<span>&nbsp;</span>')
                .addClass('color')
                .css({'background-color': Graph.Data['Alternatives'][id]['color']})
            ).append(x).hide();

        // append li
        Abacon.Legend.LegendList.append(li);

        // fade in
        li.fadeIn();

        return false;
    });
}

/**
 * Remove alternative from abacon and legend
 */
Abacon.Legend.removeAlternative = function()
{
    // remove alternative
    Abacon.Legend.LegendList.find('li span.remove').live('click', function(){
        // get id
        var id = Core.ExtractNumbers($(this).parent().attr('id'));

        // get list element link
        var link = Abacon.Legend.DropdownList.find('li a[rel="' +  id+ '"]');

        // all alternatives hidden
        if(Abacon.Legend.DropdownList.find('li.hidden').length ==  Abacon.Legend.DropdownList.find('li').length)
        {
            Abacon.Legend.Fieldset.find('a span[class*=selectBox-arrow]').fadeIn();
            Abacon.Legend.Fieldset.find('span.selectBox-label').html('Draw more alternatives');
        }

        // reenable dropdown element
        link.parent().show().removeClass('hidden');

        // recalculate dropdown position position
        Abacon.Legend.rebuildDropdown();

        // fadeout & remove elements
        Abacon.Elements[id].animate({'opacity': 0}, 300, function(){
            this.remove();
        });

        // fadeout legend item
        $(this).parent().fadeOut(300, function(){
            $(this).remove();
        });
    });
}

/**
 * Recaluclates dropdown menu positon
 */
Abacon.Legend.rebuildDropdown = function()
{
    // adjust dropdown position
    Abacon.Legend.DropdownList.css({left: 0, bottom: -(Abacon.Legend.DropdownList.height() + 8)});
}