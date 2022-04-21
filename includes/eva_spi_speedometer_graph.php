<table border="0" cellpadding="0px" cellspacing="0px" align="left" width="100%"  style="padding:0; margin:0;" > 
<tr> 
<td align="left" valign="top" width="50%" >

       <?php  $SPI=GetSPIValue($last);
	   $SPI=number_format($SPI,2);
	    $mi=date('m',strtotime($last));
		$yi=date('Y',strtotime($last));
		$days=cal_days_in_month(CAL_GREGORIAN,$mi,$yi);
		
		$last_date=$yi."-".$mi."-".$days;
	?>
        <script type="text/javascript">
$(function () {
	
    $('#container_spi').highcharts({
	
	    chart: {
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
	    },
	    
	    title: {
	        text: 'Schedule Performance Index'
	    },
	    
		subtitle: {
                text: 'as on <?php echo date('M, d, Y',strtotime($last_date));?>'
            },
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 1,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	       
	    // the value axis
	    yAxis: {
	        min: 0,
	        max: 2,
	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: 'SPI'
	        },
	        plotBands: [{
	            from: 0,
	            to: 0.8,
	            color: '#DF5353' // red
	        }, {
	            from: 0.8,
	            to: 2,
	            color: '#55BF3B' // yellow
	        }]        
	    },
	
	    series: [{
	        name: 'SPI',
	        data: [<?php echo $SPI;?>],
	        tooltip: {
	            valueSuffix: ' '
	        }
	    }]
	
	}
	);
});
		</script>
        <table width="90%"  align="right" border="0" style="margin:5px 10px 5px 10px">
   
   <tr>
     <td height="99"  style="line-height:18px; text-align:justify; vertical-align:top">
     <div id="container_spi" style="min-width: 310px; max-width: 400px; height: 300px; margin: 0 auto"></div>
     </td>
     
   </tr>
   
</table></td>
</tr>
</table>
