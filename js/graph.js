/**
 * Function plots a graph with the given data to a given container.
 *
 * @param anchor string
 * @param data array
 * @param title string
 * @param legend array
 * @return void
 */
function plotGraph(anchor, data, title, colors)
{
    seriesArray = new Array();
    for(i=0; i<colors.length; i++)
    {
        Series = new Object();
        Series.label = legend[i];
        Series.color = colors[i];
        seriesArray.push(Series);
    }

    $.jqplot(anchor, data, {
        sortData: false,

        title: {
            text: title,
            show: true,
            fontSize: '15pt',
            textColor: 'black',
        },

        grid:{
            background:'#EBF0FA',
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
                    fontSize:'10pt',
                },
            },
            yaxis:{
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
 * On document load
 */
$(document).ready(function(){
    /**
     * Replot the graph on checkbox selection
     */
    $('input:checkbox').click(function()
    {
        // define the color pool
        colorPool = [ "#ff5800", "#ffaa00", "#ff58ff","#005800" ];

        // plotting variables
        data    = new Array();
        legend  = new Array();
        colors  = new Array();

        // ajax request for plotting data
        $.get(document.location, function(result){
            // traverse checkboxes, check if checked
            $('input:checkbox').each(function($checkbox){
                // checked!
                if($(this).attr('checked'))
                {
                    name = $(this).attr('name');
                    seriesNr = name.substr(name.length-1,name.length);

                    // add data to this array
                    data.push(result['data'][seriesNr]);
                    colors.push(colorPool[seriesNr]);
                }
            });

            // plot the graph
            $('#chartdiv').empty();
            plotGraph('chartdiv', data, 'ABACON', colors);
        });
    });
});
