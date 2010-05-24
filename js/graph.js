/**
 * Function plots a graph with the given data to a given container.
 *
 * @param anchor string
 * @param data array
 * @param title string
 * @param legend array
 * @return void
 */
function plotGraph(anchor, data, title, legend)
{
    $.jqplot(anchor, data, {
        sortData: false,

        seriesColors: [ "#ff5800", "#ffaa00", "#ff58ff","#005800" ],

        legend: {
            show: true,
            location: 'se',
            xoffset: -510,
            yoffset: 20,
        },

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

        series:[
            {title: legend[0]},
            {title: legend[1]},
            {title: legend[2]},
            {title: legend[3]},
        ],

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
        // grab data
        data = new Array();

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
                }
            });

            // plot the graph
            plotGraph('chartdiv', data, 'ABACON', result['legend']);
        });
    });
});
