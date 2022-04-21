<script type="text/javascript">
$(function () {
        $('#containerh').highcharts({
            chart: {
                type: 'spline'
            },
             title: {
		 text: '<?php echo '<span style="font-size:22px;font-weight:bold; color:#000; font-family:Soleto, sans-serif;width:100%; text-align:left">'.PROJECT_PROG.'</span>'; ?>',
        floating: true,
        align: 'left',
        x: -12,
        y: 5
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
                        Highcharts.dateFormat('%d-%m-%Y', this.x) +': '+ this.y +' <?php echo $unit;?>';
                }
            },
            legend: {
            layout: 'vertical',
            align: 'left',
            x: 90,
            verticalAlign: 'top',
            y: 50,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
            series: [
		{
                name: '<?php echo trim(stripslashes($reportdata['sdetail']));
				echo "Actual";?>',
                
                data: [
				<?php echo GetActualQtysOutcomeLevelH($aparentgroup,$aweight);?>
       
                ],
				marker: {
               
                 radius : 1
            }
            }
			
			,{
                name: 'Planned',
                data: [
				<?php echo GetPlannedQtysOutcomeLevelH($aparentgroup,$aweight);?>
                  
                ]
            ,
				marker: {
               
                 radius : 1
            }}
			
			]
        });
    });
    

		</script>
        <table width="100%"  align="left" border="0" style="margin:0">
   
   <tr>
     <td height="99"  style="line-height:18px; text-align:justify; vertical-align:top">
     <div id="containerh" style="min-width: 300px; height: 150px; margin: 0 auto"></div>
     </td>
     
   </tr>
   
</table>