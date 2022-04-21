<table border="0" cellpadding="0px" cellspacing="0px" align="left" width="100%"  style="padding-left:5px; margin:0;" > 
<tr> 
<td align="left" valign="top" width="50%" >

   
        <script type="text/javascript">
		
/*$(function () {
        $('#container_cv').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Cost Variance'
            },
            subtitle: {
                text: '<?php //echo $max_date;?>'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                   month: '%m-%Y',
                year: '%Y'
                }
            },
            yAxis: {
                title: {
                    text: '% Done'
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%d-%m-%Y', this.x) +': '+ this.y +' $';
                }
            },
            
            series: [
		
			{
                name: '<?php echo "CV";?>',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
				
				<?php echo GetCostVarianceData($start,$end);?>
                    
                   
                ]
				,
				marker: {
               
                 radius : 1
            }
            }
			
			]
        });
    });*/
    

		</script>
        
        <script type="text/javascript">
$(function () {
        $('#container_cvv').highcharts({
            chart: {
                type: 'areaspline'
            },
            title: {
                text: 'Cost Variance'
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
                   <?php echo GetCostVarianceMonth($start,$end);?>
					  
                ],
                plotBands: [{ // visualize the weekend
                   
                    color: 'rgba(68, 170, 213, .2)'
                }]
            },
            yAxis: {
                title: {
                    text: 'Cost Variance'
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
                name: 'CV',
                data: [<?php echo GetCostVarianceData($start,$end);?>]
            }]
        });
    });
    

		</script>
        <table width="99%"  align="right" border="0" style="margin:5px 10px 5px 10px">
   
   <tr>
     <td height="99"  style="line-height:18px; text-align:justify; vertical-align:top">
     <div id="container_cvv" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
     </td>
     
   </tr>
   
</table></td>
</tr>
</table>
