/**
 * Function plots a graph with the given data to a given container.
 *
 * @param anchor
 *            string
 * @param data
 *            array
 * @param title
 *            string
 * @param legend
 *            array
 * @return void
 */
function plotGraph(anchor, data, title, colors, legend)
{
    seriesArray = new Array();
    for(i=0; i<colors.length; i++)
    {
        Series = new Object();
        Series.label = legend[i];
        Series.color = colors[i];
        seriesArray.push(Series);
    }

    graphHeight = ( 80 * chartData.nrCriteria ) + 62;

    $.jqplot(anchor, data, {
        height: graphHeight,
        sortData: false,
        legend:{show:false},
        title: {
            text: title,
            show: false,
            fontSize: '16px',
            textColor: 'black',
        },

        grid:{
            background:'#fff',
            gridLineColor:'#dbe3f0',
            borderColor:'#dbe3f0',
            shadow: false,
        },

        series: seriesArray,

        axes:{
            xaxis:{
                ticks: [-5, 0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 105],
                tickOptions:{
                    formatString:'%d',
                    fontSize:'12px',
                },
                label: '=> score =>',
                labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
            },
            yaxis:{
                label: '<= importance <=',
                labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                renderer: $.jqplot.CategoryAxisRenderer,
            }
        },

        highlighter: {
            sizeAdjust: 8,
            formatString:'Grade: %1s',
            lineWidthAdjust: 4,
        },

        cursor: {
            show: false,
        }
    });

    // hack the ticks
    $('div.jqplot-yaxis-tick').each(function(){
        position = $(this).position();
        $(this).css({
            'z-index': '1',
            'cursor': 'pointer',
            'background-color': '#dbe3f0',
            'height': '79px',
            'width': (700 - $('.jqplot-event-canvas').width() - 60) + 'px',
            'top': (position['top'] - 30) + 'px',
            'line-height': '80px',
            'padding-right': '5px',
            'overflow': 'hidden',
        });
    });

    // add the labels
    $('div.jqplot-target').prepend($('<span>Criteria</span>').css({
        'position': 'absolute',
        'top': -15,
        'left': '25px',
        'font-size': '14px',
    }));
    $('div.jqplot-target').prepend($('<span>Worst</span>').css({
        'position': 'absolute',
        'top': -15,
        'left': (700 - $('.jqplot-event-canvas').width() - 4 ) + 'px',
        'font-size': '14px',
    }));
    $('div.jqplot-target').prepend($('<span>Best</span>').css({
        'position': 'absolute',
        'top': -15,
        'right': '12px',
        'font-size': '14px',
    }));

    /**
     * Tooltip on mouse over for criteria values
     */
    $('div.jqplot-yaxis-tick').hover(function(e){
        // get positions
        canvasPosition = $('.jqplot-event-canvas').position();
        tickPosition = $(this).position();
        graphPosition = $('#chartdiv').position();

        // get title
        title = $(this).html();
        width = $('.jqplot-event-canvas').width();

        // calculate widths
        leftWidth = parseInt(width / 2) - 10;
        rightWidth = parseInt(width / 2) - 10;
        if(width % 2 == 1)
        {
            rightWidth = rightWidth + 1;
        }

        // append the tooltip
        $('body').append('<div id="graphtooltip" class="white-background"><span>' + criteriaWorst[title] + '</span><span class="best">' + criteriaBest[title] + '</span></div>');

        // calculate margin
        margin = parseInt((80 - $('#graphtooltip').height()) / 2);

        // style the tooltip
        $('#graphtooltip')
            .css('width', width)
            .css('height', 79 + 'px')
            .css('top', (graphPosition['top'] + tickPosition['top'] + 40) + 'px')
            .css('left', (graphPosition['left'] + canvasPosition['left']) + 'px')
            .fadeIn('fast');
        $('#graphtooltip span').css({'width': leftWidth, 'margin-top': margin + 'px'});
        $('#graphtooltip span.right').css('width', rightWidth);

        if($.browser.msie)
        {
            $('#graphtooltip').removeClass('white-background');
        }
    },
    function(){
        // remove on mouse away
        $('#graphtooltip').fadeOut('fast').remove();
    });

    /**
     * Tooltip for weights
     */
    if($('#display_weighted').attr('checked'))
    {
        /* CONFIG */
        xOffset = 10;
        yOffset = 110;
        /* END CONFIG */
        $("div.jqplot-yaxis-tick").hover(function(e){
            $("body").append("<p id='weights'>Weight: "+ chartData['weights'][0][$(this).html()].toFixed(2)*100 +"%</p>");
            $("#weights")
                .css("top",(e.pageY - xOffset) + "px")
                .css("left",(e.pageX - yOffset) + "px")
                .fadeIn('fast');
        },
        function(){
            $("#weights").fadeOut('fast').remove();
        });
        $("div.jqplot-yaxis-tick").mousemove(function(e){
            $("#weights")
                .css("top",(e.pageY - xOffset) + "px")
                .css("left",(e.pageX - yOffset) + "px");
        });
    }

}

/**
 * Fetches data, handles checkboxes and plots the graph
 */
function buildGraph(force)
{
    // build weighted graph
    if( $('#display_weighted').attr('checked') )
    {
        scores = 'weightedScores';
        total = 'weightedTotal';
    }
    else
    {
        scores = 'scores';
        total = 'total';
    }

    // plotting variables
    data    = new Array();
    dataLegend  = new Array();
    colors  = new Array();

    // sort the list item by scores
    var mylist = $('#seriesPicker ul');
    var listitems = mylist.children('li').get();
    listitems.sort(function(a, b) {
       nameA = $(a).find('label').attr('for');
       nameB = $(b).find('label').attr('for');
       nrA = nameA.substr(nameA.length-1,nameA.length);
       nrB = nameB.substr(nameB.length-1,nameB.length);
       compA = chartData[total][nrA];
       compB = chartData[total][nrB];

       return (compA > compB) ? -1 : (compA < compB) ? 1 : 0;
    })
    $.each(listitems, function(idx, itm) {
        mylist.append(itm);
        name = $(itm).find('label').attr('for');
        nr = name.substr(name.length-1,name.length);
        $(itm).find('span.score').remove();
        $(itm).append('<span class="score">' + chartData[total][nr] + '</span>');
    });

    // select checkboxes?
    if($('#seriesPicker input[type=checkbox]:checked').length == 0)
    {
        if(force == null)
        {
            $('#chartdiv').empty();
            return;
        }
        $('#seriesPicker ul li:lt(2)').each(function(){
            $(this).find('input[type=checkbox]').attr('checked', 'checked');
        });
    }
    // build data for graph plotting
    $('#seriesPicker input[type=checkbox]:checked').each(function(){
        // get the series number
        name = $(this).attr('name');
        seriesNr = name.substr(name.length-1,name.length);

        // add data to this array
        data.push(chartData[scores][seriesNr]);
        colors.push(chartData['colorPool'][seriesNr]);
        dataLegend.push(chartData['legend'][seriesNr]);
    });

    // plot the graph
    $('#chartdiv').empty();
    plotGraph('chartdiv', data, '', colors, dataLegend);
    $('div.jqplot-xaxis-tick:first, div.jqplot-xaxis-tick:last').hide();
}

/**
 * On document load
 */
$(document).ready(function(){
    // create graph on page load
    buildGraph(true);

    // change the submit buttons
    $(function() {
        $("a.button").button();
    });

    // select all
    $('#select').click(function(event){
        $('#seriesPicker input[type=checkbox]').attr('checked', 'checked');
        buildGraph();
        $(this).removeClass('ui-state-focus');
        event.preventDefault();
    });

    // deselect all
    $('#deselect').click(function(event){
        $('#seriesPicker input[type=checkbox]').removeAttr('checked');
        $('#chartdiv').empty();
        $(this).removeClass('ui-state-focus');
        event.preventDefault();
    });

    /**
     * Replot the graph on checkbox selection
     */
    $('input:checkbox').click(function()
    {
        buildGraph();
    });
});
