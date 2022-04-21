<table border="0" cellpadding="0px" cellspacing="0px" align="left" width="100%"  style="padding-left:5px; margin:0;" > 
<tr> 
<td align="left" valign="top" width="50%" >

   
        
        <script type="text/javascript">
$(function () {
        $('#container_sv').highcharts({
            chart: {
                type: 'areaspline'
            },
            title: {
                text: 'Schedule Variance'
            },
            subtitle: {
                text: 'Period: <?php echo date('M, Y',strtotime($start))." to ".date('M, Y',strtotime($end));?>'
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 150,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF'
            },
            xAxis: {
				 type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                },
               categories: [
                   <?php echo GetScheduleVarianceMonth($start,$end);?>
					  
                ],
                plotBands: [{ // visualize the weekend
                    
                    color: 'rgba(68, 170, 213, .2)'
                }]
            },
            yAxis: {
                title: {
                    text: 'Schedule Variance'
                }
            },
            tooltip: {
                shared: true,
                valueSuffix: ' units'
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.5
                }
            },
            series: [{
                name: 'SV',
                data: [<?php echo GetScheduleVarianceData($start,$end);?>]
            }]
        });
    });
    

		</script>
        <table width="99%"  align="right" border="0" style="margin:5px 10px 5px 10px">
   
   <tr>
     <td height="99"  style="line-height:18px; text-align:justify; vertical-align:top">
     <div id="container_sv" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
     </td>
     
   </tr>
   
</table></td>
</tr>
</table>
