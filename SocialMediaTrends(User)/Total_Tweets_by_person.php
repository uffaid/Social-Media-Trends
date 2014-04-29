<!DOCTYPE HTML>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<script type="text/javascript" src="jquery.min.js"></script>
		
	</head>
<?php
$count=0;
$name=array();
$tweet_count=array();
$con=mysql_connect("localhost","root","");
mysql_select_db("dbtwitter",$con);
$sql="SELECT * from screenname_code_table";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result))
{
$name[]=$row['screen_name'];
$count=(int)$row['Total_tweets'];
$tweet_count[]=$count;
}




//echo json_encode($array1);
//echo json_encode($array2);
?>
<script src="./script/js/highcharts.js"></script>
<script src="./script/js/modules/exporting.js"></script>

<div id="totalTweets" style="width: 1000px; height: 400px; margin: 0 auto"></div>
<script type="text/javascript">
$(function () {
        $('#totalTweets').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Twitter Count Of Persons'
            },
            subtitle: {
                text: 'Source: Twitter'
            },
            xAxis: {
                categories: <?php echo json_encode($name); ?>,
                title: {
                    text: null
                }
            },
            yAxis: {
               min: 0,
                title: {
                    text: 'Tweets Count',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' Tweets'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Tweet Count',
                data: <?php echo json_encode($tweet_count); ?>
            }]
        });
    });
    

		</script>
