/* Raphael graph javascript
 * @author        Taj Pelc
 * @version       1.0
*/

// define Abacon object
Abacon = {};
Abacon.Container = {};
Abacon.Canvas = {};
Abacon.Legend = {};
Abacon.ScoreBoard = {};

// handle previous / next buttons
Abacon.HandleButtons = true;

// cotainer for Abacon drawn elements
Abacon.Elements = [];
Abacon.Alternatives = [];

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

    // set container height
    Abacon.Container.css({'height': Abacon.Config['height']});

    // create canvas
    Abacon.Canvas = Raphael("abacon", Abacon.Config['width'], Abacon.Config['height']);

    // container
    Abacon.Canvas.rect(0, 0, Abacon.Config['width'], Abacon.Config['height']).attr({'stroke': '#c7cacf'});

    // draw horizontal grid
    for(i=0; i<Graph.Data['criteriaNr']; i++)
    {
        Abacon.Canvas.path('M 0 ' + ((60 * (i+1))) + '.5 h ' + (Abacon.Config['width']-8.5)).attr({
            'stroke': '#dedfe3',
            'stroke-width': 1
        });
    }

    // draw vertical grid
    for(i=0; i<=9; i++)
    {
        var dashArray = '';
        if(i>0)
        {
            dashArray = '-';
        }
        Abacon.Canvas.path('M ' + (Abacon.Config['leftLegendOffset'] + (i*Abacon.Config['tickWidth'])) + '.5 0 v ' + Abacon.Config['height']).attr({
            'stroke': '#dedfe3',
            'stroke-dasharray': dashArray,
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
            score: Graph.Data['Alternatives'][n]['criteria'][i]['weightedScore'],
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
    // build path for animation
    var path = '';
    for(j=0; j<=i; j++)
    {
        var action = ' L';
        if(j==0)
        {
            action = 'M';
        }
        path = path + action + paths[j];
    }

    // first data point
    if(i==0)
    {
        // create the path and data point
        Abacon.Alternatives[n] = Abacon.Canvas.path(path).attr({"stroke-width": 4, "stroke": color});
        Abacon.Elements[n].push(Abacon.Alternatives[n]);
        Abacon.AnimateDataPoint(i, n, color, dataPoints)
        Abacon.AnimateDrawPath(i+1, n, color, paths, dataPoints);
    }
    else
    {
        // animate path to the next position
        Abacon.Alternatives[n].animate({
            'path': path,
        }, 250, 'normal', function(){

            // draw data point
            Abacon.AnimateDataPoint(i, n, color, dataPoints)

            // until full drawn, repeat process
            if(i < paths.length - 1)
            {
                Abacon.AnimateDrawPath(i+1, n, color, paths, dataPoints);
            }
            else // when complete
            {
                // fade in sidebar
                $('#abacon-sidebar ul.legend li[id="alternative_' + n + '"] span.remove').fadeIn();

                // handlebuttons
                if(Abacon.HandleButtons)
                {
                    Abacon.HandleButtons = false;

                    // enable next step
                    $.ajax({
                        data: {
                            'action': 'enableSharing',
                        },
                        success: function(data) {
                            if(data['status'] == true)
                            {
                                Core.ProjectMenu(data['projectMenu']);
                                Core.ContentNav.toggle('overview', data['projectMenu']);
                            }
                        }
                    });
                }
            }
        });
    }
}

/**
 * Animates data points
 */
Abacon.AnimateDataPoint = function(i, n, color, dataPoints)
{
    if(Abacon.ScoreBoard[i] instanceof Object){
    }
    else{
        Abacon.ScoreBoard[i] = {};
    }

    // create and append span
    Abacon.ScoreBoard[i][n] = $('<span class="score">' + dataPoints[i]['score'].toFixed(1) + ' points</span>');
    Abacon.Container.append(Abacon.ScoreBoard[i][n]);

    // recalculate position
    var css = {
        top: dataPoints[i]['y'] - parseInt(Abacon.ScoreBoard[i][n].outerHeight() / 2),
        left: dataPoints[i]['x'] + 20,
        borderColor: color,
    };

    // apply position
    Abacon.ScoreBoard[i][n].css(css);

    // draw data points
    var dot = Abacon.Canvas.circle(dataPoints[i]['x'], dataPoints[i]['y'], 6).attr({
        'stroke-width': '2px',
        stroke: 'white',
        fill: 'white',
    }).animate({r: 3, stroke: color}, 500);

    // draw dot for hovering
    var hoverDot = Abacon.Canvas.circle(dataPoints[i]['x'], dataPoints[i]['y'], 15).attr({
        'stroke-width': 'none',
        stroke: color,
        fill: color,
        'opacity': 0.1,
        'fill-opacity': 0
    });

    // hover over dot (to make life easier)
    hoverDot.mouseover(function (event) {
        dot.animate({r: 8}, 1000, 'elastic');
        Abacon.ScoreBoard[i][n].show();
    });
    hoverDot.mouseout(function (event) {
        dot.animate({r: 3}, 1000, 'elastic');
        Abacon.ScoreBoard[i][n].hide();
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

    // select all non-draw alternatives
    var nonHidden = Abacon.Legend.DropdownList.find('li:not(.hidden)');

    // set label value
    if(nonHidden.length == 0)
    {
        Abacon.Legend.Fieldset.find('a span[class*=selectBox-arrow]').fadeOut();
        Abacon.Legend.Fieldset.find('span.selectBox-label').html('All alternatives are drawn');
    }
}