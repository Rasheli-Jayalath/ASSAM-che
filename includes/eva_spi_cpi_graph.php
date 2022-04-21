<table border="0" cellpadding="0px" cellspacing="0px" align="left" width="100%"  style="padding-left:5px; margin:0;" > 
<tr> 
<td align="left" valign="top" width="50%" >

       
        <script type="text/javascript">
		
$(function () {
	 Highcharts.setOptions({
      colors: ["#4572A7","#DC143C"]
    });
        $('#container_cpi_spi').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'CPI & SPI'
            },
            subtitle: {
                text: 'Period: <?php echo date('M, Y',strtotime($start))." to ".date('M, Y',strtotime($end));?>'
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
                    text: 'CPI / SPI'
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%d-%m-%Y', this.x) +': '+ this.y +' ';
                }
            },
            
            series: [
		
			{
                name: '<?php echo "SPI";?>',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
				
				<?php echo GetSPIData($start,$end);?>
                    
                   
                ]
				,
				marker: {
               
                 radius : 5
            }
            },
			{
                name: '<?php echo "CPI";?>',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
				<?php echo GetCPIData($start,$end);?>
                    
                   
                ]
				,
				marker: {
               
                 radius : 5
            }
            }
			
			
			]
        });
    });
    

		</script>
        <table width="99%"  align="right" border="0" style="margin:5px 10px 5px 10px">
   
   <tr>
     <td height="99"  style="line-height:18px; text-align:justify; vertical-align:top">
     <div id="container_cpi_spi" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
     </td>
     
   </tr>
   
</table></td>
</tr>
</table>
