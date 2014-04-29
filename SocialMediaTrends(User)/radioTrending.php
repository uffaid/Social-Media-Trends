<?php
function remove_time($time)
{
$array_time=array();
$array_time='';
$array_removed='';
$array_time=explode(' ',$time);
$time_removed=$array_time[0].' '.$array_time[1].' '.$array_time[2].' '.$array_time[5];
return $time_removed;
} 
$choice=false;
$action='';
if (isset($_REQUEST['view_choice'])) {
$selected_radio = $_REQUEST['view_choice'];
	if ($selected_radio == 'r1') {
		$action='screenname_code_table';		
		$choice=true;
	}
	
	else if ($selected_radio == 'r2') {
		$action='topicname_code_table';
		$choice=true;
			
	}
} 
{
if($choice==true && $selected_radio == 'r1')
{
	$con= mysql_connect("localhost",'root',''); 
	if (!$con) { 
		die('Could not connect: ' . mysql_error()); 
	}
	$db_selected=mysql_select_db("dbtwitter", $con);
	if (!$db_selected) {
		die ('Can\'t use database : ' . mysql_error());
	}
	$query="SELECT * FROM ". $action;
	$result = mysql_query($query);
	$i=1;
	?>
<div class='row-fluid'>	
<div class="row" align='left'>
<form name="people_form" id="peopleForm">	
	<table class="table table-striped" style="width:30%">
	<h2>PEOPLE</h2>
	<thead>
	<tr><td>SNo</td>
		<td>PERSONS</td></tr>
		</thead>

	<?php	
	while($row = mysql_fetch_array($result))
	{
		$name=$row['actual_name'];
		$id=$row['screen_id'];
		?>

			<tbody>
				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $name;?></td>
					<td><input type='radio' name='selected_person_id' value="<?php echo $id;?>" /></td>
				</tr>
			</tbody>
<?php			
	$i++;
	}// end of while
?>
</table>
<input type="button" name="view_person_button" value="View" class='btn btn-primary' onclick="getPersonGraph()">	
<div id="peopleGraphArea"></div>
	</form>
</div>
<!-- code for follower count bar graph goes here-->
<?php
//$count=0;
$persons_name=array();
$followers_count=array();
$con=mysql_connect("localhost","root","");
mysql_select_db("dbtwitter",$con);
$result=mysql_query("SELECT screen_name, MAX( followers_count ) AS total_followers FROM people_rawdata GROUP BY screen_name");
while($row=mysql_fetch_array($result))
{
$screen_name=$row['screen_name'];
$followers_count_var=$row['total_followers'];
$followers_count[]=(int)$followers_count_var;
$result1=mysql_query("SELECT actual_name FROM screenname_code_table where screen_name='$screen_name'");
while($row1=mysql_fetch_array($result1))
{
$actual_name=$row1['actual_name'];
$persons_name[]=$actual_name;
}
}
$result1=mysql_query("SELECT min(To_date) as min_date from screenname_code_table");
while($row1=mysql_fetch_array($result1))
{
$min_date=$row1['min_date'];
}
$get_min_date=remove_time($min_date);
?>
<div id="follower_count_graph" style="width: 900px; height: 400px; border:2px solid; border-radius:10px; box-shadow: 1px 1px 1px #7A0000; margin: 0 auto"></div>
</div>
<script type="text/javascript">
$(function () {
        $('#follower_count_graph').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Updated Follower Count till <?php echo $get_min_date; ?>'
            },
            subtitle: {
                text: 'Source: Twitter'
            },
            xAxis: {
                categories: <?php echo json_encode($persons_name); ?>,
                title: {
                    text: null
                }
            },
            yAxis: {
               min: 0,
                title: {
                    text: 'Twitter Followers (MILLIONS)',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' Followers'
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
                name: 'Follower Count',
                data: <?php echo json_encode($followers_count); ?>
            }]
        });
    });
    </script>
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
$name[]=$row['actual_name'];
$count=(int)$row['total_tweets'];
$tweet_count[]=$count;
}
?>
<br><div id="totalTweets" style="width: 900px; height: 400px; border:2px solid; border-radius:10px; box-shadow: 1px 1px 1px #7A0000; margin: 0 auto"></div>
<script type="text/javascript">
$(function () {
        $('#totalTweets').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Tweets By Person'
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
		<br>
		<br><br>

<?php	
	mysql_close($con);
}

elseif($choice==true && $selected_radio =='r2'){
	$con= mysql_connect("localhost",'root',''); 
	if (!$con) { 
		die('Could not connect: ' . mysql_error()); 
	}
	$db_selected=mysql_select_db("dbtwitter", $con);
	if (!$db_selected) {
		die ('Can\'t use database : ' . mysql_error());
	}
	$query="SELECT * FROM ". $action;
	$result = mysql_query($query);
	$i=1;
	?>
	<form name="topics_form" id="topicForm">
	<table class="table table-striped" style="width:30%">
	<h2>Keywords</h2>
	<thead>
	<tr><td>SNo</td>
		<td>Keyword</td></tr>		
	</thead>
	<?php	
	while($row = mysql_fetch_array($result))
	{
		$tname=$row['topic_name'];
		$tid=$row['topic_id'];
	?>

			<tbody>
				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $tname;?></td>
					<td><input type='radio' name='topic_id' value="<?php echo $tid;?>" /></td>
				</tr>
			</tbody>
<?php			
	$i++;
	}// end of while
?>
</table>
<input type="button" name="view_keyword_button" value="View" class='btn btn-primary' onclick="getTopicWordCloud()">
<div id="topicGraphArea"></div>
</form>
<br>
<hr>
<br>
 <?php		 
function remove_redundant($created_at)
{
$count=0;
$freq_list=array();
foreach($created_at as $pos=>$word)
{
if(in_array($word,$freq_list)==false)
{
$freq_list[]=$word;
}
}
return $freq_list;
}


function sort_date($freq_list)
{
$length=count($freq_list);
for($count=1;$count<$length;$count++)
{
for($count1=0;$count1<$length-1;$count1++)
{
if(strtotime($freq_list[$count1])>strtotime($freq_list[$count1+1]))
               {
               $temp=$freq_list[$count1];
               $freq_list[$count1]=$freq_list[$count1+1];
               $freq_list[$count1+1]=$temp;
               }
			   }
			   }
return($freq_list);
}
//
$count= 0;   
$topic=array();
$array1=array();
$con=mysql_connect("localhost","root","");
mysql_select_db("dbtwitter",$con);

$topic3=mysql_query("SELECT Date_noTime from twitterrawdata");
while($row3=mysql_fetch_array($topic3))
{
$created_at[]=$row3['Date_noTime'];
}
$createdate=remove_redundant($created_at);
$sorted_date=sort_date($createdate);
//echo json_encode($sorted_date);
$topic1=mysql_query("select * from topicname_code_table");
$i=0;
while($row1=mysql_fetch_array($topic1))
{
$topic_id=$row1['topic_id'];
$topic_name=$row1['topic_name'];
foreach($sorted_date as $sorted_date1)
{
$topic=mysql_query("SELECT COUNT( * ) as Frequency_of_tweets , topic_id, Date_noTime FROM  `twitterrawdata`  GROUP BY topic_id, Date_noTime having topic_id='$topic_id' and Date_noTime='$sorted_date1'");
$value=mysql_affected_rows();
if($value==0)
{
$array1[]=0;
}
while($row=mysql_fetch_array($topic))
{
$array1[]=(int)$row['Frequency_of_tweets'];
}
}
$data[$count]['name']=$topic_name;
$data[$count]['data']=$array1;
$array1="";
$count++;
}
//echo json_encode($array1);
//echo json_encode($data)	?>	

<div id="topic_trends_graph" style="width: 1000px; height: 400px; border:2px solid; border-radius:10px; box-shadow: 5px 5px 5px #7A0000; margin: 0 auto"></div>
		<script type="text/javascript">
$(function () {
        $('#topic_trends_graph').highcharts({
            title: {
                text: 'Weekly trending topics',
                x: -20 //center
            },
            subtitle: {
                text: 'Source: Twitter.com',
                x: -20
            },
            xAxis: {
                categories: <?php echo json_encode($sorted_date); ?>,
			    
				
            },
            yAxis: {
                title: {
                    text: 'tweets in hundreds',
					y:0
                },
				
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ' tweets'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: <?php echo json_encode($data);?>,
			
        });
    });
    

		</script>
		<br>
		<br>
		<br>
		
<?php	
	mysql_close($con);
	}
}
?>

<script src='./script/javascript.js'></script>
<script src="./script/js/highcharts.js"></script>
<script src="./script/js/modules/exporting.js"></script>