<table border="0" cellpadding="0px" cellspacing="0px" align="left" width="100%"  style="padding-left:5px; margin:0;" > 
<tr> 
<td align="left" valign="top" width="50%" >

       
        <script type="text/javascript">
		
$(function () {
	 Highcharts.setOptions({
      colors: ["#4572A7",'#89A54E',"#DC143C"]
    });
        $('#container').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Earned Value Analysis - Civilworks'
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
                    text: '$ Cost'
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
                name: '<?php echo "Planned";?>',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
				<?php echo GetPlannedData($start,$end);?>
                    
                   
                ]
				,
				marker: {
               
                 radius : 3
            }
            }
			,
			{
                name: '<?php echo "Earned";?>',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
				
				<?php echo GetEarnedData($start,$end);?>
                    
                   
                ]
				,
				marker: {
               
                 radius : 3
            }
            }
			,
			{
                name: '<?php echo "Actual";?>',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
				
				<?php echo GetActualData($start,$end);?>
                    
                   
                ]
				,
				marker: {
               
                 radius : 3
            }
            }
			]
        });
    });
    

		</script>
        <table width="99%"  align="right" border="0" style="margin:5px 10px 5px 10px">
   
   <tr>
     <td height="99"  style="line-height:18px; text-align:justify; vertical-align:top">
     <div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
     </td>
     
   </tr>
   
</table></td>
</tr>
</table>
