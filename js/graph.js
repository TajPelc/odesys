/**
 * Function plots a graph with the given data to a given container.
 *
 * @param anchor string
 * @param data array
 * @param title string
 * @param legend array
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

    graphHeight = 80 * chartData.legend.length;

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
            background:'#F5F9FF',
            gridLineColor:'#ccc',
            borderColor:'#ccc',
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
}

/**
 * Fetches data, handles checkboxes and plots the graph
 */
function buildGraph()
{
    // plotting variables
    data    = new Array();
    legend  = new Array();
    colors  = new Array();

    // get all checked boxes
    checked = $('input[type=checkbox]:checked');

    // disable or enable checkboxes
    checked.each(function(){
        if(checked.length == 0){
            $('#chartdiv').empty();
            return;
        }
        else{
            $(this).removeAttr('disabled');
        }
    });

    // build data for graph plotting
    checked.each(function(){
        // get the series number
        name = $(this).attr('name');
        seriesNr = name.substr(name.length-1,name.length);

        // add data to this array
        data.push(chartData['data'][seriesNr]);
        colors.push(chartData['colorPool'][seriesNr]);
        legend.push(chartData['legend'][seriesNr]);
    });

    // plot the graph
    $('#chartdiv').empty();
    plotGraph('chartdiv', data, '', colors, legend);
    $('div.jqplot-xaxis-tick:first, div.jqplot-xaxis-tick:last').hide();
}
/**
 * On document load
 */
$(document).ready(function(){
    // create graph on page load
    buildGraph();

    // change the submit buttons
    $(function() {
        $("a.button").button();
    });

    // select all
    $('#select').click(function(event){
        $('input[type=checkbox]').attr('checked', 'checked');
        buildGraph();
        $(this).removeClass('ui-state-focus');
        event.preventDefault();
    });

    // deselect all
    $('#deselect').click(function(event){
        $('input[type=checkbox]').removeAttr('checked');
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
